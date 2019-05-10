<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;
use XS;
use XSDocument;
/**
 * 后台业务模型
 */
class BusinessModel extends Model
{
    use SoftDeletes;
    protected $table = 'tz_business';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'money', 'length', 'endding_time', 'business_status', 'business_note', 'remove_status', 'remove_reason', 'check_note', 'created_at', 'updated_at'];

    /**
     * 创建业务数据
     * @param  array $insert 需要创建业务的数据
     * @return array         返回创建业务时的id和状态及提示信息
     */
    public function insertBusiness($insert)
    {
        if (!$insert) {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务无法创建！！';
            return $return;
        }
        //业务编号的生成规则：前两位（1-3的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 7-9随机数（业务编号产生）
        $client = DB::table('tz_users')->where(['id'=>$insert['client_id'],'status'=>2])->select('id','name','email')->first();
        if(!$client){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '客户不存在或账号未验证/异常,请确认后再创建业务!';
            return $return;
        }
        DB::beginTransaction();//开启事务处理
        $business_id = mt_rand(10000,20000);
        $business_sn               = $this->businesssn($business_id,$insert['business_type']);
        $insert['business_number'] = $business_sn;
        $insert['business_status'] = 0;
        $insert['client_name'] = $client->name?$client->name:$client->email;
        // 对应业务员的信息
        $sales_id             = Admin::user()->id;
        $insert['sales_id']   = $sales_id;
        $insert['sales_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
        $insert['created_at'] = date('Y-m-d H:i:s',time());
        //业务开始时间
        $start_time = date('Y-m-d H:i:s',time());
        //到期时间的计算
        $end_time = time_calculation($start_time,$insert['length'],'month');
        $insert['start_time']   = $start_time;
        $insert['endding_time'] = $end_time;
        $row                  = DB::table('tz_business')->insertGetId($insert);
        if ($row == 0) {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务创建失败';
            return $return;
        }
        if($insert['business_type'] == 1 || $insert['business_type'] == 2){
            $machine = DB::table('idc_machine')->where(['machine_num'=>$insert['machine_number']])->update(['used_status'=>1]);
            if($machine == 0){
                DB::rollBack();
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '业务创建失败!';
                return $return;
            }
        }
        $relevance = DB::table('tz_business_relevance')->insert(['type'=>1,'business_id'=>$insert['business_number'],'created_at'=>date('Y-m-d H:i:s',time())]);
        if($relevance == true){
            $xunsearch = new XS('business');
            $index = $xunsearch->index;
            $resource = json_decode($insert['resource_detail']);
            $doc['ip'] = isset($resource->ip)?strtolower($resource->ip):'';
            $doc['cpu'] = isset($resource->cpu)?strtolower($resource->cpu):'';
            $doc['memory'] = isset($resource->memory)?strtolower($resource->memory):'';
            $doc['harddisk'] = isset($resource->harddisk)?strtolower($resource->harddisk):'';
            $doc['id'] = strtolower($row);
            $doc['business_sn'] = strtolower($business_sn);
            $doc['machine_number'] = strtolower($insert['machine_number']);
            $doc['client'] = strtolower($insert['client_id']);
            $document = new \XSDocument($doc);
            $index->update($document);
            $index->flushIndex();
            DB::commit();
            $return['data'] = $row;
            $return['code'] = 1;
            $return['msg']  = '业务创建成功，待审核';
        }  else {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务创建失败!!';
        } 
            
        return $return;

    }

    /**
     * 信安部门查看业务数据获取
     * @return array 返回相关的数据和状态及提示信息
     */
    public function securityBusiness()
    {
        $result = $this->whereBetween('business_status',[0,5])->where('remove_status','<',4)->orderBy('created_at','desc')->get(['id', 'client_id', 'sales_id', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'business_note','created_at','start_time','endding_time','remove_status']);
        if (!$result->isEmpty()) {
            $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
            $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            foreach ($result as $check => $check_value) {
                $result[$check]['status'] = $business_status[$check_value['business_status']];
                $result[$check]['type']   = $business_type[$check_value['business_type']];
                $result[$check]['remove'] = $remove_status[$check_value['remove_status']];
                $check_value->sales_name = DB::table('admin_users')->where(['id'=>$check_value->sales_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$check_value->client_id])->select('name','email','nickname','msg_phone','msg_qq')->first();
                $email = $client_name->email ? $client_name->email : $client_name->name;
                $email = $email ? $email : $client_name->nickname;
                $check_value->client_name = $email;
                $resource_detail = json_decode($check_value['resource_detail']);
                $result[$check]['machineroom_name'] = $resource_detail->machineroom_name;
                if($check_value['business_type'] != 3){
                    $result[$check]['cabinets'] = $resource_detail->cabinets;
                    $result[$check]['ip'] = $resource_detail->ip;
                } else {    
                    $result[$check]['cabinets'] = $resource_detail->cabinet_id;
                    $result[$check]['ip'] = '';
                }
            }
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg']  = '相关业务数据获取成功';
        } else {
            $return['data'] = '暂无业务数据';
            $return['code'] = 0;
            $return['msg']  = '暂无业务数据';
        }

        return $return;
    }
// DB::beginTransaction();
// DB::rollBack();
// DB::commit();
    /**
     * 信安部门对业务进行审核操作
     * @param  array $where 业务的业务编号和业务的id
     * @return array        返回相关的数据和状态及提示信息
     */
    public function checkBusiness($where)
    {
        if (!$where) {
            // 没有审核数据
            $return['data'] = '无法进行审核';
            $return['code'] = 0;
            $return['msg']  = '无法进行审核';
            return $return;
        }
        // 根据业务号查询需要审核的业务数据
        $check_where = ['business_number' => $where['business_number']];
        $check       = DB::table('tz_business')->where($check_where)->select('client_id','id','business_number', 'client_name', 'sales_id', 'sales_name', 'business_type', 'machine_number', 'money', 'length','resource_detail','endding_time')->first();
        if (empty($check)) {
            // 不存在对应的业务数据直接返回
            $return['data'] = '该业务不存在,无法进行审核操作';
            $return['code'] = 0;
            $return['msg']  = '该业务不存在,无法进行审核操作';
            return $return;
        }
        // 当不是机柜时且当审核为通过时先对机器的使用状态进行判断
        if($check->business_type != 3 && $where['business_status'] == 1) {
            // 审核通过前验证业务机器是否未使用，如果是使用直接返回提示
            $machine_where['machine_num'] = $check->machine_number;
            $machine_where['used_status'] = 1;//业务锁定
            $machine_status               = DB::table('idc_machine')->where($machine_where)->select('id', 'machine_num', 'used_status')->first();
            if (empty($machine_status)) {
                $where['business_status'] = '-2';
                $where['check_note']      = '不通过原因:该业务对应的机器已经被使用，请重新选择机器!';
            }

        }
        // 业务表审核时更新的字段
        $business['business_status'] = $where['business_status'];
        $business['check_note']      = $where['check_note'];
        if ($where['business_status'] != 1) {
            DB::beginTransaction();
            // 审核为不通过时直接进行业务的状态更改
            $business['remove_status'] = 4;
            $row = DB::table('tz_business')->where($check_where)->update($business);
            if($row == 0){
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!';
                return $return;
            }
            if($check->business_type != 3){
                $omachine = DB::table('idc_machine')->where(['machine_num'=>$check->machine_number,'used_status'=>0])->first();//先检查是否该机器状态为未使用
                if(empty($omachine)){//不是未使用，更新成为使用状态，是的话就不更新
                    $machine = DB::table('idc_machine')->where(['machine_num'=>$check->machine_number])->update(['used_status'=>0]);
                    if($machine == 0){
                        DB::rollBack();
                        $return['data'] = '审核失败';
                        $return['code'] = 0;
                        $return['msg']  = '审核失败!!';
                        return $return;
                    }
                }     
            }
            DB::commit();
            $return['data'] = '';
            $return['code'] = 1;
            if (isset($where['check_note'])) {
                $return['msg'] = '审核不通过,原因:'.$where['check_note'];
            } else {
                $return['msg'] = '审核不通过';
            }
            return $return;
        }

        // 如果审核为通过则继续进行订单表的生成
        DB::beginTransaction();//开启事务处理
        
        // 订单号的生成规则：前两位（4-6的随机数）+ 年月日（如:20180830） + 时间戳的后2位数 + 1-3随机数
        $order_sn                 = $this->ordersn($check->id,$check->business_type);
        $business['order_number'] = $order_sn;
        $business['updated_at']   = date('Y-m-d H:i:s',time());
        $business_row             = DB::table('tz_business')->where($check_where)->update($business);
        if ($business_row == 0) {
            // 业务审核失败
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '(#101)审核失败!!';
            return $return;
        }
        // 业务审核成功继续进行订单表的生成
        $order['order_sn']      = $order_sn;
        $order['business_sn']   = $check->business_number;
        $order['customer_id']   = $check->client_id;
        $order['customer_name'] = $check->client_name;
        $order['business_id']   = $check->sales_id;
        $order['business_name'] = $check->sales_name;
        $order['resource_type'] = $check->business_type;
        $order['order_type']    = 1;
        $order['machine_sn']    = $check->machine_number;
        $order['price']         = $check->money;//单价
        $order['duration']      = $check->length;//时长
        $order['resource']      = $check->machine_number;//机器的话为IP/机柜则为机柜编号
        $order['end_time']      = $check->endding_time;
        $order['payable_money'] = bcmul((string)$order['price'], (string)$order['duration'], 2);//应付金额
        $order['created_at']    = date('Y-m-d H:i:s',time());
        $order_row              = DB::table('tz_orders')->insert($order);//生成订单
        if ($order_row != true) {
            // 订单生成失败
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '审核失败!!!';
            return $return;
        }
        if ($order['resource_type'] == 1 || $order['resource_type'] == 2) {
            // 如果是租用/托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $machine['own_business'] = $order['business_sn'];
            $machine['business_end'] = $order['end_time'];
            $machine['used_status']  = 2;
            $row                     = DB::table('idc_machine')->where('machine_num', $order['machine_sn'])->update($machine);
            if ($row == 0) {
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!!!!';
                return $return;
            }
            $ip_id = json_decode($check->resource_detail)->ip_id;
            $row = DB::table('idc_ips')->where('id',  $ip_id)->update(['own_business' => $order['business_sn'],'mac_num'=>$order['machine_sn']]);

        } else {
            // 如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $own_business = DB::table('idc_cabinet')->where('cabinet_id', $order['machine_sn'])->value('own_business');
            if($own_business){
                $machine['own_business'] = $own_business.','.$order['business_sn'];
            } else {
                $machine['own_business'] = $order['business_sn'];
            }
            $machine['business_end'] = $order['end_time'];
            $machine['use_state']    = 1;
            $row                     = DB::table('idc_cabinet')->where('cabinet_id', $order['machine_sn'])->update($machine);
        }
        if ($row != 0) {
            // 订单生成成功且对应资源的业务编号及状态修改成功，事务进行提交处理
            DB::commit();
            $return['data'] = $order_sn;
            $return['code'] = 1;
            $return['msg']  = '审核成功,通知业务员及时联系客户进行支付,单号:' . $order_sn;
        } else {
            DB::rollBack();
            $return['data'] = '审核失败';
            $return['code'] = 0;
            $return['msg']  = '审核失败!!!!!';
        }
        return $return;
    }

    /**
     * 业务员手动对客户的业务进行启用状态，针对后付费客户群体
     * @param  [type] $enable [description]
     * @return [type]         [description]
     */
    public function enableBusiness($enable)
    {
        if ($enable) {
            $row = $this->where(['id'=>$enable['id']])->update($enable);
            if ($row != false) {
                $return['code'] = 1;
                $return['msg']  = '业务启用成功';
            } else {
                $return['code'] = 1;
                $return['msg']  = '业务启用失败';
            }
        } else {
            $return['code'] = 0;
            $return['msg']  = '无法启用该业务';
        }
        return $return;
    }


    /**
     * 业务员和管理员查看对应客户的业务数据
     * @param  array $show 客户的id即业务表的client_id字段
     * @return array        返回相关的数据和状态提示及信息
     */
    public function showBusiness($show)
    {
        if ($show) {
            $result = $this->where($show)->whereBetween('business_status',[0,5])->where('remove_status','<',4)->orderBy('created_at','desc')->get(['id', 'client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'start_time', 'endding_time', 'business_note','remove_status']);
            if (!$result->isEmpty()) {
                $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
                $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
                $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
                foreach ($result as $check => $check_value) {
                    $result[$check]['status'] = $business_status[$check_value['business_status']];
                    $result[$check]['type']   = $business_type[$check_value['business_type']];
                    $result[$check]['remove'] = $remove_status[$check_value['remove_status']];
                    $resource_detail = json_decode($check_value['resource_detail']);
                    if($check_value['business_type'] != 3){
                        $result[$check]['cabinets'] = $resource_detail->cabinets;
                    } else {    
                        $result[$check]['cabinets'] = $resource_detail->cabinet_id;
                    }
                }
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg']  = '相关业务数据获取成功';
            } else {
                $return['data'] = '暂无业务数据';
                $return['code'] = 0;
                $return['msg']  = '暂无业务数据';
            }

            return $return;
        }
    }

    /**
     * 创建业务号
     * @return [type] [description]
     */
    public function businesssn($business_id=100,$business_type=1){
        $time= bcadd(time(),$business_id);
        $business_sn = mt_rand(1, 3) . date("Ymd", time()) . substr($time, 6, 4) . $business_id .mt_rand(7, 9);
        //业务编号的生成规则：前两位（1-3的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 7-9随机数（业务编号产生）
        // $business_sn = mt_rand(1,3).date('YmdHis').$time.mt_rand(20,99).'1'.$business_type;
        $business = $this->where('business_number',$business_sn)->select('business_number','machine_number')->first();
        if(!empty($business)){
            $this->businesssn();
        } else {
            return $business_sn;
        }
    }

    /**
     * 创建订单号
     * @return [type] [description]
     */
    /**
     * 创建订单号
     * @return [type] [description]
     */
    public function ordersn($resource_id=100,$resource_type=1){
        $time = bcadd(time(),$resource_id,0);
        $order_sn = mt_rand(4, 6) . date("Ymd", time()) . substr($time, 6, 4) . $resource_id .mt_rand(1, 3).'1';
        $order = DB::table('tz_orders')->where('order_sn',$order_sn)->select('order_sn','machine_sn')->first();
        $session = session()->has('O'.$order_sn);
        if(!empty($order)){
            $this->ordersn();
        }
        if($session == true){
            $this->ordersn();
        }
        return $order_sn;
    }

    /**
     * 根据业务id删除业务数据
     * @param  [type] $delete_id [description]
     * @return [type]            [description]
     */
    public function deleteBusiness($delete_id)
    {
        //查找对应业务数据
        $deltet_data = $this->find($delete_id['delete_id']);
        if (!$deltet_data) {
            $return['code'] = 0;
            $return['msg']  = '无法删除对应数据!';
            return $return;
        }
        DB::beginTransaction();//开启事务处理DB::commit();DB::rollBack();
        if($deltet_data->business_status > 0){//当删除的业务数据为审核通过时，对对应资源进行释放操作
            switch ($deltet_data->business_type) {
            case 1:
                $updated['own_business'] = '';
                $updated['business_end'] = NULL;
                $updated['used_status'] = 0;
                $row = DB::table('idc_machine')->where(['machine_num'=>$deltet_data->machine_number,'own_business'=>$deltet_data->business_number])->update($updated);
                break;
            case 2:
                $updated['own_business'] = '';
                $updated['business_end'] = NULL;
                $updated['used_status'] = 0;
                $row = DB::table('idc_machine')->where(['machine_num'=>$deltet_data->machine_number,'own_business'=>$deltet_data->business_number])->update($updated);
                break;
            case 3:
                $cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$deltet_data->machine_number])->select('own_business')->first();
                $array = explode(',',$cabinet->own_business);//先将原本的业务数据转换为数组
                $key = array_search($deltet_data->business_number,$array);//查找要删除的业务编号在数组的位置的键
                array_splice($array,$key,1);//根据查找的对应键进行删除
                $own_business = implode(',',$array);//将数组转换为字符串
                $row = DB::table('idc_cabinet')->where(['cabinet_id'=>$deltet_data->machine_number])->update(['own_business'=>$own_business]);
                break;
            }
            if($row == 0){
                DB::rollBack();
                $return['code'] = 0;
                $return['msg']  = '资源未释放,删除失败!';
                return $return;
            }
        }

        //查找业务关联订单
        $order_data = DB::table('tz_business')
            ->join('tz_orders', 'tz_business.business_number', '=', 'tz_orders.business_sn')
            ->where('tz_business.id', $delete_id['delete_id'])
            ->select('tz_orders.order_sn')
            ->get();
        //删除对应业务数据
        $result = DB::table('tz_business')->where('id', $delete_id['delete_id'])->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        if ($result == 0) {
            DB::rollBack();
            $return['code'] = 0;
            $return['msg']  = '删除失败!';
            return $return;
        }
        DB::commit();
        //存在关联订单
        if ($order_data) {
            $return['msg'] = '删除数据成功,关联订单号为:';
            foreach ($order_data as $key => $value) {
                $return['msg'] = $return['msg'] . $value->order_sn . ',';
            }
            $return['msg'] = rtrim($return['msg'], ',');
        } else {
            // 无关联订单
            $return['msg'] = '删除数据成功';
        }
        $return['code'] = 1;
        return $return;
    }


    /**
     * 查找用户准备过期的业务
     * (过期前5天)
     *
     * endding_time:业务结束 时间
     * @author ZhanJun
     */
    public function selectOverdueBusiness()
    {
        //判断  时间区间
        $data = $this
            ->where([                              //选定条件
                'business_status' => 2,                         //业务状态为已审核
//            'client_id'       => $userId,                  //用户ID
            ])
            ->whereBetween('endding_time', [date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime("+5 day"))]) //条件 :  时间区间为  过期前5天  到过期当天
            ->get();

        return $data;

    }

    /**
     * 信安录入业务数据
     * @param  [type] $insert_data [description]
     * @return [type]              [description]
     */
    public function securityInsertBusiness($insert_data){
        if (!$insert_data) {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#101)业务无法创建！！';
            return $return;
        }
        $sales = DB::table('admin_users')->where(['id'=>$insert_data['sales_id']])->select('id','name','username')->first();//查找业务信息
        if(empty($sales)){//业务员信息不存在
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#102)该业务员不存在,请确认后再创建业务!';
            return $return;
        }
        $client = DB::table('tz_users')->where(['id'=>$insert_data['client_id'],'status'=>2,'salesman_id'=>$insert_data['sales_id']])->select('id','name','email')->first();//查找对应的客户信息
        if(empty($client)){//客户信息不存在/拉黑
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#103)客户不存在/客户不属于业务员:'.$sales->name?$sales->name:$sales->username.'/账号未验证/异常,请确认后再创建业务!';
            return $return;
        }
        DB::beginTransaction();//开启事务处理
        if($insert_data['business_type'] == 1 || $insert_data['business_type'] == 2){
            $machine = DB::table('idc_machine')->where(['id'=>$insert_data['resource_id'],'business_type'=>$insert_data['business_type'],'used_status'=>0,'machine_status'=>0])->select('id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note','created_at','updated_at')->first();
            if(empty($machine)){
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '(#104)该机器资源不存在/已被使用/已下架,请确认后再创建业务!';
                return $return;
            }
            // dd($machine);
            $ip = $this->tranIp($machine->ip_id);
            $machine->ip = $ip['ip'];
            $machine->ip_detail = $ip['ip_detail'];
            $machine->machineroom_name = $this->machineroom($machine->machineroom);
            $machine->cabinets = $this->cabinets($machine->cabinet);
            $machine_status = [0=>'上架',1=>'下架'];
            $used_status = [0=>'未使用',1=>'业务锁定',2=>'使用中',3=>'锁定使用',4=>'迁移'];
            $business_type = [1=>'租用',2=>'托管',3=>'预备',4=>'托管预备'];
            $machine->used = $used_status[$machine->used_status];
            $machine->status = $machine_status[$machine->machine_status];
            $machine->business = $business_type[$machine->business_type];
            $machine->id = $machine->machine_num;
            $machine->machineroom_id = $machine->machineroom;
            $machine_update = DB::table('idc_machine')->where(['id'=>$insert_data['resource_id']])->update(['used_status'=>1]);
            if($machine_update == 0){
                DB::rollBack();
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '(#105)业务创建失败!';
                return $return;
            }
        } elseif($insert_data['business_type'] == 3){
            $machine = DB::table('idc_cabinet')->where(['id'=>$insert_data['resource_id']])->select('id','cabinet_id','machineroom_id')->first();
            if(empty($machine)){
                DB::rollBack();
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg']  = '(#106)该机柜资源不存在,请确认后再创建业务!';
                return $return;
            }
            $machine->machineroom_name = $this->machineroom($machine->machineroom_id);
            $machine->cabinetid = $machine->id;
            $machine->id = $machine->cabinet_id;
        }
        $business_id = mt_rand(10000,20000);
        $business_sn               = $this->businesssn($business_id,$insert_data['business_type']);
        $insert['business_number'] = $business_sn;
        $insert['business_status'] = 0;
        $insert['client_id'] = $insert_data['client_id']; 
        $insert['client_name'] = $client->name?$client->name:$client->email;
        // 对应业务员的信息
        $insert['sales_id']   = $insert_data['sales_id'];
        $insert['sales_name'] = $sales->name?$sales->name:$sales->username;
        $insert['business_type'] = $insert_data['business_type'];
        $insert['money'] = $insert_data['money'];
        $insert['length'] = $insert_data['length'];
        $insert['business_note'] = $insert_data['business_note'];
        $insert['machine_number'] = isset($machine->machine_num)?$machine->machine_num:$machine->cabinet_id;
        $insert['resource_detail'] = json_encode($machine);
        $insert['created_at'] = date('Y-m-d H:i:s',time());
        //业务开始时间
        $start_time = date('Y-m-d H:i:s',time());
        //到期时间的计算
        $end_time = time_calculation($start_time,$insert_data['length'],'month');
        $insert['start_time']   = $start_time;
        $insert['endding_time'] = $end_time;
        $row                  = DB::table('tz_business')->insertGetId($insert);
        if ($row == 0) {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#107)业务创建失败!';
            return $return;
        }
        $relevance = DB::table('tz_business_relevance')->insert(['type'=>1,'business_id'=>$insert['business_number'],'created_at'=>date('Y-m-d H:i:s',time())]);
        if($relevance == true){
            $xunsearch = new XS('business');
            $index = $xunsearch->index;
            $resource = json_decode($insert['resource_detail']);
            $doc['ip'] = isset($resource->ip)?strtolower($resource->ip):'';
            $doc['cpu'] = isset($resource->cpu)?strtolower($resource->cpu):'';
            $doc['memory'] = isset($resource->memory)?strtolower($resource->memory):'';
            $doc['harddisk'] = isset($resource->harddisk)?strtolower($resource->harddisk):'';
            $doc['id'] = strtolower($row);
            $doc['business_sn'] = strtolower($business_sn);
            $doc['machine_number'] = strtolower($insert['machine_number']);
            $doc['client'] = strtolower($insert['client_id']);
            $document = new \XSDocument($doc);
            $index->update($document);
            $index->flushIndex();
            DB::commit();
            $return['data'] = $row;
            $return['code'] = 1;
            $return['msg']  = '业务创建成功,业务号:'.$business_sn.',待审核!';
        }  else {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#108)业务创建失败!!';
        } 
            
        return $return;
    }

    /**
     * 转化IP
     * @param  [type] $ip_id [description]
     * @return [type]        [description]
     */
    public function tranIp($ip_id){
        if(!$ip_id){
            $ip['ip'] = '0.0.0.0';
            $ip['ip_detail'] = '0.0.0.0(未选)';
            return $ip;
        }
        $ips = DB::table('idc_ips')->where(['id'=>$ip_id])->select('ip','ip_company')->first();
        if(empty($ips)){
            $ip['ip'] = '0.0.0.0';
            $ip['ip_detail'] = '0.0.0.0(未找到)';
            return $ip;
        }
        $ip_company = [0=>'电信',1=>'移动',2=>'联通'];
        $ip['ip'] = $ips->ip;
        $ip['ip_detail'] = $ips->ip.'('.$ip_company[$ips->ip_company].')';
        return $ip;
    }

    /**
     * 转换机房名
     * @param  [type] $machineroom [description]
     * @return [type]              [description]
     */
    public function machineroom($machineroom){
        if(!$machineroom){
            $machineroom_name = '未选择';
            return $machineroom_name;
        }
        $machineroom_name = DB::table('idc_machineroom')->where(['id'=>$machineroom])->value('machine_room_name');
        return $machineroom_name;
    }

    /**
     * 转换机柜
     * @param  [type] $cabinet [description]
     * @return [type]          [description]
     */
    public function cabinets($cabinet){
        if(!$cabinet){
            $cabinets = '未选择';
            return $cabinets;
        }
        $cabinets = DB::table('idc_cabinet')->where(['id'=>$cabinet])->value('cabinet_id');
        return $cabinets;
    }

    /**
     * 一段时间内新增业务数据的相关信息(新增业务数据详情,统计数据)
     * @param  array $time 统计的起始时间和结束时间
     * @return array       返回相关的数据结果
     */
    public function newBusiness($time){

        $query_time = $this->queryTime($time);//获取起始时间和结束时间
        //新增业务量
        $new_total = DB::table('tz_business')
                       ->whereBetween('start_time',[$query_time['start_time'],$query_time['end_time']])
                       ->whereNull('deleted_at')
                       ->whereBetween('business_status',[0,4])
                       ->whereBetween('remove_status',[0,3])
                       ->count();
        //新增的业务数据信息
        $new_business = DB::table('tz_business')
                           ->whereBetween('start_time',[$query_time['start_time'],$query_time['end_time']])
                           ->whereNull('deleted_at')
                           ->whereBetween('business_status',[0,4])
                           ->whereBetween('remove_status',[0,3])
                           ->select('business_number','length','money','id','client_id','sales_id','business_type','machine_number','resource_detail','start_time','endding_time','business_status','remove_status','created_at')
                           ->get();
        if(!$new_business->isEmpty()){
            $new_business = $this->totalMoney($new_business,2);
        } else {
            $new_business['total'] = 0;
        }
        //总业务量
        $total = DB::table('tz_business')
                   ->whereNull('deleted_at')
                   ->whereBetween('business_status',[0,4])
                   ->whereBetween('remove_status',[0,3])
                   ->count();
        //所有在用的业务数据信息
        $business = DB::table('tz_business')
                       ->whereNull('deleted_at')
                       ->whereBetween('business_status',[0,4])
                       ->whereBetween('remove_status',[0,3])
                       ->select('business_number','length','money')
                       ->get();
        if(!$business->isEmpty()){
            $business = $this->totalMoney($business,1);
        } else {
            $business['total'] = 0;
        }
        return  [
            'code' => 1,
            'data' => ['business'=>isset($new_business['business'])?$new_business['business']:[],'new_total'=>$new_total,'new_money'=>$new_business['total'],'total'=>$total,'total_money'=>$business['total']],
            'msg' => '新增业务相关数据获取成功'
        ];


    }

    /**
     * 一段时间内新增下架业务数据的相关信息(新增业务数据详情,统计数据)
     * @param  array $time 统计的起始时间和结束时间
     * @return array       返回相关的数据结果
     */
    public function underBusiness($time){
        $query_time = $this->queryTime($time);//获取起始时间和结束时间

        //新下架业务量
        $under_total = DB::table('tz_business')
                       ->whereBetween('updated_at',[$query_time['start_time'],$query_time['end_time']])
                       ->whereNull('deleted_at')
                       ->whereBetween('business_status',[0,6])
                       ->where(['remove_status'=>4])
                       ->count();
        //新下架的业务信息
        $under_business = DB::table('tz_business')
                           ->whereBetween('updated_at',[$query_time['start_time'],$query_time['end_time']])
                           ->whereNull('deleted_at')
                           ->whereBetween('business_status',[0,6])
                           ->where(['remove_status'=>4])
                           ->select('business_number','length','money','id','client_id','sales_id','business_type','machine_number','resource_detail','start_time','endding_time','business_status','remove_status','created_at','remove_reason')
                           ->get();
        if(!$under_business->isEmpty()){
            $under_business = $this->totalMoney($under_business,4);
        } else {
            $under_business['total'] = 0;
        }
        //总下架业务量
        $total = DB::table('tz_business')
                   ->whereNull('deleted_at')
                   ->whereBetween('business_status',[0,6])
                   ->where(['remove_status'=>4])
                   ->count();
        //所有下架的业务信息
        $business = DB::table('tz_business')
                       ->whereNull('deleted_at')
                       ->whereBetween('business_status',[0,6])
                       ->where(['remove_status'=>4])
                       ->select('business_number','length','money')
                       ->get();
        if(!$business->isEmpty()){
            $business = $this->totalMoney($business,3);
        } else {
            $business['total'] = 0;
        }
        return  [
            'code' => 1,
            'data' => ['business'=>isset($under_business['business'])?$under_business['business']:[],'under_total'=>$under_total,'under_money'=>$under_business['total'],'total'=>$total,'total_money'=>$business['total']],
            'msg' => '下架业务相关数据获取成功'
        ];  
    }

    /**
     * 获取某段时间内新注册客户
     * @param  array $time 起始时间和结束时间
     * @return array       返回相关的数据信息
     */
    public function newRegistration($time){
        $query_time = $this->queryTime($time);//获取起始时间和结束时间

        //新注册客户量
        $create_total = DB::table('tz_users')
                       ->whereBetween('created_at',[$query_time['start_time'],$query_time['end_time']])
                       ->whereBetween('status',[1,2])
                       ->count();
        $create_info = DB::table('tz_users')
                       ->whereBetween('created_at',[$query_time['start_time'],$query_time['end_time']])
                       ->whereBetween('status',[1,2])
                       ->select('id','status','name','email','money','salesman_id','nickname','msg_phone','msg_qq','created_at')
                       ->get();
        if(!$create_info->isEmpty()){
            $status = [0=>'拉黑',1=>'未验证',2=>'正常'];
            foreach($create_info as $create_key=>$create_value){
                $create_value->user_status = $status[$create_value->status];
                $create_value->sales_name = DB::table('admin_users')->where(['id'=>$create_value->salesman_id])->value('name');
            }
            $return['code'] = 1;
            $return['msg'] = '获取新增客户数据成功';
        } else {
            $return['code'] = 1;
            $return['msg'] = '暂无新增客户数据';
        }
        //总注册客户量
        $total = DB::table('tz_users')
                   ->whereBetween('status',[1,2])
                   ->count(); 
        $return['data'] = ['create_total'=>$create_total,'info'=>$create_info,'total'=>$total];
        return $return;

    }

    /**
     * 获取订单的变化（统计订单）
     * @param  array $search begin--查询开始时间 end--查询结束时间 str--1=>查找所有,2=>未下架,3=>下架,4=>所有在用
     * @return [type]         [description]
     */
    public function changeMarket($search){
        if(!isset($search['str'])){
            $search['str'] = 4;
        }
        $status = [0,4];//查找的订单状态区间，默认0-4
        $remove = [0,3];//默认查找在用未下架的业务订单
        $time = 'created_at';//默认以创建时间为查询条件
        switch ($search['str']) {
            case 1:
                $begin_end = $this->queryTime($search);
                $remove = [0,4];//查找所有出现过的业务订单
                break;
            case 2:
                $begin_end = $this->queryTime($search);
                $remove = [0,3];//查找在用未下架的业务订单
                break;
            case 3:
                $begin_end = $this->queryTime($search);
                $remove = [4,4];//查找已下架的业务订单
                $time = 'updated_at';//下架时以下架时间作为查询条件
                break;
            default:
                $begin_end['start_time'] = '1970-01-01';
                $begin_end['end_time'] = date('Y-m-d',time());
                break;
        }
        //统计订单数量
        $orders_total = DB::table('tz_orders')
                        ->whereBetween($time,[$begin_end['start_time'],$begin_end['end_time']])
                        ->whereBetween('order_status',$status)
                        ->whereBetween('remove_status',$remove)
                        ->whereNull('deleted_at')
                        ->count();
        //查询符合条件的数据
        $orders_info = DB::table('tz_orders')
                        ->whereBetween($time,[$begin_end['start_time'],$begin_end['end_time']])
                        ->whereBetween('order_status',$status)
                        ->whereBetween('remove_status',$remove)
                        ->whereNull('deleted_at')
                        ->select('id','customer_id','business_id','resource_type','machine_sn','price','duration',$time.' as created_at')
                        ->get();
        //统计符合条件的月营收
        $month_total = DB::table('tz_orders')
                        ->whereBetween($time,[$begin_end['start_time'],$begin_end['end_time']])
                        ->whereBetween('order_status',$status)
                        ->whereBetween('remove_status',$remove)
                        ->whereNull('deleted_at')
                        ->sum('price'); 
        $total = 0;
        if(!$orders_info->isEmpty()){
            foreach($orders_info as $info_key => $info){
                $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
                $info->type = $resource_type[$info->resource_type];
                $money = bcmul($info->price,$info->duration,2);
                $info->money = $money;
                $total = bcadd($total,$money,2);
                $info->salesman = DB::table('admin_users')->where(['id'=>$info->business_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$info->customer_id])->select('name','email','nickname','msg_phone','msg_qq')->first();
                $email = $client_name->email ? $client_name->email : $client_name->name;
                $email = $email ? $email : $client_name->nickname;
                $info->customer = $email;
            }
        }
        $return['code'] = 1;
        $return['msg'] = '';
        $return['data'] = ['orders_total'=>$orders_total,'info'=>$orders_info?$orders_info:[],'total'=>$total,'month_total'=>$month_total];
        return $return;
    }

    /**
     * 计算查询的起始时间和结束时间
     * @param  array $query_time begin--查询时间段的开始时间 end--查询时间段的结束时间
     * @return array             返回查询的起始时间和结束时间
     */
    public function queryTime($query_time){
        if(!isset($query_time['begin']) && !isset($query_time['end'])){//当查询开始间和结束时间都未设置时

            $end_time = date('Y-m-d',time());//结束时间等于当前时间
            $month = date('Y-m',time());//获取结束时间所属自然月
            $start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

        } elseif(isset($query_time['begin']) && !isset($query_time['end'])){//当设置查询开始时间，未设置结束时间时

            $start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
            $month = date('Y-m',$query_time['begin']);//获取开始时间所属自然月
            $last_day = date('t',$month);//获取开始时间所属自然月的总天数
            $end_time = $month.'-'.$last_day;//结束时间设置为开始时间所属自然月的最后一天的23:59:59

        } elseif(!isset($query_time['begin']) && isset($query_time['end'])){//当起始时间未设置，结束时间设置时

            $end_time = date('Y-m-d',$query_time['end']);//结束时间等于设置的结束时间
            $month = date('Y-m',$query_time['end']);//获取结束时间所属的自然月
            $start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

        } elseif(isset($query_time['begin']) && isset($query_time['end'])){//当查询的起始时间和结束时间都设置时

            $start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
            $end_time = date('Y-m-d',$query_time['end']);//结束时间等于设置的结束时间
        }
        return ['start_time'=>$start_time,'end_time'=>$end_time];
    }

    /**
     * 统计业务的营业额
     * @param  array  $business 所有业务的数据
     * @param  integer $range    1--代表统计所有的未下架的业务，2--代表统计某一段时间内的新增业务，3--代表统计所有下架业务，4--代表统计某一段时间内下架的业务
     * @return array            返回修改后的相关业务数据
     */
    public function totalMoney($business,$range=1){
        $total = 0;
        $total_business = [];
        if($range == 1 || $range == 2){
            $removes = '<';
        } elseif($range == 3 || $range == 4){
            $removes = '='; 
        }
        foreach($business as $business_key => $business_value){
            if($range == 1 || $range == 2){
                $single_total = bcmul($business_value->money,$business_value->length,2);//每笔业务的总营业额
            } elseif($range == 3 || $range == 4){
                $single_total = $business_value->money;//每笔业务的月营业额
            }
            
            $order = DB::table('tz_orders')
                       ->where(['business_sn'=>$business_value->business_number])
                       ->where('resource_type','>',3)
                       ->where('order_status','<',5)
                       ->where('remove_status',$removes,4)
                       ->whereNull('deleted_at')
                       ->select('price','duration')
                       ->get();
            if(!$order->isEmpty()){
                foreach($order as $order_key => $order_value){
                    if($range == 1 || $range == 2){
                       $order_money = bcmul($order_value->price,$order_value->duration,2);//每笔资源的总营业额
                    } elseif($range == 3 || $range == 4){
                        $order_money = $order_value->price;//每笔资源的月营业额
                    }
                    $single_total = bcadd($single_total,$order_money,2);//每笔业务的总营业额
                }   
            }
            if($range == 2 || $range == 4){//当统计新增业务数据时
                $business_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜'];
                $business_status = ['-1'=>'取消','-2'=>'审核不通过',0=>'审核中',1=>'未付款使用',2=>'付款使用中',3=>'未使用',4=>'锁定中',5=>'到期',6=>'退款'];
                $remove_status = [0=>'正常',1=>'下架申请中',2=>'等待机房处理',3=>'清空下架中',4=>'下架完成'];
                $business_value->sales_name = DB::table('admin_users')->where(['id'=>$business_value->sales_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$business_value->client_id])->select('name','email','nickname','msg_phone','msg_qq')->first();
                $email = $client_name->email ? $client_name->email : $client_name->name;
                $email = $email ? $email : $client_name->nickname;
                $business_value->client_name = $email;
                $resource_detail =  json_decode($business_value->resource_detail);
                $business_value->ip = isset($resource_detail->ip_detail)?$resource_detail->ip_detail:'';
                $business_value->cabinet = isset($resource_detail->cabinets)?$resource_detail->cabinets:'';
                $business_value->machineroom = isset($resource_detail->machineroom_name)?$resource_detail->machineroom_name:'';
                $business_value->type = $business_type[$business_value->business_type];
                $business_value->status = $business_status[$business_value->business_status];
                $business_value->remove = $remove_status[$business_value->remove_status];
                $business_value->single_total = $single_total;//将每笔的业务营业额统计进去
                $taotal_business['business'][]=$business_value;//将含对应业务营业额的数据形成新的数据
            }
             
            $total = bcadd($total,$single_total,2);//总营业额        
        }
        $taotal_business['total'] =  $total;
        return $taotal_business;
    }



}
