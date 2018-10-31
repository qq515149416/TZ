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
    //['id','order_sn','customer_name','business_sn','business_name','before_money','after_money','resource_type','order_type','resource','price','duration','payable_money','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']
    public function financeOrders($where){
    	$result = DB::table('tz_orders')
                    ->join('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
                    ->where($where)
                    ->select('tz_orders.id','tz_orders.order_sn','tz_orders.customer_name','tz_orders.business_sn','tz_orders.business_name','tz_orders.resource_type','tz_orders.order_type','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.pay_type')
                    ->get();
        // dd($result);
        //$this->where($where)
    				//->get(['id','order_sn','customer_name','business_sn','business_name','resource_type','order_type','resource','price','duration','payable_money','end_time','serial_number','pay_time','order_status','order_note','created_at']);
    	// 'before_money','after_money','pay_type','pay_price',
        if(!empty($result)){
    		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
    		$order_type = [1=>'新购',2=>'续费'];
    		$pay_type = [0=>'未选择',1=>'余额',2=>'支付宝',3=>'微信',4=>'其他'];
    		$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
    		foreach($result as $okey=>$ovalue){
    			$ovalue->resource_type = $resource_type[$ovalue->resource_type];
    			$ovalue->order_type = $order_type[$ovalue->order_type];
    			$ovalue->pay_type = $pay_type[$ovalue->pay_type];
    			$ovalue->order_status = $order_status[$ovalue->order_status];
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
        $result = DB::table('tz_orders')
                    ->join('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
                    ->where($where)
                    ->select('tz_orders.id','tz_orders.order_sn','tz_orders.customer_name','tz_orders.business_sn','tz_orders.business_name','tz_orders.resource_type','tz_orders.order_type','tz_orders.resource','tz_orders.price','tz_orders.duration','tz_orders.payable_money','tz_orders.end_time','tz_orders.serial_number','tz_orders.pay_time','tz_orders.order_status','tz_orders.order_note','tz_orders.created_at','tz_orders_flow.pay_type')
                    ->get();
        //$this->where($where)->get(['id','order_sn','customer_name','business_sn','business_name','resource_type','order_type','resource','price','duration','payable_money','end_time','serial_number','pay_time','order_status','order_note','created_at']);
    	if(!$result->isEmpty()){
    		$resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn'];
    		$order_type = [1=>'新购',2=>'续费'];
    		$pay_type = [0=>'未选择',1=>'余额',2=>'支付宝',3=>'微信',4=>'其他'];
            // $pay_type = [1=>'余额',2=>'支付宝',3=>'微信',4=>'其他'];
    		$order_status = [0=>'待支付',1=>'已支付',2=>'财务确认',3=>'订单完成',4=>'到期',5=>'取消',6=>'申请退款',7=>'正在支付',8=>'退款完成'];
    		foreach($result as $okey=>$ovalue){
                $ovalue->resourcetype = $resource_type[$ovalue->resource_type];
                $ovalue->order_type = $order_type[$ovalue->order_type];
                $ovalue->pay_type = $pay_type[$ovalue->pay_type];
                $ovalue->order_status = $order_status[$ovalue->order_status];
    			// $result[$okey]['resourcetype'] = $resource_type[$ovalue['resource_type']];
    			// $result[$okey]['order_type'] = $order_type[$ovalue['order_type']];
    			// // $result[$okey]['pay_type'] = $pay_type[$ovalue['pay_type']];
    			// $result[$okey]['order_status'] = $order_status[$ovalue['order_status']];
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
                $result = $ips->selectIps($resource_data['machineroom'],$resource_data['company']);
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
        //业务到期时间和资源到期时间比较
        $end_time = Carbon::parse('+'.$insert_data['duration'].' months')->toDateTimeString();
        $endding_time = DB::table('tz_business')->where('business_number',$insert_data['business_sn'])->value('endding_time');
        if($end_time > $endding_time){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '资源到期时间超业务到期时间，无法添加资源!';
            return $return;
        }
        $insert_data['end_time'] = $end_time;
        // 订单号的生成规则：前两位（4-6的随机数）+ 年月日（如:20180830） + 时间戳的后2位数 + 1-3随机数
        $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(1,3);
        $insert_data['order_sn'] = $order_sn;
        $insert_data['order_type'] = 1;
        $insert_data['payable_money'] = bcmul((string)$insert_data['price'],(string)$insert_data['duration'],2);//计算价格
        $sales_id = Admin::user()->id;
        $insert_data['business_id'] = $sales_id;
        $insert_data['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;
        $insert_data['month'] = (int)date('Ym',time());
        $insert_data['created_at'] = Carbon::now()->toDateTimeString();
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
                $result = DB::table('idc_cpu')->where('cpu_number',$insert_data['machine_sn'])->update($machine);
                break; 
            case 6:
               //更新硬盘表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['harddisk_used'] = 1;
                $result = DB::table('idc_harddisk')->where('harddisk_number',$insert_data['machine_sn'])->update($machine);
                break; 
            case 7:
                //更新内存表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $insert_data['business_sn'];
                $machine['memory_used'] = 1;
                $result = DB::table('idc_memory')->where('memory_number',$insert_data['machine_sn'])->update($machine);
                break;
            default:
                $result = 1;
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
                    ->value('fullname');
        return $staff;
    }

    /**
     * 续费订单的创建
     * @param  array $param 需要续费的资源数据
     * @return array        返回相关的数据信息状态及提示
     */
    public function renewResource($param){
        // 判断是否传递相关参数
        if(!$param){
            $return['code'] = 0;
            $return['msg'] = '无法进行续费';
            return $return;
        }
        // 根据业务编号进行对应数据的查询
        $business_where = ['business_number'=>$param['business_number'],'client_id'=>$param['client_id']];
        $business = DB::table('tz_business')->where($business_where)->select('business_number','business_type','client_id', 'business_number','client_name','business_type','machine_number','endding_time','length','money')->first();
        // 没有对应业务编号的业务数据直接返回
        if(!$business){
            $return['code'] = 0;
            $return['msg'] = '无绑定业务,无法进行续费';
            return $return;
        }
        //续费订单号的生成规则：前两位（4-6的随机数）+ 年月日 + 时间戳的后2位数 + 4-6的随机数 
        $order_sn = mt_rand(4,6).date("Ymd",time()).substr(time(),8,2).mt_rand(4,6);//续费订单号
        $order['order_sn'] = $order_sn;
        
        if(isset($param['order_sn']) && $param['resource_type'] > 3){
            //存在订单号并且资源类型除主机和机柜外的根据订单号进行续费订单数据的查询
            $order_where = ['customer_id'=>$param['client_id'],'business_sn'=>$param['business_number'],'order_sn'=>$param['order_sn'],'resource_type'=>$param['resource_type']];
            $order_data = $this->where($order_where)->select('business_sn','customer_id','customer_name','machine_sn','resource','price','end_time')->first();
            // 查无对应订单，直接返回
            if(!$order_data){
                $return['code'] = 0;
                $return['msg'] = '无对应的资源续费订单,无法进行资源续费';
                return $return;
            }
            //在原到期时间基础上增加续费时长,生成新的到期时间
            $end_time = Carbon::parse($order_data->end_time)->modify('+'.$param['length'].' months')->toDateTimeString();
            //续费到期时间超业务到期时间直接返回 
            if($end_time > $business->endding_time){
                $return['data'] = '';
                $return['code'] = 0;
                $return['msg'] = '资源到期时间超业务到期时间，无法续费资源!';
                return $return;
            }
            $order['business_sn'] = $order_data->business_sn;//业务编号
            $order['customer_id'] = $order_data->customer_id;//客户id
            $order['customer_name'] = $order_data->customer_name;//客户姓名
            $order['machine_sn'] = $order_data->machine_sn;//机器或资源编号
            $order['resource'] = $order_data->resource;//资源
            $order['price'] = $order_data->price;//单价

        } else {
            //资源类型为主机和机柜的直接进行新订单数据的生成
            $order['business_sn'] = $business->business_number;//业务编号
            $order['customer_id'] = $business->client_id;//客户id
            $order['customer_name'] = $business->client_name;//客户姓名
            $order['machine_sn'] = $business->machine_number;//机器或资源编号
            $order['resource'] = $business->machine_number;//资源
            $order['price'] = $business->money;//单价
            //在原到期时间基础上增加续费时长,生成新的到期时间
            $end_time = Carbon::parse($business->endding_time)->modify('+'.$param['length'].' months')->toDateTimeString();     
        }
        // 续费订单数据的组成
        $order['duration'] = $param['length'];//时长
        $order['payable_money'] = bcmul((string)$order['price'],(string)$order['duration'],2);//应付金额
        $sales_id = Admin::user()->id;
        $order['business_id'] = $sales_id;//业务员id
        $order['business_name'] = Admin::user()->name?Admin::user()->name:Admin::user()->username;//业务员姓名
        $order['resource_type'] = $param['resource_type'];//资源类型
        $order['order_type'] = 2;//订单类型续费
        $order['end_time'] = $end_time;//订单到期时间
        $order['order_status'] = 0;//订单状态未支付
        $order['month'] = (int)date('Ym',time());//下单日期月份
        $order['created_at'] = Carbon::now()->toDateTimeString();//订单创建时间
        $order['order_note'] = $param['order_note'];//订单备注
        DB::beginTransaction();//开启事务处理
        $order_row = DB::table('tz_orders')->insert($order);//生成续费订单
        //续费订单生成失败直接返回
        if($order_row == 0) {
            DB::rollBack();
            $return['code'] = 0;
            $return['msg'] = '续费失败，请重新操作';
            return $return;
        }
        //资源类型为主机和机柜的对原业务的到期时间和累计时长进行更新
        if($param['resource_type'] == 1 || $param['resource_type'] == 2 || $param['resource_type'] == 3) {
            $business_alert['length'] = (int)bcadd($business->length,$param['length'],0);
            $business_alert['endding_time'] = $end_time;
            $business_alert['business_status'] = 3;
            $alert_where = ['business_number'=>$business->business_number];
            $business_row = DB::table('tz_business')->where($alert_where)->update($business_alert);
            //更新失败，直接返回
            if($business_row == 0){
                DB::rollBack();
                $return['code'] = 0;
                $return['msg'] = '续费失败，请重新操作';
                return $return;
            }
        }
        $machine['business_end'] = $order['end_time'];
        switch ($param['resource_type']) {
            case 1:
                //如果是租用机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
                $machine['own_business'] = $order['business_sn'];
                $machine['used_status'] = 1;
                $where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
                $result = DB::table('idc_machine')->where($where)->update($machine);
                break;
            case 2:
                //如果是托管机器的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
                $machine['own_business'] = $order['business_sn'];
                $machine['used_status'] = 1;
                $where = ['own_business'=>$order['business_sn'],'machine_num'=>$order['machine_sn']];
                $result = DB::table('idc_machine')->where($where)->update($machine);
                break;
            case 3:
                //如果是租用机柜的，在订单生成成功时，将业务编号和到期时间及资源状态进行更新
                $cabinet = DB::table('idc_cabinet')->where(['cabinet_id'=>$order['machine_sn']])->value('own_business');
                $business = strpos($cabinet,$order['business_sn']);
                if($business != false){
                    $machine['own_business'] = $business;
                } else {
                    DB::rollBack();
                    $return['data'] = '';
                    $return['code'] = 0;
                    $return['msg'] = '资源续费失败,请确认您此前购买过该机柜';
                    return $return;
                }
                
                $machine['use_state'] = 1;
                $where = ['own_business'=>$order['business_sn'],'cabinet_id'=>$order['machine_sn']];
                $row = DB::table('idc_cabinet')->where($where)->update($machine);
                break;  
            case 4:
                //更新IP表的所属业务编号，资源状态和到期时间
                $machine['own_business'] = $order['business_sn'];
                $machine['ip_status'] = 1;
                $where = ['own_business'=>$order['business_sn'],'ip'=>$order['machine_sn']];
                $result = DB::table('idc_ips')->where($where)->update($machine);
                break;
            case 5:
                //更新CPU表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $order['business_sn'];
                $machine['cpu_used'] = 1;
                $where = ['service_num'=>$order['business_sn'],'cpu_number'=>$order['machine_sn']];
                $result = DB::table('idc_cpu')->where($where)->update($machine);
                break;
            case 6:
                //更新硬盘表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $order['business_sn'];
                $machine['harddisk_used'] = 1;
                $where = ['service_num'=>$order['business_sn'],'harddisk_number'=>$order['machine_sn']];
                $result = DB::table('idc_harddisk')->where($where)->update($machine);
                break;
            case 7:
                //更新内存表的所属业务编号，资源状态和到期时间
                $machine['service_num'] = $order['business_sn'];
                $machine['memory_used'] = 1;
                $where = ['service_num'=>$order['business_sn'],'memory_number'=>$order['machine_sn']];
                $result = DB::table('idc_memory')->where($where)->update($machine);
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
     * 删除订单
     * @param  [type] $delete_id [description]
     * @return [type]            [description]
     */
    public function deleteOrders($delete_id){
        // 根据订单id查找对应的订单和关联的业务编号
        $delete_data = DB::table('tz_orders')
                        ->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
                        ->where('tz_orders.id',$delete_id['delete_id'])
                        ->select('tz_business.business_number','tz_orders.order_sn')
                        ->first();
        // 不存在需要删除的数据，直接返回
        if(!$delete_data){
            $return['code'] = 0;
            $return['msg'] = '无法删除对应数据!';
            return $return;
        }

        //删除对应业务数据
        $result = DB::table('tz_orders')->where('id',$delete_id['delete_id'])->delete();
        if($result == false){
            $return['code'] = 0;
            $return['msg'] = '删除失败!';
            return $return;
        }
        // 删除成功返回
        $return['msg'] = '删除数据成功,关联业务号为:'.$delete_data->business_number; 
        $return['code'] = 1;
        return $return;

    }
}
