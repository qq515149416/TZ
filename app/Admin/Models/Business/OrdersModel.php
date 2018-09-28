<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\Idc\Ips;
use App\Admin\Models\Idc\Cpu;
use App\Admin\Models\Idc\Harddisk;
use App\Admin\Models\Idc\Memory;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
use Encore\Admin\Facades\Admin;

/**
 * 后台订单模型
 */
class OrdersModel extends Model
{
	use SoftDeletes;
	protected $table = 'tz_orders';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

    /**
     * 财务人员和管理人员查看订单
     * @param  array $where 订单的状态
     * @return array        返回相关的数据信息和提示状态及信息
     */
    public function financeOrders($where){
    	$result = $this->where($where)
    				->get(['id','order_sn','customer_name','business_sn','business_name','before_money','after_money','resource_type','order_type','resource','price','duration','payable_money','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']);
    	if(!$result->isEmpty()){
    		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
    		$order_type = [1=>'新购',2=>'续费'];
    		$pay_type = [1=>'余额',2=>'支付宝',3=>'微信',4=>'其他'];
    		$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'取消',5=>'申请退款',6=>'退款完成'];
    		foreach($result as $okey=>$ovalue){
    			$result[$okey]['resource_type'] = $resource_type[$ovalue['resource_type']];
    			$result[$okey]['order_type'] = $order_type[$ovalue['order_type']];
    			$result[$okey]['pay_type'] = $pay_type[$ovalue['pay_type']];
    			$result[$okey]['order_status'] = $order_status[$ovalue['order_status']];
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '订单获取成功';
    	} else {
    		$return['data'] = '暂无订单';
    		$return['code'] = 0;
    		$return['msg'] = '暂无对应订单';
    	}

    	return $return;
    }
    
    /**
     * 业务员和管理人员通过业务查看订单
     * @param  array $where 订单的状态
     * @return array        返回相关的数据信息和提示状态及信息
     */
    public function clerkOrders($where){
    	$result = $this->where($where)->get(['id','order_sn','customer_name','business_sn','business_name','before_money','after_money','resource_type','order_type','resource','price','duration','payable_money','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']);
    	if(!$result->isEmpty()){
    		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
    		$order_type = [1=>'新购',2=>'续费'];
    		$pay_type = [1=>'余额',2=>'支付宝',3=>'微信',4=>'其他'];
    		$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'取消',5=>'申请退款',6=>'退款完成'];
    		foreach($result as $okey=>$ovalue){
    			$result[$okey]['resource_type'] = $resource_type[$ovalue['resource_type']];
    			$result[$okey]['order_type'] = $order_type[$ovalue['order_type']];
    			$result[$okey]['pay_type'] = $pay_type[$ovalue['pay_type']];
    			$result[$okey]['order_status'] = $order_status[$ovalue['order_status']];
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '订单获取成功';
    	} else {
    		$return['data'] = '暂无订单';
    		$return['code'] = 0;
    		$return['msg'] = '暂无对应订单';
    	}

    	return $return;
    }

    /**
     * 返回对应要增加的资源数据
     * @param  array $resource_data 资源类型
     * @return array                返回对应的资源数据和状态及提示信息
     */
    public function resource($resource_data){
        if(!$resource_data){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法获取资源数据';
            return $return;
        }
        switch ($resource_data['resource_type']) {
            case 4:
                $ips = new Ips();
                $result = $ips->selectIps($resource_data['machineroom']);
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg'] = 'IP资源数据获取成功';
                break;
            case 5:
                $cpu = new Cpu();
                $result = $cpu->selectCpu($resource_data['machineroom']);
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg'] = 'CPU资源数据获取成功';
                break;
            case 6:
                $harddisk = new Harddisk();
                $result = $harddisk->selectHarddisk($resource_data['machineroom']);
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg'] = '硬盘资源数据获取成功';
                break;
            case 7:
                $memory = new Memory();
                $result = $memory->selectMemory($resource_data['machineroom']);
                $return['data'] = $result;
                $return['code'] = 1;
                $return['msg'] = '内存资源数据获取成功';
                break;
            default:
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '无该资源数据';
                break;
        }

        return $return;
       
    }

