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
    public function applyUnder($apply){
   		if(!$apply){
   			$return['code'] = 0;
            $return['msg'] = '业务/资源无法申请下架';
            return $return;
   		}
   		switch ($apply['type']) {
   			case 1:
   				$business_result = DB::table('tz_business')->where(['business_number'=>$apply['business_number']])->select('remove_status','business_number','business_type','machine_number')->first();
	   			if(empty($business_result)){//不存在业务
		            $return['code'] = 0;
		            $return['msg'] = '无此业务，无法申请下架';
		            return $return;
	        	}
	        	if($business_result->remove_status > 0){//业务已处于下架状态的
		            $return['code'] = 0;
		            $return['msg'] = '此业务正在下架中，请勿重复申请操作!';
		            return $return;
	        	}
	        	$remove['remove_reason'] = $apply['remove_reason'];//下架缘由
	        	$remove['remove_status'] = 1;//申请下架的状态
	        	DB::beginTransaction();//开启事务
	        	$business_remove = DB::table('tz_business')->where(['business_number'=>$apply['business_number']])->update($remove);//更新业务的下架状态
	        	if($business_remove == 0){//更新失败
		            DB::rollBack();
		            $return['code'] = 0;
		            $return['msg'] = '业务申请下架失败';
		            return $return;
	        	}
	        	//查找业务关联的资源
		        $resources = DB::table('tz_orders')->where(['business_sn'=>$apply['business_number'],'remove_status'=>0])->where('price','>','0.00')->where('resource_type','>',3)->orderBy('end_time','desc')->get(['order_sn','resource_type','machine_sn','resource','price','end_time'])->groupBy('machine_sn')->toArray();

		        if(!empty($resources)){//存在业务关联的资源，进一步进行查找资源的最新情况
		            $resource_keys = array_keys($resources);//获取分组后的资源编号
		            foreach($resource_keys as $key=>$value){//获取业务关联的最新资源
		                $business['machine_sn'] = $value;
		                $business['business_sn'] = $apply['business_number'];
		                $business['remove_status'] = 0;

		                $resource[$key] = DB::table('tz_orders')->where($business)->orderBy('end_time','desc')->select('order_sn','resource_type','machine_sn','resource','price','end_time','order_status')->first();
		            }
		            if(!empty($resource)){//存在关联业务则继续对关联的资源进行同步下架
		                foreach($resource as $resource_key=>$resource_value){
		                    $order_remove['remove_reason'] = '关联业务'.$apply['business_number'].'申请下架，关联业务资源同步下架';
		                    $order_remove['remove_status'] = 1;
		                    $order_row = DB::table('tz_orders')->where(['order_sn'=>$resource_value->order_sn])->update($order_remove);
		                    if($order_row == 0){//关联业务的资源同步下架失败
		                        DB::rollBack();
		                        $return['code'] = 0;
		                        $return['msg'] = '业务关联资源申请下架失败';
		                        return $return;
		                    }
		                }
		            }
		        }
		        DB::commit();
		        $return['code'] = 1;
		        $return['msg'] = '业务:'.$apply['business_number'].'申请下架成功,等待处理';
		        return $return;
   				break;
   			case 2:
   				$order_result = DB::table('tz_orders')->where(['order_sn'=>$apply['order_sn']])->select('order_sn','remove_status','machine_sn','end_time','business_sn')->first();
		        if(empty($order_result)){
		            $return['code'] = 0;
		            $return['msg'] = '无此资源的信息,无法下架!';
		            return $return;
		        }
		        if($order_result->remove_status > 0){
		            $return['code'] = 0;
		            $return['msg'] = '此资源正在下架中,请勿重复提交申请';
		            return $return;
		        }
		        $end_time = DB::table('tz_orders')->where(['machine_sn'=>$order_result->machine_sn,'business_sn'=>$order_result->business_sn])->orderBy('end_time','desc')->select('end_time','remove_status')->first();
		        if(!empty($end_time)){
		            if($end_time->remove_status > 0){
		                $return['code'] = 0;
		                $return['msg'] = '此资源正在下架中,请勿重复提交申请';
		                return $return;
		            }
		            if($order_result->end_time != $end_time->end_time){
		                $return['code'] = 0;
		                $return['msg'] = '此资源的信息不是最新，请查找最新';
		                return $return;
		            }
		        }
		        $remove['remove_status'] = 1;
		        $remove['remove_reason'] = $apply['remove_reason'];
		        $update = DB::table('tz_orders')->where(['order_sn'=>$apply['order_sn']])->update($remove);
		        if($update == 0){
		            $return['code'] = 0;
		            $return['msg'] = '资源申请下架失败';

		        } else {
		            $return['code'] = 1;
		            $return['msg'] = '资源申请下架成功';
		        }
		        return $return;
   				break;
   			default:
   				$return['code'] = 0;
	            $return['msg'] = '无对应的资源/业务可以下架';
	            return $return;
   				break;
   		}//switch结束
    }//方法结束

    /**
     * 获取下架的历史记录
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function underHistory($type){
    	if(!$type){
    		$return['data'] = [];
    		$return['code'] = 0;
		    $return['msg'] = '无法获取下架历史记录';
		    return $return;
    	}
    	switch ($type['type']) {
    		case 1:
    			$history = DB::table('tz_business')->where(['remove_status'=>4])->orderBy('updated_at','desc')->select('client_name','sales_name','business_number','machine_number','business_type','business_note','remove_reason','resource_detail','remove_status')->get();
		        if(!empty($history)){
		            $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
		            $remove_status = [0=>'正常使用',1=>'下架申请中',2=>'机房处理中',3=>'清空下架中',4=>'下架完成'];
		            foreach($history as $history_key => $history_value){
		                $history_value->resourcetype = $business_type[$history_value->business_type];
		                $history_value->remove_status = $remove_status[$history_value->remove_status];
		            }
		            $return['data'] = $history;
		            $return['code'] = 1;
		            $return['msg'] = '获取机器下架记录数据成功';
		        } else {
		            $return['data'] = [];
		            $return['code'] = 0;
		            $return['msg'] = '暂无机器下架记录数据';
		        }
		        return $return;
    			break;
    		case 2:
    			$history = DB::table('tz_orders')->where('resource_type','>',3)->where(['remove_status'=>4])->orderBy('updated_at','desc')->select('business_sn','order_sn','customer_name','resource_type','business_name','machine_sn','resource','remove_status','remove_reason')->get();
		        if(!empty($history)){
		            $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
		            $remove_status = [0=>'正常使用',1=>'下架申请中',2=>'机房处理中',3=>'清空下架中',4=>'下架完成'];
		            foreach($history as $history_key => $history_value){
		                $history_value->resourcetype = $resource_type[$history_value->resource_type];
		                $history_value->remove_status = $remove_status[$history_value->remove_status];
		            }
		            $return['data'] = $history;
		            $return['code'] = 1;
		            $return['msg'] = '获取资源下架记录数据成功';
		        } else {
		            $return['data'] = [];
		            $return['code'] = 0;
		            $return['msg'] = '暂无下架资源数据';
		        }
		        return $return;
    			break;
    		default:
    			$return['data'] = [];
	    		$return['code'] = 0;
			    $return['msg'] = '暂无下架历史记录';
			    return $return;
    			break;
    	}//switch结束
    }//方法结束

    /**
     * 对下架的申请进行操作
     * @param  [type] $edit [description]
     * @return [type]       [description]
     */
    public function doUnder($edit){
    	if(!$edit){
            $return['code'] = 0;
            $return['msg'] = '你无法对业务/资源进行下架处理';
            return $return;
        }
        switch ($edit['type']) {
        	case 1:
        		$business = DB::table('tz_business')->where(['business_number'=>$edit['business_number']])->select('remove_status','remove_reason','business_type','machine_number','business_number','resource_detail')->first();
		        if(empty($business)){//不存在需要下架的业务，直接返回
		            $return['code'] = 0;
		            $return['msg'] = '无对应业务';
		            return $return;
                }
		        if($business->remove_status < 1 || $business->remove_status == 4){//当业务未提交申请或已下架，直接返回
		            $return['code'] = 0;
		            $return['msg'] = '业务已完成下架/暂未提交下架申请';
		            return $return;
		        }
		        if(isset($edit['remove_status'])){
		            $update['remove_reason'] = $business->remove_reason.'驳回原因:'.$edit['remove_reason'];
		            $update['remove_status'] = $edit['remove_status'];
		            $update['machineroom'] = 0;
		        } else {
		            switch ($business->remove_status) {
		                case 1:
		                    $update['remove_status'] = 2;
		                    $update['machineroom'] = DB::table('idc_machineroom')->where(['id'=>json_decode($business->resource_detail)->machineroom])->value('list_order');
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
		        if($business->remove_status == 3){
		            switch ($business->business_type) {
		                case 1:
		                    $rent['used_status'] = 0;
		                    $rent['own_business'] = 0;
		                    $rent['business_end'] = Null;
		                    $rent['loginname'] = isset($edit['loginname'])?$edit['loginname']:'administrator';
		                    $rent['loginpass'] = isset($edit['loginpass'])?$edit['loginpass']:'esJ04&'.substr(time(),8,2);
		                    $row = DB::table('idc_machine')->where(['machine_num'=>$business->machine_number,'own_business'=>$edit['business_number'],'business_type'=>1])->update($rent);
		                    break;
		                case 2:
		                    $host['used_status'] = 0;
		                    $host['own_business'] = 0;
		                    $host['business_end'] = Null;
		                    $host['machine_status'] = 1;
		                    $row = DB::table('idc_machine')->where(['machine_num'=>$business->machine_number,'own_business'=>$edit['business_number'],'business_type'=>2])->update($host);
		                    break;
		                case 3:
		                    $cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$business->machine_number])->select('own_business')->first();//获取机柜原来的业务号
		                    $array = explode(',',$cabinet->own_business);//先将原本的业务数据转换为数组
		                    $key = array_search($business->business_number,$array);//查找要删除的业务编号在数组的位置的键
		                    array_splice($array,$key,1);//根据查找的对应键进行删除
		                    $own_business = implode(',',$array);//将数组转换为字符串
		                    $cabinet_update['own_business'] = $own_business;
		                    $cabinet_update['business_end'] = Null;
		                    $row = DB::table('idc_cabinet')->where(['cabinet_id'=>$business->machine_number])->update($cabinet_update);
		                    break;
		                default:
		                    $row = 1;
		                    break;
		            }
		            if($row == 0){
		                DB::rollBack();
		                $return['code'] = 0;
		                $return['msg'] = '业务相关机器下架状态修改失败';
		            }
		            $update['remove_status'] = 4;
		            
		        }
		        $remove = DB::table('tz_business')->where(['business_number'=>$edit['business_number']])->update($update);
		        if($remove == 0){
		            DB::rollBack();
		            $return['code'] = 0;
		            $return['msg'] = '业务下架状态修改失败';
		        } else {
		            DB::commit();
		            $return['code'] = 1;
		            if($business->business_type == 1 && $update['remove_status'] == 4){
		            	$return['msg'] = '主机为'.$business->machine_number.'的资源下架修改成功'.'账户:'.$rent['loginname'].',密码:'.$rent['loginpass'];
		            } elseif($update['remove_status'] == 2) {
		            	$return['msg'] = '通知机房成功';
		            } elseif($update['remove_status'] ==3){
		            	$return['msg'] = '通知机房成功';
		            } elseif($update['remove_status'] == 0){
		            	$return['msg'] = '驳回下架原因:'.$edit['remove_reason'];
		            }
		            
		        }
		        return $return;
        		break;
        	case 2:
        		$order = DB::table('tz_orders')->where(['order_sn'=>$edit['order_sn']])->select('remove_status','remove_reason','business_sn','resource_type','machine_sn')->first();
		        if(empty($order)){
		            $return['code'] = 0;
		            $return['msg'] = '无对应资源信息';
		            return $return;
		        }
		        if($order->remove_status < 1 || $order->remove_status == 4){
		            $return['code'] = 0;
		            $return['msg'] = '资源已完成下架/暂未提交下架申请';
		            return $return;
		        }
		        if(isset($edit['remove_status'])){
		            $update_status['remove_reason'] = $order->remove_reason.'驳回原因:'.$edit['remove_reason'];
		            $update_status['remove_status'] = $edit['remove_status'];
		            $update_status['machineroom'] = 0;
		        } else {
		            switch($order->remove_status){
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
		        if($order->remove_status == 3){
		            switch($order->resource_type){
		                case 4://ip
		                    $ip['ip_status'] = 0;
		                    $ip['own_business'] = 0;
		                    $ip['business_end'] = Null;
		                    $row = DB::table('idc_ips')->where(['ip'=>$order->machine_sn,'own_business'=>$order->business_sn])->update($ip);
		                    break;
		                case 5://cpu
		                    $cpu['cpu_used'] = 0;
		                    $cpu['service_num'] = 0;
		                    $cpu['business_end'] = Null;
		                    $row = DB::table('idc_cpu')->where(['cpu_number'=>$order->machine_sn,'service_num'=>$order->business_sn])->update($cpu);
		                    break;
		                case 6://硬盘
		                    $harddisk['harddisk_used'] = 0;
		                    $harddisk['service_num'] = 0;
		                    $harddisk['business_end'] = Null;
		                    $row = DB::table('idc_harddisk')->where(['harddisk_number'=>$order->machine_sn,'service_num'=>$order->business_sn])->update($harddisk);
		                    break;
		                case 7://内存
		                    $memory['memory_used'] = 0;
		                    $memory['service_num'] = 0;
		                    $memory['business_end'] = Null;
		                    $row = DB::table('idc_memory')->where(['memory_number'=>$order->machine_sn,'service_num'=>$order->business_sn])->update($memory);
		                    break;
		                default:
		                    $row = 1;
		                    break;
		            }
		            if($row == 0){
		                DB::rollBack();
		                $return['code'] = 0;
		                $return['msg'] = '资源下架修改失败!';
		                return $return;
		            }
		            $update_status['remove_status'] = 4;
		        }
		        $status = DB::table('tz_orders')->where(['order_sn'=>$edit['order_sn']])->update($update_status);
		        if($status == 0){
		            DB::rollBack();
		            $return['code'] = 0;
		            $return['msg'] = '资源下架修改失败';
		        } else {
		            DB::commit();
		            $return['code'] = 1;
		            $return['msg'] = '资源下架修改成功';
		        }
		        return $return;
        		break;
        	default:
        		$return['code'] = 0;
		        $return['msg'] = '暂无资源或业务下架';
        		break;
        }//switch结束
    }//方法结束

    /**
     * 展示申请下架
     * @return [type] [description]
     */
    public function showApplyUnder(){
    	/**
         * 根据不同角色进行查看不同的内容
         * @var [type]
         */
        $where = [];
        $user_id = Admin::user()->id;
        $staff = $this->staff($user_id);
        if($staff->slug == 4){
            $where['machineroom'] = $staff->department;
        }
        $business = DB::table('tz_business')->where($where)->whereBetween('remove_status',[1,3])->select('client_name','sales_name','business_number','machine_number','business_type','business_note','remove_reason','resource_detail','remove_status')->get();
        if(!empty($business)){
            $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
            $remove_status = [0=>'正常使用',1=>'下架申请中',2=>'机房处理中',3=>'清空下架中',4=>'下架完成'];
            foreach($business as $business_key => $business_value){
                $business_value->resource_type = $business_type[$business_value->business_type];
                $business_value->removestatus = $remove_status[$business_value->remove_status];
            }
		}
		$orders = DB::table('tz_orders')->where($where)->where('resource_type','>',3)->whereBetween('remove_status',[1,3])->orderBy('updated_at','desc')->select('order_sn','business_sn','customer_name','resource_type','business_name','machine_sn','resource','remove_reason','remove_status')->get();
        if(!empty($orders)){
            $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
            $remove_status = [0=>'正常使用',1=>'下架申请中',2=>'机房处理中',3=>'清空下架中',4=>'下架完成'];
            foreach($orders as $orders_key => $orders_value){
                $orders_value->resourcetype = $resource_type[$orders_value->resource_type];
                $orders_value->removestatus = $remove_status[$orders_value->remove_status];
            }
        }
        $result = ['business'=>$business,'orders'=>$orders];
        $return['data'] = $result;
        $return['code'] = 1;
        $return['msg'] = '获取下架申请记录成功';
        return $return;

    }


    /**
     * 内部提交时根据用户账号的id查找出对应的账户的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
    	$staff = DB::table('oa_staff')
                    ->join('tz_department','oa_staff.department','=','tz_department.id')
                    ->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                    ->where(['admin_users_id'=>$admin_id])
                    ->select('oa_staff.work_number','oa_staff.department','tz_department.sign','tz_jobs.slug')
                    ->first();
        return $staff;
    }
}
