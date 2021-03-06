<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;

/**
 * 下架模型
 */
class UnderModel extends Model
{   

    /**
     * 下架申请
     * @param  [type] $apply [description]
     * @return [type]        [description]
     */
    public function applyUnder($apply)
    {
        if (!$apply) {
            $return['code'] = 0;
            $return['msg']  = '业务/资源无法申请下架';
            return $return;
        }

        switch ($apply['type']) {
            case 1:
                $business_number = $apply['business_number'];
                if(isset($apply['parent_business']) && $apply['parent_business'] != 0){//是机柜业务下的机器下架

                    $business_result = DB::table('tz_cabinet_machine')->where(['business_number' => $business_number])->whereNull('deleted_at')->select('remove_status','business_type','resource_type as business_type','resource_sn as machine_number')->first();
                
                } else {

                    $business_result = DB::table('tz_business')->where(['business_number' => $business_number])->whereNull('deleted_at')->select('remove_status', 'business_number', 'business_type', 'machine_number','order_number','id')->first();
                
                }
                
                if (empty($business_result)) {//不存在业务
                    $return['code'] = 0;
                    $return['msg']  = '(#101)无此业务，无法申请下架';
                    return $return;
                }

                if ($business_result->remove_status > 0) {//业务已处于下架状态的
                    $return['code'] = 0;
                    $return['msg']  = '(#102)此业务正在下架中，请勿重复申请操作!';
                    return $return;
                }

                $remove['remove_reason'] = $apply['remove_reason'];//下架缘由
                $remove['remove_status'] = 1;//申请下架的状态

                DB::beginTransaction();//开启事务

                if(isset($apply['parent_business']) && $apply['parent_business'] != 0){

                    $business_remove = DB::table('tz_cabinet_machine')->where(['business_number' => $business_number])->whereNull('deleted_at')->update(['remove_status'=>1,'remove_note'=>$apply['remove_reason']]);
                
                } else {

                    $business_remove = DB::table('tz_business')->where(['business_number' => $business_number])->whereNull('deleted_at')->update($remove);//更新业务的下架状态
                
                }
                
                if ($business_remove == 0) {//更新失败
                    DB::rollBack();
                    $return['code'] = 0;
                    $return['msg']  = '(#103)业务申请下架失败';
                    return $return;
                }

                if(isset($apply['parent_business']) && $apply['parent_business'] == 0){

                    if($business_result->order_number != null){//存在机器的订单，则同时对该机器的订单进行下架状态的改变
                        $order_removes = DB::table('tz_orders')->where(['order_sn'=>$business_result->order_number])->whereNull('deleted_at')->update($remove);
                        if($order_removes == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg']  = '(#104)业务申请下架失败';
                            return $return;
                        }
                    }

                    //查找业务关联的资源
                    $resources = DB::table('tz_orders')->where(['business_sn' => $business_number, 'remove_status' => 0])->where('resource_type', '>', 3)->whereNull('deleted_at')->orderBy('end_time', 'desc')->get(['order_sn', 'resource_type', 'machine_sn', 'resource', 'price', 'end_time'])->groupBy('machine_sn');

                    $resource = $resources->map(function($item,$key) use ($business_number){//根据资源编号获取对应资源的最新一条订单（$key为$all的键）,map参考laravel模型的集合的可用方法
                        $business['machine_sn']    = $key;
                        $business['business_sn']   = $business_number;
                        $business['remove_status'] = 0;
                        return DB::table('tz_orders')->where($business)->orderBy('end_time', 'desc')->whereNull('deleted_at')->select('order_sn', 'resource_type', 'machine_sn', 'resource', 'price', 'end_time', 'order_status')->first();
                    });
    
                    if (!empty($resource)) {//存在关联业务则继续对关联的资源进行同步下架
                        foreach ($resource as $resource_key => $resource_value) {
                            $order_remove['remove_reason'] = '关联业务' . $business_number . '申请下架，关联业务资源同步下架';
                            $order_remove['remove_status'] = 1;
                            $order_row                     = DB::table('tz_orders')->where(['order_sn' => $resource_value->order_sn])->whereNull('deleted_at')->update($order_remove);
                            if ($order_row == 0) {//关联业务的资源同步下架失败
                                DB::rollBack();
                                $return['code'] = 0;
                                $return['msg']  = '(#105)业务关联资源申请下架失败';
                                return $return;
                            }
                        }
                    }

                    if($business_result->business_type == 3){//当是机柜下架的时候机柜下的主机也一同下架

                        $cabinet_machine = DB::table('tz_cabinet_machine')->where(['parent_business'=>$business_result->id,'remove_status'=>0])->whereNull('deleted_at')->get(['id','business_number']);
                        
                        if(!$cabinet_machine->isEmpty()){
                            $update = DB::table('tz_cabinet_machine')->where(['parent_business'=>$business_result->id])->whereNull('deleted_at')->update(['remove_status'=>1,'remove_note'=>$apply['remove_reason']]); 
                            if($update == 0){
                                DB::rollBack();
                                $return['code'] = 0;
                                $return['msg']  = '(#106)机柜业务下关联机器资源申请下架失败';
                                return $return;
                            }
                        }

                    }
    
                }
                
                DB::commit();
                $return['code'] = 1;
                $return['msg']  = '业务:' . $apply['business_number'] . '申请下架成功,等待处理';
                return $return;
                break;
            case 2:
                $order_result = DB::table('tz_orders')->where(['order_sn' => $apply['order_sn']])->whereNull('deleted_at')->select('order_sn', 'remove_status', 'machine_sn', 'end_time', 'business_sn')->first();
                if (empty($order_result)) {
                    $return['code'] = 0;
                    $return['msg']  = '无此资源的信息,无法下架!';
                    return $return;
                }
                if ($order_result->remove_status > 0) {
                    $return['code'] = 0;
                    $return['msg']  = '此资源正在下架中,请勿重复提交申请';
                    return $return;
                }
                $end_time = DB::table('tz_orders')->where(['machine_sn' => $order_result->machine_sn, 'business_sn' => $order_result->business_sn])->whereNull('deleted_at')->orderBy('end_time', 'desc')->select('end_time', 'remove_status')->first();
                if (!empty($end_time)) {
                    if ($end_time->remove_status > 0) {
                        $return['code'] = 0;
                        $return['msg']  = '此资源正在下架中,请勿重复提交申请';
                        return $return;
                    }
                    if ($order_result->end_time != $end_time->end_time) {
                        $return['code'] = 0;
                        $return['msg']  = '此资源的信息不是最新，请查找最新';
                        return $return;
                    }
                }
                $remove['remove_status'] = 1;
                $remove['remove_reason'] = isset($apply['remove_reason'])?$apply['remove_reason']:'下架';
                $update                  = DB::table('tz_orders')->where(['order_sn' => $apply['order_sn']])->whereNull('deleted_at')->update($remove);
                if ($update == 0) {
                    $return['code'] = 0;
                    $return['msg']  = '资源申请下架失败';

                } else {
                    $return['code'] = 1;
                    $return['msg']  = '资源申请下架成功';
                }
                return $return;
                break;
            default:
                $return['code'] = 0;
                $return['msg']  = '无对应的资源/业务可以下架';
                return $return;
                break;
        }//switch结束
    }//方法结束

    /**
     * 获取下架的历史记录
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function underHistory($type)
    {
        if (!$type) {
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg']  = '无法获取下架历史记录';
            return $return;
        }
        $clerk_id = Admin::user()->id;
        $slug = DB::table('oa_staff')->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                ->where(['oa_staff.admin_users_id'=> $clerk_id])
                ->select('tz_jobs.slug')
                ->first();
        if(empty($slug)){
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '请先完善您的个人信息';
            return $return;
        }
        switch ($type['type']) {
            case 1:
                if($slug->slug != 3){//非业务员进入此区间
                    if(Admin::user()->inRoles(['operations','finance','HR','product','net_sec'])){//不是主管的按是否自己客户查看
                        $where = ['sales_id' => Admin::user()->id];
                        $machine = ['sales' => Admin::user()->id];
                    } else {//主管人员查看客户信息
                        $where = [];
                        $machine = [];
                    }
                } else {//是业务人员按客户所绑定业务员查看
                    $where = ['sales_id' => Admin::user()->id];
                    $machine = ['sales' => Admin::user()->id];
                }
                $history = DB::table('tz_business')->where($where)->whereBetween('remove_status',[1,4])->whereNull('deleted_at')->orderBy('updated_at', 'desc')->select('id','client_id', 'sales_id', 'business_number', 'machine_number', 'business_type', 'business_note', 'remove_reason', 'resource_detail', 'remove_status','money as price','length','updated_at')->get();
                $history->map(function($history_value,$history_key){
                    $business_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
                    $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
                    $history_value->resourcetype  = $business_type[$history_value->business_type];
                    $history_value->remove_status = $remove_status[$history_value->remove_status];
                    $history_value->sales_name = DB::table('admin_users')->where(['id'=> $history_value->sales_id])->value('name');
                    $history_value->client_name = DB::table('tz_users')->where(['id'=> $history_value->client_id])->value('nickname');
                    $resource_detail = json_decode($history_value->resource_detail);
                    $ip = isset($resource_detail->ip) ? $resource_detail->ip : '0.0.0.0';
                    $history_value->ip = $ip;
                });

                $cabinet_machine = DB::table('tz_cabinet_machine')->where($machine)->whereBetween('remove_status',[1,4])->whereNull('deleted_at')->orderBy('updated_at', 'desc')->select('id','customer as client_id','sales as sales_id','business_number','resource_sn as machine_number','resource_type as business_type','business_note','remove_note as remove_reason','remove_status','price','duration as length','updated_at')->get();
                $cabinet_machine->map(function($item,$key){
                    $business_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
                    $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
                    $item->resourcetype  = $business_type[$item->business_type];
                    $item->remove_status = $remove_status[$item->remove_status];
                    $item->sales_name = DB::table('admin_users')->where(['id'=> $item->sales_id])->value('name');
                    $item->client_name = DB::table('tz_users')->where(['id'=> $item->client_id])->value('nickname');
                    $resource_detail = DB::table('tz_cabinet_machine_detail')->where(['business_id'=>$item->id])->value('detail');
                    $item->resource_detail = $resource_detail;
                    $item->ip = isset($resource_detail->ip) ? $resource_detail->ip : '0.0.0.0';
                });
                $history = array_merge($history->toArray(),$cabinet_machine->toArray());
                $updated_at = array_column($history,'updated_at');
                array_multisort($updated_at,SORT_DESC,$history);
                $return['data'] = $history;
                $return['code'] = 1;
                $return['msg']  = '获取机器下架记录数据成功';
                return $return;
                break;
            case 2:
                if($slug->slug != 3){//非业务员进入此区间
                    if(Admin::user()->inRoles(['operations','finance','HR','product','net_sec'])){//不是主管的按是否自己客户查看
                        $where = ['business_id' => Admin::user()->id];
                    } else {//主管人员查看客户信息
                        $where = [];
                    }
                } else {//是业务人员按客户所绑定业务员查看
                    $where = ['business_id' => Admin::user()->id];
                }
                $history = DB::table('tz_orders')->where($where)->where('resource_type', '>', 3)->whereNull('deleted_at')->whereBetween('remove_status',[1,4])->orderBy('updated_at', 'desc')->select('id','business_sn', 'order_sn', 'customer_id', 'resource_type', 'business_id', 'machine_sn', 'resource', 'remove_status', 'remove_reason','price','duration as length','updated_at')->get();
                if (!empty($history)) {
                    $history->map(function($history_value,$history_key){
                        $resource_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜', 4 => 'IP', 5 => 'CPU', 6 => '硬盘', 7 => '内存', 8 => '带宽', 9 => '防护', 10 => 'cdn', 11 => '高防IP'];
                        $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
                        $history_value->resourcetype  = $resource_type[$history_value->resource_type];
                        $history_value->remove_status = $remove_status[$history_value->remove_status];
                        $history_value->business_name = DB::table('admin_users')->where(['id'=> $history_value->business_id])->value('name');
                        $client_name = DB::table('tz_users')->where(['id'=> $history_value->customer_id])->value('nickname');
                        $history_value->customer_name = $client_name;
                    });
                    $return['data'] = $history;
                    $return['code'] = 1;
                    $return['msg']  = '获取资源下架记录数据成功';
                } else {
                    $return['data'] = [];
                    $return['code'] = 0;
                    $return['msg']  = '暂无下架资源数据';
                }
                return $return;
                break;
            default:
                $return['data'] = [];
                $return['code'] = 0;
                $return['msg']  = '暂无下架历史记录';
                return $return;
                break;
        }//switch结束
    }//方法结束

    /**
     * 对下架的申请进行操作
     * @param  [type] $edit [description]
     * @return [type]       [description]
     */
    public function doUnder($edit)
    {
        if (!$edit) {
            $return['code'] = 0;
            $return['msg']  = '你无法对业务/资源进行下架处理';
            return $return;
        }
        
        switch ($edit['type']) {
            case 1:
                if(isset($edit['parent_business']) && $edit['parent_business'] != 0){//是机柜业务下的机器下架
                    $business = DB::table('tz_cabinet_machine as machine')->join('tz_cabinet_machine_detail as detail','machine.id','=','detail.business_id')->where(['business_number' => $edit['business_number']])->select('remove_status', 'remove_note as remove_reason', 'resource_type as business_type', 'resource_sn as machine_number', 'business_number','detail as resource_detail')->first();
                } else {
                    $business = DB::table('tz_business')->where(['business_number' => $edit['business_number']])->select('remove_status', 'remove_reason', 'business_type', 'machine_number', 'business_number', 'resource_detail','order_number')->first();
                }
                
                if (empty($business)) {//不存在需要下架的业务，直接返回
                    $return['code'] = 0;
                    $return['msg']  = '(#101)无对应业务';
                    return $return;
                }
                if ($business->remove_status < 1 || $business->remove_status == 4) {//当业务未提交申请或已下架，直接返回
                    $return['code'] = 0;
                    $return['msg']  = '(#102)业务已完成下架/暂未提交下架申请';
                    return $return;
                }
                if (isset($edit['remove_status'])) {
                    if($business->remove_status == 1){
                        $update['remove_reason'] = $business->remove_reason . '驳回原因:' . $edit['remove_reason'];
                        $update['remove_status'] = $edit['remove_status'];
                        $update['machineroom']   = 0;
                    }
                    
                } else {
                    switch ($business->remove_status) {
                        case 1:
                            $update['remove_status'] = 2;
                            $update['machineroom']   = DB::table('idc_machineroom')->where(['id' => json_decode($business->resource_detail)->machineroom_id])->value('list_order');
                            break;
                        case 2:
                            $update['remove_status'] = 3;
                            break;
                        case 3:
                            $update['remove_status'] = 4;
                            break;
                    }
                }
                DB::beginTransaction();//开启事务处理
                if ($business->remove_status == 3) {
                    switch ($business->business_type) {
                        case 1:
                            $rent['used_status']  = 0;
                            $rent['own_business'] = Null;
                            $rent['business_end'] = Null;
                            $rent['loginname']    = isset($edit['loginname']) ? $edit['loginname'] : 'administrator';
                            $rent['loginpass']    = isset($edit['loginpass']) ? $edit['loginpass'] : 'esJ04&' . substr(time(), 8, 2);
                            $row                  = DB::table('idc_machine')->where(['machine_num' => $business->machine_number, 'own_business' => $edit['business_number'], 'business_type' => 1])->update($rent);
                            break;
                        case 2:
                            $ip_id = DB::table('idc_machine')->where(['machine_num'=>$business->machine_number])->value('ip_id');
                            if(!empty($ip_id) && $ip_id !=0){
                                $ip_update = DB::table('idc_ips')->where(['id'=>$ip_id])->update(['ip_status'=>0,'own_business'=>Null,'mac_num'=>Null]);
                                if($ip_update == 0){
                                    DB::rollBack();
                                    $return['code'] = 0;
                                    $return['msg']  = '(#106)业务相关机器下架状态修改失败';
                                    return $return;
                                }
                            }
                            $host['used_status']    = 0;
                            $host['own_business']   = Null;
                            $host['business_end']   = Null;
                            $host['machine_status'] = 1;
                            $host['business_type'] = 4;
                            $host['ip_id'] = 0;
                            $host['cabinet'] = 0;
                            $row                    = DB::table('idc_machine')->where(['machine_num' => $business->machine_number, 'own_business' => $edit['business_number'], 'business_type' => 2])->update($host);
                            break;
                        case 3:
                            $cabinet = DB::table('idc_cabinet')->where(['cabinet_id' => $business->machine_number])->select('own_business')->first();//获取机柜原来的业务号
                            if (!empty($cabinet)) {
                                $array = explode(',', $cabinet->own_business);//先将原本的业务数据转换为数组
                            } else {
                                $array = [];
                            }
                            $key = array_search($business->business_number, $array);//查找要删除的业务编号在数组的位置的键
                            array_splice($array, $key, 1);//根据查找的对应键进行删除
                            $own_business                   = implode(',', $array);//将数组转换为字符串
                            $cabinet_update['own_business'] = $own_business;
                            $cabinet_update['business_end'] = Null;
                            $row                            = DB::table('idc_cabinet')->where(['cabinet_id' => $business->machine_number])->update($cabinet_update);
                            break;
                        default:
                            $row = 1;
                            break;
                    }
                    if ($row == 0) {
                        DB::rollBack();
                        $return['code'] = 0;
                        $return['msg']  = '(#103)业务相关机器下架状态修改失败';
                    }
                    $update['remove_status'] = 4;

                }
                $update['updated_at'] = date('Y-m-d H:i:s',time());
                if(isset($edit['parent_business']) && $edit['parent_business'] == 0){
                    
                    if($business->order_number != null){//存在机器的订单，则同时对该机器的订单进行下架状态的改变
                        $order_removes = DB::table('tz_orders')->where(['order_sn'=>$business->order_number])->update($update);
                        if($order_removes == 0){
                            DB::rollBack();
                            $return['code'] = 0;
                            $return['msg']  = '(#104)业务下架状态修改失败';
                            return $return;
                        }
                    }
                    $remove = DB::table('tz_business')->where(['business_number' => $edit['business_number']])->update($update);
                } else {
                    
                    $cabinet_update['remove_status'] = $update['remove_status'];
                    if(isset($update['updated_at'])){
                        $cabinet_update['updated_at'] = $update['updated_at'];
                    }
                    if(isset($update['remove_reason'])){
                        $cabinet_update['remove_note'] = $update['remove_reason'];
                    }
                    $remove = DB::table('tz_cabinet_machine')->where(['business_number' => $edit['business_number']])->update($cabinet_update);
                }
                
                if ($remove == 0) {
                    DB::rollBack();
                    $return['code'] = 0;
                    $return['msg']  = '(#105)业务下架状态修改失败';
                } else {
                    DB::commit();
                    $return['code'] = 1;
                    $return['msg']  = '下架完成';
                    if ($business->business_type == 1 && $update['remove_status'] == 4) {
                        $return['msg'] = '主机为' . $business->machine_number . '的资源下架修改成功' . '账户:' . $rent['loginname'] . ',密码:' . $rent['loginpass'];
                    } elseif ($update['remove_status'] == 2) {
                        $return['msg'] = '通知机房成功';
                    } elseif ($update['remove_status'] == 3) {
                        $return['msg'] = '机房清空下架中';
                    } elseif ($update['remove_status'] == 0) {
                        $return['msg'] = '驳回下架原因:' . $edit['remove_reason'];
                    }

                }
                return $return;
                break;
            case 2:
                $order = DB::table('tz_orders')->where(['order_sn' => $edit['order_sn']])->select('remove_status', 'remove_reason', 'business_sn', 'resource_type', 'machine_sn')->first();
                if (empty($order)) {
                    $return['code'] = 0;
                    $return['msg']  = '(#107)无对应资源信息';
                    return $return;
                }
                if ($order->remove_status < 1 || $order->remove_status == 4) {
                    $return['code'] = 0;
                    $return['msg']  = '(#108)资源已完成下架/暂未提交下架申请';
                    return $return;
                }
                if (isset($edit['remove_status'])) {
                    $update_status['remove_reason'] = $order->remove_reason . '驳回原因:' . $edit['remove_reason'];
                    $update_status['remove_status'] = $edit['remove_status'];
                    $update_status['machineroom']   = 0;
                } else {
                    switch ($order->remove_status) {
                        case 1:
                            $update_status['remove_status'] = 2;
                            break;
                        case 2:
                            $update_status['remove_status'] = 3;
                            break;
                        case 3:
                            $update_status['remove_status'] = 4;
                            break;
                    }
                }
                DB::beginTransaction();//开启事务处理
                if ($order->remove_status == 3) {
                    switch ($order->resource_type) {
                        case 4://ip
                            $ip['ip_status']    = 0;
                            $ip['own_business'] = Null;
                            $ip['business_end'] = Null;
                            $row                = DB::table('idc_ips')->where(['ip' => $order->machine_sn, 'own_business' => $order->business_sn])->update($ip);
                            break;
                        case 5://cpu
                            $cpu['cpu_used']     = 0;
                            $cpu['service_num']  = Null;
                            $cpu['business_end'] = Null;
                            $row                 = DB::table('idc_cpu')->where(['cpu_number' => $order->machine_sn, 'service_num' => $order->business_sn])->update($cpu);
                            break;
                        case 6://硬盘
                            $harddisk['harddisk_used'] = 0;
                            $harddisk['service_num']   = Null;
                            $harddisk['business_end']  = Null;
                            $row                       = DB::table('idc_harddisk')->where(['harddisk_number' => $order->machine_sn, 'service_num' => $order->business_sn])->update($harddisk);
                            break;
                        case 7://内存
                            $memory['memory_used']  = 0;
                            $memory['service_num']  = Null;
                            $memory['business_end'] = Null;
                            $row                    = DB::table('idc_memory')->where(['memory_number' => $order->machine_sn, 'service_num' => $order->business_sn])->update($memory);
                            break;
                        default:
                            $row = 1;
                            break;
                    }
                    if ($row == 0) {
                        DB::rollBack();
                        $return['code'] = 0;
                        $return['msg']  = '(#109)资源下架修改失败!';
                        return $return;
                    }
                    $update_status['remove_status'] = 4;
                }
                $update_status['updated_at'] = date('Y-m-d H:i:s',time());
                $status = DB::table('tz_orders')->where(['order_sn' => $edit['order_sn']])->update($update_status);
                if ($status == 0) {
                    DB::rollBack();
                    $return['code'] = 0;
                    $return['msg']  = '(#110)资源下架修改失败';
                } else {
                    DB::commit();     
                    $return['code'] = 1;
                    $return['msg']  = '资源下架修改成功';
                }
                return $return;
                break;
            default:
                $return['code'] = 0;
                $return['msg']  = '暂无资源或业务下架';
                break;
        }//switch结束
    }//方法结束

    /**
     * 展示申请下架
     * @return [type] [description]
     */
    public function showApplyUnder()
    {
        /**
         * 根据不同角色进行查看不同的内容
         * @var [type]
         */
        $where   = [];
        $machine = [];
        $user_id = Admin::user()->id;
        $staff   = $this->staff($user_id);
        $status = [1,3];
        if ($staff->slug == 4 && !Admin::user()->inRoles(['network_dimension'])) {
            $where['machineroom'] = $staff->department;
            $status = [2,3];
            $machine['room_id'] = DB::table('idc_machineroom')->where(['list_order'=>$staff->department])->whereNull('deleted_at')->value('id');
        }
        /**
         * 下架主机信息获取
         */
        $business = DB::table('tz_business')->where($where)->whereBetween('remove_status', $status)->whereNull('deleted_at')->select('id','client_id', 'sales_id', 'business_number', 'machine_number', 'business_type', 'business_note', 'remove_reason', 'resource_detail', 'remove_status')->get();
        //对下架主机的部分数据进行转换(laravel的map方法)
        $business->map(function($value,$key){
            $business_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            $value->resource_type = $business_type[$value->business_type];
            $value->removestatus  = $remove_status[$value->remove_status];
            $value->sales_name = DB::table('admin_users')->where(['id'=> $value->sales_id])->value('name');
            $value->client_name = DB::table('tz_users')->where(['id'=> $value->client_id])->value('nickname');
            $resource_detail = json_decode($value->resource_detail);
            $value->machineroom_name = $resource_detail->machineroom_name;
            $value->parent_business = 0;
            if($value->business_type != 3){
                $value->cabinets = $resource_detail->cabinets;
                $value->ip = isset($resource_detail->ip)?$resource_detail->ip:'';
                $note = DB::table('idc_machine')->where(['machine_num'=>$value->machine_number])->value('machine_note');
                if($note){
                    $value->machine_number = $value->machine_number.'(机器备注:'.$note.')';
                }
                
            } else {
                $value->cabinets = $resource_detail->cabinet_id;
                $value->ip = '';
            }
            return $value;

        });

        $cabinet_machine = DB::table('tz_cabinet_machine')->where($machine)->whereBetween('remove_status',$status)->whereNull('deleted_at')->select('id','customer as client_id','sales as sales_id','business_number','resource_sn as machine_number','resource_type as business_type','business_note','remove_note as remove_reason','remove_status','room_id','cabinet_id','ip_id','parent_business')->get();
        $cabinet_machine->map(function($item,$key){
            $business_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            $item->resource_type = $business_type[$item->business_type];
            $item->removestatus  = $remove_status[$item->remove_status];
            $item->sales_name = DB::table('admin_users')->where(['id'=> $item->sales_id])->value('name');
            $item->client_name = DB::table('tz_users')->where(['id'=> $item->client_id])->value('nickname');
            $item->machineroom_name = DB::table('idc_machineroom')->where(['id'=>$item->room_id])->value('machine_room_name');
            $item->cabinets = DB::table('idc_cabinet')->where(['id'=>$item->cabinet_id])->value('cabinet_id');
            $item->ip = DB::table('idc_ips')->where(['id'=>$item->ip_id])->value('ip');
            $item->resource_detail = DB::table('tz_cabinet_machine_detail')->where(['business_id'=>$item->id])->value('detail');
            return $item;
        });
        $business = array_merge($business->toArray(),$cabinet_machine->toArray());
        
        /**
         * 下架资源的信息获取
         */
        $orders = DB::table('tz_orders')->where($where)->where('resource_type', '>', 3)->whereNull('deleted_at')->whereBetween('remove_status', [1, 3])->orderBy('updated_at', 'desc')->select('id','order_sn', 'business_sn', 'customer_id', 'resource_type', 'business_id', 'machine_sn', 'resource', 'remove_reason', 'remove_status')->get();
        //下架资源的信息转化(laravel的map方法)
        $orders->map(function($orders_value,$orders_key){
            $resource_type = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜', 4 => 'IP', 5 => 'CPU', 6 => '硬盘', 7 => '内存', 8 => '带宽', 9 => '防护', 10 => 'cdn', 11 => '高防IP'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            $orders_value->resourcetype = $resource_type[$orders_value->resource_type];
            $orders_value->removestatus = $remove_status[$orders_value->remove_status];
            $orders_value->business_name = DB::table('admin_users')->where(['id'=> $orders_value->business_id])->value('name');
            $client_name = DB::table('tz_users')->where(['id'=> $orders_value->customer_id])->value('nickname');
            $orders_value->customer_name = $client_name;
            $rData = $this->getResourceData($orders_value->business_sn); //根据业务号获取机柜和IP信息
            $orders_value->ip =  $rData['ip'];    //ip放入到订单数据中
            $orders_value->cabinets= $rData['cabinet_id'];  //机柜编号放入到订单订单数据中
        });
        $result         = ['business' => $business, 'orders' => $orders];
        $return['data'] = $result;
        $return['code'] = 1;
        $return['msg']  = '获取下架申请记录成功';
        return $return;
    }


    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id)
    {
        $staff = DB::table('oa_staff')
            ->join('tz_department', 'oa_staff.department', '=', 'tz_department.id')
            ->join('tz_jobs', 'oa_staff.job', '=', 'tz_jobs.id')
            ->where(['admin_users_id' => $admin_id])
            ->select('oa_staff.work_number', 'oa_staff.department', 'tz_department.sign', 'tz_jobs.slug')
            ->first();
        return $staff;
    }

