<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥
// +----------------------------------------------------------------------
// | Description: 用户订单表模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayOrder extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders_flow'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['serial_number', 'subject','customer_id','payable_money','actual_payment','preferential_amount','pay_type','pay_status','pay_time','before_money','after_money','voucher','coupon_id'];

	
	/**
	 * 客户自主对订单进行支付
	 * @param  int $user_id 客户的id
	 * @param  int $id      订单的id
	 * @return array          返回相关的状态提示及信息
	 */
	public function payTradeByBalance($user_id,$serial_number){
		
		$row = $this->where('serial_number',$serial_number)->first();
	
		$return['data']	= '';
		$return['code']	= 0;
		// 是否存在此支付流水
		if($row == NULL){
			$return['msg'] 	= '无此支付流水号';
			$return['code']	= 0;
			return $return;
		}
		$row = json_decode(json_encode($row),true);

		// 是否是客户自己的订单
		if($user_id != $row['customer_id']){	
			$return['msg'] 	= '只能支付自己的订单';
			return $return;
		}
		// 订单的状态是否为未支付
		if( $row['pay_status'] != 0 ){
			$return['msg'] 	= '订单已支付或已取消';
			return $return;
		}

		$payable_money = $row['actual_payment'];	
		//获取余额
		$before_money = $this->getMoney($user_id)->money;
		//计算扣除应付金额后余额
		$after_money = bcsub((string)$before_money,(string)$payable_money,2);
		if( $after_money < 0 ){
			$return['msg'] 	= '余额不足,请充值';
			return $return;
		}
		$pay_time = date("Y-m-d h:i:s");
		
		//事务开始
		DB::beginTransaction();
		$updateData['before_money'] 	= $before_money;
		$updateData['after_money']	= $after_money;
		$updateData['pay_type']	= 1;
		$updateData['pay_time']	= $pay_time;
		$updateData['pay_status']	= 1;
		//对支付流水订单更新支付信息
		$updateRes = $this->where('id',$row['id'])->update($updateData);
		if(!$updateRes){
			//更新失败回滚
			DB::rollBack();
			$return['msg'] 	= '支付失败';
			$return['code']	= 2;
			return $return;
		}

		// 订单支付成功后对客户的余额进行修改
		$payMoney = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]);
		if($payMoney == false){
			// 修改客户余额失败，进行事务回滚
			DB::rollBack();
			$return['msg'] 	= '扣除余额失败,支付失败';
			$return['code']	= 2;
			return $return;	
		}
		//对交易流水涉及的几条订单更新支付相关信息
		$updateOrder = DB::table('tz_orders')->where('serial_number',$serial_number)->update(['order_status' => 1 , 'pay_time' => $pay_time]);
		if(!$updateOrder){
			DB::rollBack();
			$return['msg'] 	= '更新订单状态失败,支付失败';
			$return['code']	= 2;
			return $return;
		}

		$row = DB::table('tz_orders')->where('serial_number',$serial_number)->get();
		$row = json_decode(json_encode($row),true);
		for ($j=0 ; $j < count($row); $j++) { 
			if($row[$j]['resource_type'] < 4) {
				// 资源类型如果是机柜/主机，查找对应的业务状态	
				$business_status = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->value('business_status');
				if($business_status > 0 && $business_status < 4 && $business_status != 2){
					// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
					$business['business_status'] = 2;
					$businessUp = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->update($business);
					if($businessUp == 0) {
						DB::rollBack();
						$return['msg'] 	= '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
						$return['code']	= 3;
						return $return;
					}
				} 
			} 
		}

		DB::commit();
		// 客户余额修改成功
		$return['data'] = $row;
		$return['msg'] = '余额支付成功!!';
		$return['code'] = 1;	
		 		
		return $return;
	}


	/**
	* 查询user表的余额数据
	*@param $user_id	
	* @return 余额
	*/
	public function getMoney($user_id)
	{
		$money = DB::table('tz_users')->find($user_id,['money']);
		return $money;
	}

	/**
	* 查询业务员的名字
	*@param $admin_id	
	* @return 名字
	*/
	public function getName($admin_id)
	{
		if($admin_id == '*'){
			$name = DB::table('admin_users')->get(['id','username']);
		}else{
			$name = DB::table('admin_users')->find($admin_id,['id','username']);
		}
		
		return $name;
	}


	

	
	public function makeTrade($order_id = [],$coupon_id,$user_id){
		$return['data'] = '';
		$return['code'] = 0;
		$serial_number = 'tz_'.time().'_'.$user_id;
		$order_status = 7;

		DB::beginTransaction();//开启事务处理
		//检测优惠券是否可用
		$checkCoupon = $this->checkCoupon($order_id,$coupon_id);
		if($checkCoupon == false){
			$return['msg'] = '优惠券不可用';
			return $return;
		}

		$payable_money = '0.00';
		$subject = '';
		//转换信息,拼个商品名称用
		$arr = [
			1	=> '租用主机' ,
			2	=> '托管主机' ,
			3	=> '租用机柜' ,
			4	=> 'IP' ,
			5	=> 'CPU' ,
			6	=> '硬盘' ,
			7	=> '内存' ,
			8	=> '带宽' ,
			9	=> '防护' ,
			10	=> 'cdn' ,
		];
		$brr = [
			1 	=> '新购',
			2 	=> '续费',
		];

		for ($i=0; $i < count($order_id) ; $i++) { 

			$order = DB::table('tz_orders')->where('id',$order_id[$i])->first();

			if($order == NULL){
				DB::rollBack();
				$return['msg'] = '有订单不存在';
				return $return;
			}
			if($order->customer_id != $user_id){
				DB::rollBack();
				$return['msg'] = '有订单不属于您';
				return $return;
			}
			if($order->order_status != 0){
				DB::rollBack();
				$return['msg'] = '有订单已支付或正在支付或已取消';
				return $return;
			}
			//更新订单内信息
			$updateInfo['serial_number'] = $serial_number;
			$updateInfo['order_status'] = $order_status;

			//重新计算单一订单应付金额
			$updateInfo['payable_money'] = bcmul($order->price,$order->duration,2);

			//计算支付流水应付金额
			$payable_money = bcadd($payable_money,$updateInfo['payable_money'],2);
			//拼接商品名
			$subject.= $brr[$order->order_type].$arr[$order->resource_type].'、';
			$customer_id = $order->customer_id;

			$update = DB::table('tz_orders')->where('id',$order_id[$i])->update($updateInfo);
			if($update == 0){
				DB::rollBack();
				$return['msg'] = '更新支付状态失败';
				return $return;
			}
		}

		$subject = substr($subject, 0, -3);
		$actual_payment = $this->countCoupon($payable_money,$coupon_id);
		$preferential_amount = bcsub($payable_money,$actual_payment,2);
		$flow = [
			'serial_number'		=> $serial_number,
			'subject'		=> $subject,
			'customer_id'		=> $customer_id,
			'payable_money'	=> $payable_money,
			'actual_payment'	=> $actual_payment,
			'preferential_amount'	=> $preferential_amount,
			'pay_type'		=> 0,
			'pay_status'		=> 0,
			'coupon_id'		=> $coupon_id,
			'created_at'		=> date('Y-m-d H:i:s',time()),
		];
		$creatFlow = $this->create($flow);
		if($creatFlow == false){
			DB::rollBack();
			$return['msg'] = '创建支付订单失败';
			return $return;
		}
		DB::commit();
		$return['data'] 	= $serial_number;
		$return['msg']	= '创建支付订单成功';
		$return['code']	= 1;

		return $return;
	}
	/**
	 * 预留的检测优惠券是否可用方法
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return true/false
	 */
	public function checkCoupon($order_id = [],$coupon_id){

		return true;

	}

	/**
	 * 预留的优惠券使用计算方法
	 * @param  $payable_money		-订单应付金额; $coupon_id	-优惠券id
	 * @return true/false
	 */
	public function countCoupon($payable_money,$coupon_id){
		if($coupon_id == 0){
			$youhuizhekou = '0.00';
		}else{
			$youhuizhekou = '20.00';
		}
		
		$actual_payment = bcsub($payable_money,$youhuizhekou,2);
		if($actual_payment < 0){
			$actual_payment = 0;
		}
		return $actual_payment;

	}

	

	/**
	 * 根据登录账号获取所有支付流水号
	 * @param  $user_id
	 * @return 支付订单号
	 */
	public function showTrade($key,$way,$key2){
		$return['data'] = '';
		$return['code'] = 0;
		switch ($way) {
			case 'all':
				$list = $this		
				->where('customer_id',$key)	
				->orderBy('created_at','asc')
				->get(['id','serial_number','subject','payable_money','actual_payment','preferential_amount','pay_type','pay_status','pay_time','before_money','after_money','coupon_id','created_at']);
				break;
			
			case 'unpaid':
				$list = $this	
				->where('pay_status',0)	
				->where('customer_id',$key)	
				->orderBy('created_at','asc')
				->get(['id','serial_number','subject','payable_money','actual_payment','preferential_amount','pay_type','pay_status','pay_time','before_money','after_money','coupon_id','created_at']);
				break;

			case 'serial_number':
				$list = $this	
				->where('customer_id',$key2)
				->where('serial_number',$key)		
				->orderBy('created_at','asc')
				->get(['id','serial_number','subject','payable_money','actual_payment','preferential_amount','pay_type','pay_status','pay_time','before_money','after_money','coupon_id','created_at']);
				break;

			default:
				$list = false;
				break;
		}
		
		if($list->isEmpty()){
			$return['msg'] = '无支付订单记录';
			return $return;
		}

		$list = json_decode(json_encode($list),true);
		for ($i=0; $i < count($list); $i++) { 
			$status = [ '1' => '已支付' , '0' => '未支付' ];
			$type = [ '0' => '未选择' , '1' => '余额' , '2' => '支付宝' , '3' => '微信' , '4' => '其他' ];
			$list[$i]['pay_type'] = $type[$list[$i]['pay_type']];
			$list[$i]['pay_status'] = $status[$list[$i]['pay_status']];
			$list[$i]['order'] = DB::table('tz_orders')->where('serial_number',$list[$i]['serial_number'])->get(['resource_type','order_type','machine_sn','resource','price','duration','payable_money']);
			if($list[$i]['order']->isEmpty()){
				$return['data'] = $list[$i]['serial_number'];
				$return['msg'] = '获取此订单信息失败';
				return $return;
			}

			$list[$i]['order'] = json_decode(json_encode($list[$i]['order']),true);
			for ($j=0; $j < count($list[$i]['order']); $j++) { 
				$order_type = [ '1' => '新购' , '2' => '续费'];
				$resource_type = [
					1	=> '租用主机',
					2	=> '托管主机',
					3	=> '租用机柜',
					4	=> 'IP',
					5	=> 'CPU',
					6	=> '硬盘',
					7	=> '内存',
					8	=> '带宽',
					9	=> '防护',
					10	=> 'cdn',
				];
				$list[$i]['order'][$j]['order_type'] = $order_type[$list[$i]['order'][$j]['order_type']];
				$list[$i]['order'][$j]['resource_type'] = $resource_type[$list[$i]['order'][$j]['resource_type']];		
			}
		}
		$return['data'] 	= $list;
		$return['msg']	= '获取成功';
		$return['code']	= 1;

		return $return;
	}
	
	
	public function makePay($serial_number,$user_id){
		$row = $this->select(['id','customer_id','pay_status','actual_payment','pay_type','subject'])->where('serial_number',$serial_number)->first();

		$return['data']	= '';
		$return['code']	= 0;
		// 是否存在此支付流水
		if($row == NULL){
			$return['msg'] 	= '无此支付流水号';
			$return['code']	= 0;
			return $return;
		}

		if($user_id != $row['customer_id']){	
			$return['msg'] 	= '只能支付自己的订单';
			return $return;
		}
		// 订单的状态是否为未支付
		if( $row['pay_status'] != 0 ){
			$return['msg'] 	= '订单已支付或已取消';
			return $return;
		}
		$order = [
			'actual_payment'	=> $row['actual_payment'],
			'subject'		=> $row['subject'],
		];
		
		$return['data'] = $order;
		$return['code'] = 1;
		$return['msg'] = '获取成功!!';			 		
		return $return;
	}
	

	public function checkAliPayAndInsert($data)
	{
		//判断流水号为已付款后进入此方法
	
		//查找该流水所属的订单号
		$order = $this->where('serial_number',$data['serial_number'])->first(['id','pay_status','pay_type','actual_payment']);
		
		$return['data'] = '';
		//如果没就返回没有该订单
		if($order == NULL){
			$return['code'] = 5;
			$return['msg'] = '无此单号!!请联系客服!!';
			return $return;
		}
		//判断支付状态	
		if($order['pay_status'] == 1){		
			//如果订单状态是已支付的,就判断是否为当前支付方式支付,如果不是,就返回code2,去退款
			if($order['pay_type'] != $data['pay_type']){
				$return['code'] = 2;	//code为2时,控制器调用接口,取消订单,如已付款就会退款
				$return['msg'] = '该订单已由其他支付方式付款!!';	
			}else{
				$return['data'] = $order;
				$return['code'] = 1;
				$return['msg'] = '该订单已完成!!';
			}
			//如果是已支付状态,就不往下走了
			return $return;	
		}

		if($order['actual_payment'] != $data['total_amount']){
			$return['code'] = 2;	//code为2时,控制器调用接口,取消订单,如已付款就会退款
			$return['msg'] = '支付金额与数据库不匹配!!';	
			return $return;
		}
		
		$updateData['pay_status']	= 1;
		$updateData['pay_type']	= $data['pay_type'];
		$updateData['pay_time']	= $data['pay_time'];
		$updateData['voucher']		= $data['voucher'];
		//
		DB::beginTransaction();
		$row = $this->where('serial_number',$data['serial_number'])->update($updateData);

		if($row == false){
			DB::rollBack();
			$return['code'] = 4;
			$return['msg'] = '订单录入失败!!';
			return $return;
		} 
		//对交易流水涉及的几条订单更新支付相关信息
		$updateOrder = DB::table('tz_orders')->where('serial_number',$data['serial_number'])->update(['order_status' => 1 , 'pay_time' => $data['pay_time']]);
		if(!$updateOrder){
			DB::rollBack();
			$return['msg'] 	= '更新订单状态失败,支付失败';
			$return['code']	= 4;
			return $return;
		}

		$row = DB::table('tz_orders')->where('serial_number',$data['serial_number'])->get(['business_sn','resource_type']);
		$row = json_decode(json_encode($row),true);

		for ($j=0 ; $j < count($row); $j++) { 
			if($row[$j]['resource_type'] < 4) {
				// 资源类型如果是机柜/主机，查找对应的业务状态	
				$business_status = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->value('business_status');
				if($business_status > 0 && $business_status < 4 && $business_status != 2){
					// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
					$business['business_status'] = 2;
					$businessUp = DB::table('tz_business')->where('business_number',$row[$j]['business_sn'])->update($business);
					if($businessUp == 0) {
						DB::rollBack();
						$return['msg'] 	= '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
						$return['code']	= 4;
						return $return;
					}
				} 
			} 
		}
		DB::commit();

		$return['msg'] = '支付并录入成功!!';
		$return['code'] = 1;	
		$return['data'] = DB::table('tz_orders')->where('serial_number',$data['serial_number'])->get(['order_status','id','serial_number']);

		return $return;
	}

	public function checkPayStatus($serial_number){
		$check = $this->where('serial_number',$serial_number)->first(['id','serial_number','pay_status']);
		return $check;
	}
	
	public function delTrade($serial_number){
		$res = $this->where('serial_number',$serial_number)->delete();
		return $res;
	}
}