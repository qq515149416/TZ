<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;//使用该包做到期时间的计算
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
	 * 创建订单
	 * @param  array $data 订单的相关数据
	 * @return array       返回订单创建时的相关提示信息
	  */
    public function insertOrders($data){
   		if($data){
   			// 订单号的生成规则：前两位（11-40的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 1（新购）/2（续费）
   			$ordersn = mt_rand(11,40).date('Ymd',time()).substr(time(),5,5).1;
   			$data['order_sn'] = (int)$ordersn;
   			$data['order_status'] = 0;
   			$data['order_type'] = 1;
   			// 未完善
   			$row = $this->create($data);
   			if($row != false){
   				$return['data'] = $row->id;
   				$return['code'] = 1;
   				$return['msg'] = '客户订单创建成功';
   			} else {
   				$return['data'] = '';
   				$return['code'] = 0;
   				$return['msg'] = '客户订单创建失败';
   			}

   		} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '工单无法提交！！';
   		}

   		return $return;
    }
// DB::beginTransaction();
// DB::rollBack();
// DB::commit();
    /**
     * 业务员手动给客户生成业务编号，针对后付费客户群体
     * @param  array $data 要生成业务编号的订单号和时长
     * @return array       返回生成业务编号成功与否的状态和提示信息
     */
    public function generateBusiness($data){
    	if($data){
    		//业务编号的生成规则：前两位（41-70的随机数）+ 年月日（如:20180830） + 时间戳的后5位数 + 3（业务编号产生）
    		$business_sn = mt_rand(41,70).date('Ymd',time()).substr(time(),5,5).3;
    		$data['business_sn'] = (int)$business_sn;
    		//业务开始时间
    		$start_time = Carbon::now()->toDateTimeString();
    		//到期时间的计算
    		$end_time = Carbon::parse('+'.$data['duration'].' months')->toDateTimeString();
    		$data['end_time'] = $end_time;
    		//开启事务处理
    		DB::beginTransaction();
    		$row = DB::table('tz_orders')
          				->where('order_sn', $data['order_sn'])
          				->update($data);
          	if($row != 0) {
          		$business = [];
          		$business['client_id'] = $data['customer_id'];
          		$business['client_name'] = $data['customer_name'];
          		$business['sales_id'] = $data['business_id'];
          		$business['sales_name'] = $data['business_name'];
          		$business['money'] = $data['price'];
          		$business['length'] = $data['duration'];
          		$business['resource_detail'] = $data['resource'];
          		$business['machine_number'] = $data['machine_sn']; 
          		$business['business_number'] = $business_sn;
          		$business['start_time'] = $start_time;
          		$business['end_time'] = $end_time;
          		$business['business_status'] = 0;
          		$business['created_at'] = date('Y-m-d H:i:s',time());
          		$row = DB::table('tz_business')->insertGetId($business);
          		if($rwo != 0){
          			DB::commit();
          			$return['data'] = $row;
					$return['code'] = 1;
					$return['msg'] = '业务编号生成成功！！';

          		} else {
          			$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '业务编号生成失败！！';
          			DB::rollBack();
          		}
          	} else {
          		$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '业务编号生成失败！！';
				DB::rollBack();
          	}

    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法生成业务编号！！';
    	}
    	return $return;
    }

    /**
     * 财务人员查看订单
     * @param  array $where 订单的状态
     * @return array        返回相关的数据信息和提示状态及信息
     */
    public function financeOrders($where){
    	$result = $this->where($where)
    				->get(['id','order_sn','customer_name','before_money','after_money','business_name','resource_type','order_type','machine_sn','price','duration','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']);
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
     * 管理人员查看订单
     * @param  array $where 订单的状态
     * @return array        返回相关的数据信息和提示状态及信息
     */
    public function adminOrders($where){
    	$result = $this->where($where)
    				->get(['id','order_sn','business_sn','customer_id','customer_name','before_money','after_money','business_id','business_name','resource_type','order_type','machine_sn','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']);
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
     * 业务人员查看订单
     * @param  array $where 订单的状态
     * @return array        返回相关的数据信息和提示状态及信息
     */
    public function clerkOrders($where){
    	$clerk_id = Admin::user()->id;
    	$where['business_id'] = $clerk_id;
    	$result = $this->where($where)
    				->get(['id','order_sn','business_sn','customer_id','customer_name','before_money','after_money','business_id','business_name','resource_type','order_type','machine_sn','price','duration','end_time','pay_type','pay_price','serial_number','pay_time','order_status','order_note','created_at']);
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
}