    /**
     * 根据业务号 获取机器机柜 和IP
     *  TODO 未加机房
     *
     * @param $businessSn
     * @return mixed
     */
    public function getResourceData($businessSn)
    {
        //查询业务数据
        $businessData = DB::table('tz_business')
            ->where('business_number', $businessSn)
            ->first();

        //查询机器数据
        $machineData = DB::table('idc_machine')
            ->where('machine_num', $businessData->machine_number)
            ->first();

        //判断ip是否为空
        if (empty($machineData->ip_id)||$machineData->ip_id == 0) {
            //当ipID 为0时
            $resData['ip'] = '未配置IP';
        } else {
            //不为0时
            $ipData        = DB::table('idc_ips')
                ->where('id', $machineData->ip_id)
                ->first();
            $resData['ip'] = $ipData->ip;
        }

        //判断是否配置了机柜
        if (empty($machineData->cabinet) || $machineData->cabinet == 0) {
            //当未配置机柜时
            $resData['cabinet_id'] = '未配置机柜';
        } else {
            //配置机柜时
            $cabinetData        = DB::table('idc_cabinet')
                ->where('id', $machineData->cabinet)
                ->first();
            $resData['cabinet_id'] = $cabinetData->cabinet_id;
        }
        if($businessData->business_type == 3){
            $resData['cabinet_id'] = $businessData->machine_number;
        }
        return $resData;

        //----多表联查（为启用）-------------------------------------
        //$testData->machine_number   机器编号
        //
//        $machineData = DB::table('idc_machine')
//            ->join('idc_ips', 'idc_machine.ip_id', '=', 'idc_ips.id')
//            ->join('idc_cabinet', 'idc_machine.cabinet', '=', 'idc_cabinet.id')
//            ->where('machine_num', $businessData->machine_number)
//            ->select('idc_cabinet.cabinet_id', 'idc_ips.ip')
//            ->first();
    }

    public function tranUnder(){
        $business = DB::table('tz_business')->whereBetween('remove_status',[1,4])->select('order_number','updated_at','created_at','machineroom','remove_status')->get();
        $return['data'] = [];
        if(!empty($business)){
            foreach($business as $key=>$value){
                $remove['updated_at'] = $value->updated_at;
                if($value->created_at > $value->updated_at){
                    $remove['updated_at'] = $value->created_at;
                }
                $remove['remove_status'] = $value->remove_status;
                $remove['machineroom'] = $value->machineroom;
                $order = DB::table('tz_orders')->where(['order_sn'=>$value->order_number])->update($remove);
                if($order != 0){
                    array_push($return['data'],$value->order_number);
                } else {
                    array_push($return['data'],$value->order_number);
                }
            }
        }
        return $return;
    }
}
