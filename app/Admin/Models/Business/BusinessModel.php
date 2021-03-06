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
    protected $fillable = ['client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'money', 'length','start_time','endding_time', 'business_status', 'business_note', 'remove_status', 'remove_reason', 'check_note', 'created_at', 'updated_at','monthly'];

    /**
     * 创建业务数据
     * @param  array $insert 需要创建业务的数据
     * @return array         返回创建业务时的id和状态及提示信息
     */
    public function insertBusiness($insert)
    {
        // dd($insert);
        if (!$insert) {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '业务无法创建！！';
            return $return;
        }
        //业务编号的生成规则：前两位（1-3的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 7-9随机数（业务编号产生）
        $client = DB::table('tz_users')->where(['id'=>$insert['client_id'],'status'=>2])->select('nickname','salesman_id')->first();
        if(!$client){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '客户不存在或账号未验证/异常,请确认后再创建业务!';
            return $return;
        }
        DB::beginTransaction();//开启事务处理
        // $business_id = mt_rand(10000,20000);
        $business_sn               = $this->businesssn();
        $insert['business_number'] = $business_sn;
        $insert['business_status'] = 0;
        $insert['client_name'] = $client->nickname;
        // 对应业务员的信息
        $insert['sales_id']   = $client->salesman_id;
        $insert['sales_name'] = DB::table('admin_users')->where(['id'=>$client->salesman_id])->value('name');
        $insert['created_at'] = date('Y-m-d H:i:s',time());
        //业务开始时间
        $start_time = date('Y-m-d H:i:s',time());
        $monthly = isset($insert['monthly'])?$insert['monthly']:0;
        //到期时间的计算
        $end_time = time_calculation($start_time,$insert['length'],'month',$monthly);
        $insert['start_time']   = $start_time;
        $insert['endding_time'] = $end_time;
        $insert_data = $this->fill($insert)->toArray();//过滤掉多余字段
        $row                  = DB::table('tz_business')->insertGetId($insert_data);
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
     * 机柜业务下添加托管机器
     * @param  array $data 'customer'--客户id,'parent_business'--机柜业务id,
     * 'resource_type'--资源类型,'resource_id'--资源id,'price'--价格,'duration'--时长,'business_note'--业务备注
     * @return [type]       [description]
     */
    public function cabinetMachine($data){

        if(empty($data)){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#101)业务无法创建！！';
            return $return;
        }

        $sales = DB::table('tz_users')->where(['id'=>$data['customer']])->value('salesman_id');
        $data['sales'] = $sales == Admin::user()->id ? Admin::user()->id : $sales;

        $business = DB::table('tz_business')
                      ->where(['id'=>$data['parent_business']])
                      ->whereBetween('business_status',[0,5])
                      ->whereBetween('remove_status',[0,1])
                      ->value('id');
        if(empty($business)){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#102)请确认机柜业务未过期/未下架';
            return $return;
        }

        $machine = DB::table('idc_machine as machine')->join('tz_machine_customer as mc','machine.id','=','mc.machine_id')
                    ->where(['machine.id'=>$data['resource_id'],'mc.customer_id'=>$data['customer'],'used_status'=>0,'machine_status'=>0])
                    ->whereNull('machine.deleted_at')
                    ->select('machine.id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom as machineroom_id','bandwidth','protect','loginname','loginpass')
                    ->first();
        if(empty($machine)){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#103)选择的机器不存在/不属于此客户/已被使用';
            return $return;
        }

        $start_time = date('Y-m-d H:i:s',time());
        $data['starttime'] = $start_time;
        $data['endtime'] = time_calculation($start_time,$data['duration'],'month');
        $data['business_number'] = $this->businesssn();
        $data['resource_sn'] = $machine->machine_num;
        $data['room_id'] = $machine->machineroom_id;
        $data['cabinet_id'] = $machine->cabinet;
        $data['ip_id'] = $machine->ip_id;
        $data['created_at'] = $start_time;
        $data['updated_at'] = $start_time;

        DB::beginTransaction();
        $row = DB::table('tz_cabinet_machine')->insertGetId($data);
        if($row == 0){
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#104)机柜添加托管机器失败';
            return $return;
        }

        $machine->cabinets = $this->cabinets($machine->cabinet);
        $machine->machineroom_name = $this->machineroom($machine->machineroom_id);
        $ip = $this->tranIp($machine->ip_id);
        $machine->ip = $ip['ip'];
        $machine->ip_detail = $ip['ip_detail'];

        $detail['detail'] = json_encode($machine);
        $detail['business_id'] = $row;
        $detail['parent_id'] = $data['parent_business'];
        $detail['created_at'] = $start_time;
        $detail['updated_at'] = $start_time;
        $result = DB::table('tz_cabinet_machine_detail')->insertGetId($detail);
        if($result == 0){
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#105)机柜添加托管机器失败';
            return $return;
        }

        $machine_row = DB::table('idc_machine')->where(['id'=>$data['resource_id']])->update(['used_status'=>1,'updated_at'=>date('Y-m-d H:i:s',time())]);
        if($machine_row == 0){
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#106)机柜添加托管机器失败';
            return $return;
        }

        $xunsearch = new XS('business');
        $index = $xunsearch->index;
        $resource = json_decode($insert['resource_detail']);
        $doc['ip'] = isset($machine->ip)?strtolower($machine->ip):'';
        $doc['cpu'] = isset($machine->cpu)?strtolower($machine->cpu):'';
        $doc['memory'] = isset($machine->memory)?strtolower($machine->memory):'';
        $doc['harddisk'] = isset($machine->harddisk)?strtolower($machine->harddisk):'';
        $doc['id'] = strtolower($row);
        $doc['business_sn'] = strtolower($business_sn);
        $doc['machine_number'] = strtolower($data['business_number']);
        $doc['client'] = strtolower($data['customer']);
        $document = new \XSDocument($doc);
        $index->update($document);
        $index->flushIndex();

        DB::commit();
        $return['data'] = $row;
        $return['code'] = 1;
        $return['msg']  = '机柜添加托管机器成功,请耐心等待审核';
        return $return;

    }

    /**
     * 信安部门查看业务数据获取
     * @return array 返回相关的数据和状态及提示信息
     */
    public function securityBusiness()
    {
        $result = $this->whereBetween('business_status',[0,5])->where('remove_status','<',4)->orderBy('created_at','desc')->get(['id', 'client_id', 'sales_id', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'business_note','created_at','start_time','endding_time','remove_status','check_note','monthly']);
        if (!$result->isEmpty()) {
            $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
            $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            foreach ($result as $check => $check_value) {
                $result[$check]['status'] = $business_status[$check_value['business_status']];
                $result[$check]['type']   = $business_type[$check_value['business_type']];
                $result[$check]['remove'] = $remove_status[$check_value['remove_status']];
                $check_value->sales_name = DB::table('admin_users')->where(['id'=>$check_value->sales_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$check_value->client_id])->value('nickname');
                $check_value->client_name = $client_name;
                $resource_detail = json_decode($check_value['resource_detail']);
                $result[$check]['machineroom_name'] = $resource_detail->machineroom_name;
                $result[$check]['parent_business'] = 0;
                if($check_value['business_type'] != 3){
                    $result[$check]['cabinets'] = $resource_detail->cabinets;
                    $result[$check]['ip'] = isset($resource_detail->ip)?$resource_detail->ip:'暂未配置IP';
                } else {    
                    $result[$check]['cabinets'] = $resource_detail->cabinet_id;
                    $result[$check]['ip'] = '';
                }
            }
        }
        
        $security = $this->securityCabinetBusiness();
        $cabinetmachine = array_merge($result->toArray(),$security->toArray());
    
        $created_at = array_column($cabinetmachine,'created_at');

        array_multisort($created_at,SORT_DESC,$cabinetmachine);
        $return['data'] = $cabinetmachine;
        $return['code'] = 1;
        $return['msg']  = '相关业务数据获取成功';
        return $return;
    }

    /**
     * 审核时获取机柜业务下的机器信息
     * @return [type] [description]
     */
    public function securityCabinetBusiness(){

        $result = DB::table('tz_cabinet_machine as mc')
                    ->leftjoin('tz_users as user','mc.customer','=','user.id')
                    ->leftjoin('admin_users as admin','mc.sales','=','admin.id')
                    ->leftjoin('tz_cabinet_machine_detail as detail','mc.id','=','detail.business_id')
                    ->whereBetween('business_status',[0,3])
                    ->whereBetween('remove_status',[0,3])
                    ->orderBy('created_at','desc')
                    ->get(['mc.id','sales as sales_id','customer as client_id','business_number','parent_business','resource_type as business_type','resource_sn as machine_number','detail as resource_detail','business_status','price as money','duration as length','business_note','mc.created_at','starttime as start_time','endtime as endding_time','remove_status','check_note','user.nickname as client_name','admin.name as sales_name','room_id','cabinet_id','ip_id']);
        if(!$result->isEmpty()){
            $business_status = [-1 => '审核不通过',0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
            $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            foreach($result as $check => $check_value){
                $check_value->status = $business_status[$check_value->business_status];
                $check_value->type   = $business_type[$check_value->business_type];
                $check_value->remove = $remove_status[$check_value->remove_status];
                $check_value->machineroom_name = $this->machineroom($check_value->room_id);
                if($check_value->business_type != 3){
                    $check_value->cabinets = $this->cabinets($check_value->cabinet_id);
                    $check_value->ip = $this->tranIp($check_value->ip_id)['ip'];
                }
            }

        }
        
        return $result;
    }

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
        if($where['parent_business'] == 0){
            //普通的IDC业务
            $check = DB::table('tz_business')->where($check_where)->select('client_id','id','business_number', 'client_name', 'sales_id', 'sales_name', 'business_type', 'machine_number', 'money', 'length','resource_detail','endding_time','monthly','start_time')->first();
        } else {
            //机柜业务下的托管机器业务
            $check = DB::table('tz_cabinet_machine as mc')->leftjoin('tz_cabinet_machine_detail as detail','mc.id','=','detail.business_id')->where($check_where)->select('mc.id','business_number','resource_sn as machine_number','resource_type as business_type','detail as resource_detail','endtime as endding_time')->first();
        }
        
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
            if($where['parent_business'] != 0){
                //机柜业务下的托管机器业务
                $business['business_status'] = '-1';
            }

            // 审核为不通过时直接进行业务的状态更改
            $business['remove_status'] = 4;
            if($where['parent_business'] != 0){
                //机柜业务下的托管机器业务
                $row = DB::table('tz_cabinet_machine')->where($check_where)->update($business);
            } else {
                //普通的IDC业务
                $row = DB::table('tz_business')->where($check_where)->update($business);
            }
            
            if($row == 0){
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!';
                return $return;
            }

            if($check->business_type != 3){
                $omachine = DB::table('idc_machine')->where(['machine_num'=>$check->machine_number,'used_status'=>0])->first();//先检查是否该机器状态为未使用
                if(empty($omachine)){
                    //不是未使用，更新成未使用状态，是的话就不更新
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

        $order_sn                 = $this->ordersn();
        $business['updated_at']   = date('Y-m-d H:i:s',time());
        if($where['parent_business'] == 0){

            //普通IDC业务
            $business['order_number'] = $order_sn;
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
            $price = $order['price'];
            $duration = $order['duration'];
            if($check->monthly != 0){
                $price = bcdiv($price,30,2);//一天的价格
                $duration = date_diff(date_create(date('Y-m-d',strtotime($check->start_time))),date_create(date('Y-m-d',strtotime($check->endding_time))))->format('%a');
            }
            $order['payable_money'] = bcmul($price, $duration, 2);//应付金额
            $order['created_at']    = date('Y-m-d H:i:s',time());
            $order_row              = DB::table('tz_orders')->insert($order);//生成订单
            if ($order_row != true) {
                // 订单生成失败
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '(#102)审核失败!!!';
                return $return;
            }
        } else {
            $business['business_status'] = 2;
            $business_row = DB::table('tz_cabinet_machine')->where($check_where)->update($business);
            if ($business_row == 0) {
                // 业务审核失败
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '(#103)审核失败!!';
                return $return;
            }            
        }
        
        if ($check->business_type == 1 || $check->business_type == 2) {
            // 如果是租用/托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $machine['own_business'] = $where['business_number'];
            $machine['business_end'] = $check->endding_time;
            $machine['used_status']  = 2;
            $row                     = DB::table('idc_machine')->where(['machine_num'=>$check->machine_number])->update($machine);
            if ($row == 0) {
                DB::rollBack();
                $return['data'] = '审核失败';
                $return['code'] = 0;
                $return['msg']  = '审核失败!!!!';
                return $return;
            }
            $ip_id = json_decode($check->resource_detail)->ip_id;
            if($ip_id != 0){
                $row = DB::table('idc_ips')->where(['id'=>$ip_id])->update(['own_business' => $where['business_number'],'mac_num'=>$check->machine_number]);
            } else {
                $row = 1;
            }
            
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
     * 业务员和管理员查看对应客户的业务数据
     * @param  array $show 客户的id即业务表的client_id字段
     * @return array        返回相关的数据和状态提示及信息
     */
    public function showBusiness($show)
    {
        if ($show) {
            $result = $this->where($show)->whereBetween('business_status',[0,5])->where('remove_status','<',4)->orderBy('created_at','desc')->get(['id', 'client_id', 'client_name', 'sales_id', 'sales_name', 'order_number', 'business_number', 'business_type', 'machine_number', 'resource_detail', 'business_status', 'money', 'length', 'start_time', 'endding_time', 'business_note','remove_status','monthly']);
            if (!$result->isEmpty()) {
                $business_status = [-1 => '取消', -2 => '审核不通过', 0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
                $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
                $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
                foreach ($result as $check => $check_value) {
                    $result[$check]['status'] = $business_status[$check_value['business_status']];
                    $result[$check]['type']   = $business_type[$check_value['business_type']];
                    $result[$check]['remove'] = $remove_status[$check_value['remove_status']];
                    $result[$check]['parent_business'] = 0;
                    $resource_detail = json_decode($check_value['resource_detail']);
                    if($check_value['business_type'] != 3){
                        $result[$check]['cabinets'] = isset($resource_detail->cabinets)?$resource_detail->cabinets:'';
                    } else {    
                        $result[$check]['cabinets'] = isset($resource_detail->cabinet_id)?$resource_detail->cabinet_id:'';
                    }
                }
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg']  = '相关业务数据获取成功';
            } else {
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg']  = '暂无业务数据';
            }

            return $return;
        }
    }

    /**
     * 根据机柜业务的业务id进行机柜下的机器数据获取
     * @param  array $param --parent_business,机柜业务id
     * @return [type]        [description]
     */
    public function showCabinetMachine($param){

        if(empty($param)){
            $return['data'] = [];
            $return['code'] = 1;
            $return['msg']  = '无法获取该机柜业务下的机器';
            return $return;
        }  

        $show = DB::table('tz_cabinet_machine as mc')
                   ->leftjoin('tz_users as user','mc.customer','=','user.id')
                   ->leftjoin('admin_users as admin','mc.sales','=','admin.id')
                   ->where($param)
                   ->whereBetween('business_status',[0,3])
                   ->whereBetween('remove_status',[0,3])
                   ->whereNull('mc.deleted_at')
                   ->orderBy('created_at','desc')
                   ->get(['mc.id','sales as sales_id','customer as client_id','business_number','parent_business','resource_type as business_type','resource_sn as machine_number','business_status','price as money','duration as length','business_note','mc.created_at','starttime as start_time','endtime as endding_time','remove_status','check_note','user.nickname as client_name','admin.name as sales_name','room_id','cabinet_id','ip_id']);

        if(!$show->isEmpty()){
            $business_status = [-1 => '审核不通过',0 => '审核中', 1 => '未付款使用', 2 => '付款使用中', 3 => '未付用', 4 => '锁定中', 5 => '到期', 6 => '退款'];
            $business_type   = [1 => '租用主机', 2 => '托管主机', 3 => '租用机柜'];
            $remove_status = [0 => '正常使用', 1 => '下架申请中', 2 => '机房处理中', 3 => '清空下架中', 4 => '下架完成'];
            foreach($show as $check => $check_value){
                $check_value->status = $business_status[$check_value->business_status];
                $check_value->type   = $business_type[$check_value->business_type];
                $check_value->resource_type   = $check_value->business_type;
                $check_value->remove = $remove_status[$check_value->remove_status];
                $check_value->machineroom_name = $this->machineroom($check_value->room_id);
                if($check_value->business_type != 3){
                    $check_value->cabinets = $this->cabinets($check_value->cabinet_id);
                    $check_value->ip = $this->tranIp($check_value->ip_id)['ip'];
                }
            }
                $return['data'] = $show;
                $return['code'] = 1;
                $return['msg']  = '相关业务数据获取成功';
        } else {
            $return['data'] = $show;
            $return['code'] = 1;
            $return['msg']  = '暂无业务数据';
        }
        return $return;
 
    }

    /**
     * 获取机柜业务下机器的详情
     * @param  array $detail_param --business_id,机器业务的id
     * @return [type]               [description]
     */
    public function cabinetMachineDetail($detail_param){

        if(empty($detail_param)){
            $return['data'] = [];
            $return['code'] = 1;
            $return['msg']  = '无法获取该机器的详情';
            return $return;
        }

        $detail = json_decode(DB::table('tz_cabinet_machine_detail')->where($detail_param)->whereNull('deleted_at')->value('detail'));
        $return['data'] = $detail;
        $return['code'] = 1;
        $return['msg']  = '获取该机器的详情成功';
        return $return;
    }

    /**
     * 创建业务号
     * @return [type] [description]
     */
    public function businesssn(){
        
        $business_sn = create_number();//调用创建单号的公共函数
    
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
    public function ordersn(){
       
        $order_sn = create_number();//调用创建单号的公共函数,
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
        $client = DB::table('tz_users')->where(['id'=>$insert_data['client_id'],'status'=>2,'salesman_id'=>$insert_data['sales_id']])->value('nickname');//查找对应的客户信息
        if(empty($client)){//客户信息不存在/拉黑
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg']  = '(#103)客户不存在/客户不属于业务员:'.$client.'/账号未验证/异常,请确认后再创建业务!';
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

        $business_sn               = $this->businesssn();
        $insert['business_number'] = $business_sn;
        $insert['business_status'] = 0;
        $insert['client_id'] = $insert_data['client_id']; 
        $insert['client_name'] = $client;
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
        $monthly = isset($insert_data['monthly'])?$insert_data['monthly']:0;
        //到期时间的计算
        $end_time = time_calculation($start_time,$insert_data['length'],'month',$monthly);
        $insert['monthly'] = $monthly;
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
        $ip['ip'] = $ips->ip;
        $ip['ip_detail'] = $ips->ip.'('.line($ips->ip_company).')';
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
                $remove = [0,4];//查找所有出现过的业务订单
                break;
            case 2:
                $remove = [0,3];//查找在用未下架的业务订单
                break;
            case 3:
                $remove = [4,4];//查找已下架的业务订单
                $time = 'updated_at';//下架时以下架时间作为查询条件
                break;
            default:
                $begin_end['end_time'] = date('Y-m-d',time());
                break;
        }
        //统计订单数量
        $orders_total = DB::table('tz_orders')
                        ->whereBetween('order_status',$status)
                        ->whereBetween('remove_status',$remove)
                        ->whereNull('deleted_at')
                        ->count();
        //查询符合条件的数据
        $orders_info = DB::table('tz_orders')
                        ->whereBetween('order_status',$status)
                        ->whereBetween('remove_status',$remove)
                        ->whereNull('deleted_at')
                        ->select('id','customer_id','business_id','resource_type','business_sn','machine_sn','price','duration',$time.' as created_at')
                        ->get();

        $total = 0;
        if(!$orders_info->isEmpty()){
            foreach($orders_info as $info_key => $info){
                $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP',12=>'流量叠加包'];
                $info->type = $resource_type[$info->resource_type];
                $money = bcmul($info->price,$info->duration,2);
                $info->money = $money;
                $total = bcadd($total,$money,2);
                $info->salesman = DB::table('admin_users')->where(['id'=>$info->business_id])->value('name');
                $client_name = DB::table('tz_users')->where(['id'=>$info->customer_id])->value('nickname');
                $info->customer = $client_name;
                if($info->resource_type == 11){
                    $business = DB::table('tz_defenseip_business as business')
                                   ->join('tz_defenseip_store as store','business.ip_id','=','store.id')
                                   ->join('idc_machineroom as room','store.site','=','room.id')
                                   ->where('business.business_number',$info->business_sn)
                                   ->select('store.ip','room.machine_room_name as machineroom_name')
                                   ->first();
                    if(!empty($business)){
                        $info->machine_sn = $business->ip;
                    }
                } else {
                    $resource_detail = DB::table('tz_business')->where('business_number',$info->business_sn)->select('resource_detail')->first();
                    if(!empty($resource_detail)){
                        $business = json_decode($resource_detail->resource_detail);
                    }
                }
                if(!empty($business)){
                    $info->machineroom_name = $business->machineroom_name;
                } else {
                    $info->machineroom_name = '机房不明';
                }

            }
        }
        $return['code'] = 1;
        $return['msg'] = '';
        $return['data'] = ['orders_total'=>$orders_total,'info'=>$orders_info?$orders_info:[],'total'=>$total];
        return $return;
    }

    /**
     * 市场变化统计的时候统计充值记录
     * @param  [type] $time [description]
     * @return [type]       [description]
     */
    public function marketRecharge($time){
        if(!isset($time)){
            $query_time['begin'] = 1388505600;//(2014-01-01 00:00:00);
            $query_time['end'] = time();
        }
        if(!isset($time['startTime'])){
            $query_time['begin'] = 1388505600;//(2014-01-01 00:00:00);
        }
        if(!isset($time['endTime'])){
            $query_time['end'] = time();
        }
        if(isset($time['startTime']) && isset($time['endTime'])){
            $query_time['begin'] = $time['startTime'];
            $query_time['end'] = $time['endTime'];
        }
        $begin_end = $this->queryTime($query_time);
        $recharge_total = DB::table('tz_recharge_flow')
                            ->where(['trade_status'=>1])
                            ->where('created_at','>=',$begin_end['start_time'])
                            ->where('created_at','<=',$begin_end['end_time'])
                            ->whereNull('deleted_at')
                            ->sum('recharge_amount');
        $tax_total =  DB::table('tz_recharge_flow')
                            ->where(['trade_status'=>1])
                            ->where('created_at','>=',$begin_end['start_time'])
                            ->where('created_at','<=',$begin_end['end_time'])
                            ->whereNull('deleted_at')
                            ->sum('tax');
        $return['data'] = ['month_total'=>$recharge_total,'tax_total'=>$tax_total];
        $return['msg'] = '';
        $return['code'] = 1;
        return $return;
    }

    /**
     * 计算查询的起始时间和结束时间
     * @param  array $query_time begin--查询时间段的开始时间 end--查询时间段的结束时间
     * @return array             返回查询的起始时间和结束时间
     */
    public function queryTime($query_time){
        if(!isset($query_time['begin']) && !isset($query_time['end'])){//当查询开始间和结束时间都未设置时

            $end_time = date('Y-m-d',strtotime("+1 day"));//结束时间等于当前时间往后推一天，即当前天的23:59:59
            $month = date('Y-m',time());//获取结束时间所属自然月
            $start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

        } elseif(isset($query_time['begin']) && !isset($query_time['end'])){//当设置查询开始时间，未设置结束时间时

            $start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
            $month = date('Y-m',$query_time['begin']);//获取开始时间所属自然月
            $last_day = date('t',$month);//获取开始时间所属自然月的总天数
            $end_time = date('Y-m-d',strtotime($month.'-'.$last_day."+1 day"));//结束时间设置为开始时间所属自然月的最后一天的23:59:59

        } elseif(!isset($query_time['begin']) && isset($query_time['end'])){//当起始时间未设置，结束时间设置时

            $end_time = date('Y-m-d',strtotime(date('Y-m-d',$query_time['end'])."+1 day"));//结束时间等于设置的结束时间
            $month = date('Y-m',$query_time['end']);//获取结束时间所属的自然月
            $start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

        } elseif(isset($query_time['begin']) && isset($query_time['end'])){//当查询的起始时间和结束时间都设置时

            $start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
            $end_time = date('Y-m-d',strtotime(date('Y-m-d',$query_time['end'])."+1 day"));//结束时间等于设置的结束时间
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
                $client_name = DB::table('tz_users')->where(['id'=>$business_value->client_id])->value('nickname');
                $business_value->client_name = $client_name;
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

    /**
     * 根据业绩统计的业务员进行对应的业务订单查询
     * @param  array $data --begin查询开始时间, --end查询结束时间,business_id业务员id
     * @return [type]       [description]
     */
    public function performanceOrder($data){
        $time = $this->queryTime($data);
        $where = [];
        if(isset($data['business_id'])){
            $where['business_id'] = $data['business_id'];
        }
        $orders = [];
        $flow = DB::table('tz_orders_flow')
                    ->where($where)
                    ->whereBetween('pay_time',[$time['start_time'],$time['end_time']])
                    ->whereNull('deleted_at')
                    ->get(['order_id']);

        if($flow->isEmpty()){
            $return['data'] = $orders;
            $return['code'] = 0;
            $return['msg'] = '暂无数据';
            return $return;
        }

        $order_id = '';
        foreach ($flow as $flow_key => $flow_value) {
            $order_id = trim($order_id.','.trim($flow_value->order_id,'[]'),',');
        }
        $id = array_unique(explode(',',$order_id));
        foreach ($id as $id_key => $id_value) {
            $order = DB::table('tz_orders as orders')
                        ->join('admin_users as admin','orders.business_id','=','admin.id')
                        ->join('tz_users as users','orders.customer_id','=','users.id')
                        ->where(['orders.id'=>$id_value])
                        ->select('orders.id','orders.order_sn','orders.resource_type','orders.machine_sn','orders.resource','orders.price','orders.duration','orders.end_time','admin.name as salesman','users.nickname')
                        ->first();
            if(!empty($order)){
                $order->customer = $order->nickname;
                $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP',12=>'流量叠加包'];
                $order->type = $resource_type[$order->resource_type];
                array_push($orders,$order); 
            }
        }

        $return['data'] = $orders;
        $return['code'] = 1;
        $return['msg'] = '数据获取成功';
        return $return;

    } 


}