    /**
     * 增加资源生成订单数据
     * @param  array $insert_data 部分要增加的数据
     * @return array              返回相关的订单号及状态提示及信息
     */
    public function insertResource($insert_data){
        if(!$insert_data){
            // 如果资源数据为空
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '资源无法增加！！';
            return $return;
        }
        // 订单号的生成规则：前两位（4-6的随机数）+ 年月日（如:20180830） + 时间戳的后2位数 + 1-3随机数
        $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(1,3);
        $insert_data['order_sn'] = $order_sn;
        $insert_data['order_type'] = 1;
        $insert_data['payable_money'] = bcmul((string)$insert_data['price'],(string)$insert_data['duration'],2);//计算价格
        $sales_id = Admin::user()->id;
        $$insert_data['business_id'] = $sales_id;
        $sales_name = (array)$this->staff($sales_id);
        $insert_data['business_name'] = $sales_name['fullname'];
        $insert_data['month'] = (int)date('Ym',time());
        DB::beginTransaction();//开启事务处理
        $row = DB::table('tz_orders')->insert($insert_data);
        if($row == false){
            // 资源订单生成失败
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '资源增加失败';
            return $return;
        }
        $machine['business_end'] = $insert_data['end_time'];
        switch ($insert_data['resource_type']) {
            case 4:
                //更新IP表的所属业务编号，资源状态和到期时间
                $machine['own_business'] = $insert_data['business_sn'];
                $machine['ip_status'] = 1;
                $result = DB::table('idc_ips')->where('ip',$insert_data['machine_sn'])->update($machine);
                break;
            case 5:
                //更新CPU表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['cpu_used'] = 1;
                $result = DB::table('idc_cpu')->where('cpu_number',$order['machine_sn'])->update($machine);
                break; 
            case 6:
               //更新硬盘表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['harddisk_used'] = 1;
                $result = DB::table('idc_harddisk')->where('harddisk_number',$order['machine_sn'])->update($machine);
                break; 
            case 7:
                //更新内存表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['memory_used'] = 1;
                $result = DB::table('idc_memory')->where('memory_number',$order['machine_sn'])->update($machine);
                break;    
        }
        if($result != 0){
            //所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
            DB::commit();
            $return['data'] = $order_sn;
            $return['code'] = 1;
            $return['msg'] = '资源增加成功，请提醒客户及时支付，订单号:'.$order_sn;
        } else {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '资源增加失败';
        }  
        return $return;     
    }

    /**
     * 给客户创建业务时查找对应业务员的真实姓名
     * @param  int $admin_id 账户的id用于关联账户信息admin_users_id
     * @return string           返回对应账户的真实姓名
     */
    public function staff($admin_id) {
        $staff = DB::table('oa_staff')->where('admin_users_id',$admin_id)
                    ->select('work_number','fullname')->first();
        return $staff;
    }

    /**
     * 比较资源到期时间和业务到期时间
     * @param  array $time 资源时长和业务到期时间
     * @return array       资源到期时间和状态提示及信息
     */
    public function endTime($time){
        if($time){
            $end_time = Carbon::parse('+'.$time['duration'].' months')->toDateTimeString();
            if($end_time < $time['endding_time']){
                $return['data'] = $end_time;
                $return['code'] = 1;
                $return['msg'] = '资源到期时间在业务到期时间内';
            } else {
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '资源到期时间超业务到期时间';
            }
        } else {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法比较资源到期时间和业务到期时间';
        }
        return $return;
    }

    /**
     * 客户续费主机及机柜产生订单
     * @param  array $renew 续费订单所需要的数据
     * @return array        返回操作后的状态提示及信息
     */
    public function renewOrders($renew){
        if(!$renew){
            $return['code'] = 0;
            $return['msg'] = '无法进行续费';
            return $return;
        }
        //根据业务号查询需要审核的业务数据
        $renew_where = ['business_number'=>$renew['business_number']];
        $renew_data = DB::table('tz_business')->where($check_where)->select('business_type','client_id', 'business_number','client_name','business_type','machine_number','endding_time')->first();
        if(empty($renew_data)) {
            $return['code'] = 0;
            $return['msg'] = '无对应业务数据,续费操作无法进行';
            return $return;
        } 
        //续费订单号的生成规则：前两位（4-6的随机数）+ 年月日 + 时间戳的后2位数 + 2（续费） 
        $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
        $order['order_sn'] = $order_sn;
        $order['business_sn'] = $renew_data->business_number;//续费的业务编号
        $order['customer_id'] = $renew_data->client_id;//客户id
        $order['customer_name'] = $renew_data->client_name;//客户
        $sales_id = Admin::user()->id;
        $order['business_id'] = $sales_id;//业务员id
        $sales_name = (array)$this->staff($sales_id);
        $order['business_name'] = $sales_name['fullname'];//业务员
        $order['resource_type'] = $renew_data->business_type;//资源类型
        $order['order_type'] = 2;//订单类型
        $order['machine_sn'] = $renew_data->machine_number;//机器编号
        $order['resource'] = $renew_data->machine_number;;//机器机柜等存储编号，其他资源存储对应数据
        $order['price'] = $renew['money'];//续费单价
        $order['duration'] = $renew['length'];//续费时长
        $order['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
        $order['order_status'] = 0;//续费订单状态
        $order['order_note'] = $renew['order_note'];//续费备注
        $endding_time = Carbon::parse($renew_data->endding_time)->modify('+'.$order['duration'].' months')->toDateTimeString();//在原到期时间基础上增加续费时长
        $order['end_time'] = $endding_time;
        $order['month'] = (int)date('Ym',time());
        DB::beginTransaction();//开启事务处理
        $order_row = DB::table('tz_orders')->insert($order);//生成续费订单
        if($order_row == 0) {
            DB::rollBack();
            $return['code'] = 0;
            $return['msg'] = '续费失败，请重新操作';
            return $return;
        } 
        //续费订单生成成功，继续对业务的到期时间和累计时长修改
        $business['length'] = (int)bcadd($end['length'],$renew['length'],0);
        $business['endding_time'] = $endding_time;
        $business['business_status'] = 3;
        $business_row = DB::table('tz_business')->where($renew_where)->update($business);
        if($business_row == 0){
            DB::rollBack();
            $return['code'] = 0;
            $return['msg'] = '续费失败，请重新操作';
            return $return;
        }
                                
        if($order['resource_type'] == 1 || $order['resource_type'] == 2){
            // 如果是租用/托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $machine['own_business'] = $order['business_sn'];
            $machine['business_end'] = $order['end_time'];
            $machine['used_status'] = 1;
            $row = DB::table('idc_machine')->where('machine_num',$order['machine_sn'])->update($machine);
        } else {
            // 如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
            $machine['own_business'] = $order['business_sn'];
            $machine['business_end'] = $order['end_time'];
            $machine['use_state'] = 1;
            $row = DB::table('idc_cabinet')->where('cabinet_id',$order['machine_sn'])->update($machine);
        }

        if($row != 0){
            // 订单生成成功且对应资源的业务编号及状态修改成功，事务进行提交处理
            DB::commit();
            $return['code'] = 1;
            $return['msg'] = '续费订单创建成功,为了不影响使用请及时支付,您的续费单号:'.$order_sn;
        } else {
            DB::rollBack();
            $return['code'] = 0;
            $return['msg'] = '续费失败，请重新操作';
        }
        return $return;
    }


    /**
     * 资源续费订单的创建
     * @param  array $renew 需要续费的资源数据
     * @return array        返回相关的数据信息状态及提示
     */
    public function renewResource($renew){
        if(!$renew){
            $return['code'] = 0;
            $return['msg'] = '无法对资源进行续费';
            return $return;
        }
        //续费订单号的生成规则：前两位（11-40的随机数）+ 年月日 + 时间戳的后5位数 + 2（续费）
        $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
        $renew['order_sn'] = $order_sn;
        $renew['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
        $renew['order_type'] = 2;
        $sales_id = Admin::user()->id;
        $renew['business_id']=$sales_id;
        $sales_name = (array)$this->staff($sales_id);
        $renew['business_name']=$sales_name['fullname'];
        $renew['month'] = (int)date('Ym',time());
        DB::beginTransaction();
        $insert = DB::table('tz_orders')->insert($renew);//生成续费订单

        if($insert == 0){
            //续费订单生成失败
            DB::rollBack();
            $return['code'] = 0;
            $return['msg'] = '资源续费失败，请重新操作';
        }
        $machine['business_end'] = $renew['end_time'];
        switch ($renew['resource_type']) {
            case 4:
                //更新IP表的所属业务编号，资源状态和到期时间
                $machine['own_business'] = $renew['business_sn'];
                $machine['ip_status'] = 1;
                $result = DB::table('idc_ips')->where('ip',$renew['machine_sn'])->update($machine);
                break;
            case 5:
                //更新CPU表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $renew['business_sn'];
                $machine['cpu_used'] = 1;
                $result = DB::table('idc_cpu')->where('cpu_number',$renew['machine_sn'])->update($machine);
                break;
            case 6:
                //更新硬盘表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $renew['business_sn'];
                $machine['harddisk_used'] = 1;
                $result = DB::table('idc_harddisk')->where('harddisk_number',$renew['machine_sn'])->update($machine);
                break;
            case 7:
                //更新内存表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['memory_used'] = 1;
                $result = DB::table('idc_memory')->where('memory_number',$renew['machine_sn'])->update($machine);
                break;   
        }
        
        if($result != 0){
            //所对应资源表的业务编号和到期时间，状态修改成功后进行事务提交
            DB::commit();
            $return['data'] = $order_sn;
            $return['code'] = 1;
            $return['msg'] = '资源续费订单创建成功,为了不影响使用请及时支付,您的续费单号:'.$order_sn;
        } else {
            DB::rollBack();
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '资源续费失败';
        }
            
       
          
        
           
        return $return; 
    }

    /**
     * 查找对应业务的增加的资源
     * @param  array $where 业务编号和资源类型
     * @return array        返回相关的资源数据和状态提示及信息
     */
    public function resourceOrders($where){
        if($where){
            $resource_orders = $this->where($where)->get(['id','customer_id','customer_name','order_sn', 'business_sn','before_money','after_money','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at','payable_money']);
            if($resource_orders->isEmpty()){
                //转换状态
                $resource_type = [ '1' => '租用主机' , '2' => '托管主机' , '3' => '租用机柜' , '4' => 'IP' , '5' => 'CPU' , '6' => '硬盘' , '7' => '内存' , '8' => '带宽' , '9' => '防护' , '10' => 'cdn'];
                $order_type = [ '1' => '新购' , '2' => '续费' ];
                $pay_type = [ '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他'];
                $order_status = [ '0' => '待支付' , '1' => '已支付' , '2' => '已支付' , '3' => '订单完成' , '4' => '取消' , '5' => '申请退款' , '6' => '退款完成'];
                foreach($resource_orders as $resource_key => $resource_value){
                    $resource_orders[$resource_key]['resource_type'] = $resource_type[$resource_value['resource_type']];
                    $resource_orders[$resource_key]['order_type'] = $order_type[$resource_value['order_type']];
                    $resource_orders[$resource_key]['pay_type'] = $pay_type[$resource_value['pay_type']];
                    $resource_orders[$resource_key]['order_status'] = $order_status[$resource_value['order_status']];
                }
                $return['data'] = $resource_orders;
                $return['code'] = 1;
                $return['msg'] = '获取对应增加的资源数据成功';
            } else {
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '暂无对应增加的资源数据';
            }
        } else {
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '无法获取增加的资源数据';
        }
        return $return;
    }
}
