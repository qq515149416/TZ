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
use Carbon\Carbon;
use App\Http\Models\DefenseIp\OverlayBelongModel;
use App\Http\Models\Customer\UserCenter;
use App\Admin\Models\Idc\Ips;

class PayOrder extends Model
{

	use SoftDeletes;

	protected $table = 'tz_orders'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['order_sn', 'business_sn','customer_id','customer_name','business_id','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','achievement','end_time','serial_number','pay_time'];


	
	/**
	 * 预留的检测优惠券是否可用方法
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return true/false
	 */
	public function checkCoupon($order_id,$coupon_id){

		return true;

	}

	/**
	 * 预留的优惠券使用计算方法
	 * @param  $payable_money		-订单应付金额; $coupon_id	-优惠券id
	 * @return true/false
	 */
	public function countCoupon($payable_money,$coupon_id){
		//if($coupon_id == 0){
			$youhuizhekou = '0.00';
		// }else{
		// 	$youhuizhekou = '20.00';
		// }
	
		$actual_payment = bcsub($payable_money,$youhuizhekou,2);
		if($actual_payment < 0){
			$actual_payment = 0;
		}
		return $actual_payment;

	}

	

	
	

	/**
	 * 客户自主对业务内未付款订单进行支付
	 * @param  array 	$order_id 	业务编号
	 * @param  int 		$coupon_id      	优惠券的id
	 * @param  int 		$is_api      	不是api的不要传参或者传个0,是api的把支付的用户的id传过来用以扣费
	 * @return array          	返回相关的状态提示及信息
	 */
	
	//以下这个是新版的方法,子梁测试请打开注释,注释掉下面同名那个

	public function payOrderByBalance($order_id,$coupon_id,$is_api = 0){
		$return['data'] = '';

		//这里是为了区分来龙去脉,如果是通过api过来的,is_api就是传过来的用户id,如果不是,就取登录中用户的id
		if ($is_api != 0) {
			$user_id = $is_api;
		}else{
			$user_id = Auth::id();
		}
		//查看有没有这些订单
		
		foreach ($order_id as $k => $v) {
			
			$c_order = $this->find($v);

			if($c_order == null){		//如果没有
				return [
					'data'	=> [],
					'msg'	=> '订单不存在',
					'code'	=> 0,
				];
			}

			if ($c_order->customer_id != $user_id && $is_api != 1) {
	
				return [
					'data'	=> [],
					'msg'	=> '订单不属于您',
					'code'	=> 0, 
				];
			}
			if ($c_order->order_status != 0) {
	
				return [
					'data'	=> [],
					'msg'	=> '订单已支付',
					'code'	=> 0, 
				];
			}
			if ($c_order->remove_status != 0) {
	
				return [
					'data'	=> [],
					'msg'	=> '资源已下架,无法支付',
					'code'	=> 0, 
				];
			}	
		}

		$unpaidOrder = $this
				->where('order_status',0)
				// ->where('business_sn',$business_sn)
				->where('customer_id',$user_id)
				->where('remove_status',0) 
				->whereIn('id',$order_id)
				->get()
				->toArray();

		if(count($unpaidOrder) == 0){
			$return['msg'] 	= '订单不存在';
			$return['code']	= 0;
			return $return;
		}

		$serial_number = 'tz_'.time().'_'.substr(md5($user_id.'tz'),0,4);
		$payable_money = '0.00';
		$pay_time = date("Y-m-d H:i:s");
		$order_id_arr = [];
		$idc_arr = array(1,2,3,4,5,6,7,8,9);
		$defenseip_arr = array(11);
		$overlay_arr = array(12);
		DB::beginTransaction();//开启事务处理

		for ($i=0; $i < count($unpaidOrder); $i++) { 
			// $checkCoupon = $this->checkCoupon($unpaidOrder[$i]['id'],$coupon_id);
			// if($checkCoupon != true){
			// 	$return['msg'] 	= '该优惠券不可用';
			// 	$return['code']	= 0;
			// 	return $return;
			// }
			if ($is_api != 0) {	//如果是api传来的话
				$processing = $this->paySuccess($unpaidOrder[$i]['id'],$pay_time,$is_api);
			}else{	//如果不是api传来的话
				$processing = $this->paySuccess($unpaidOrder[$i]['id'],$pay_time);
			}
			if($processing['code'] != 1){
				DB::rollBack();
				return $processing;
			} 
		
			//更新订单内信息
			$updateInfo['serial_number'] = $serial_number;
			$updateInfo['order_status'] = 1;
			$updateInfo['pay_time'] = $pay_time;
			if(isset($processing['data']['end'])){
				$updateInfo['end_time'] = $processing['data']['end'];
			}
			//重新计算单一订单应付金额
			/*
			*如需添加单一商品优惠券,在此添加计算
			*/

			//判断订单的时长和单价乘起来跟应付对不对得上,对不上的话是按天算的
			$price_and_duration = bcmul($unpaidOrder[$i]['price'],$unpaidOrder[$i]['duration'],2);
			if ( $price_and_duration != $unpaidOrder[$i]['payable_money'] ) {
				$check_note = 1;
			}
			
			//计算支付流水应付金额
			$payable_money = bcadd($payable_money,$unpaidOrder[$i]['payable_money'],2);

			$business_id = $unpaidOrder[$i]['business_id'];
			$update = DB::table('tz_orders')->where('id',$unpaidOrder[$i]['id'])->whereNull('deleted_at')->update($updateInfo);
			if($update == 0){
				DB::rollBack();
				$return['msg'] = '更新支付状态失败';
				$return['code']	= 0;
				return $return;
			}
			$order_id_arr[] = $unpaidOrder[$i]['id'];
			$business_sn = $unpaidOrder[$i]['business_sn'];
		}
		
		//计算实际支付金额
		$actual_payment = $this->countCoupon($payable_money,$coupon_id);
		//优惠券抵扣了的金额
		$preferential_amount = bcsub($payable_money,$actual_payment,2);
		//获取余额
		$before_money = DB::table('tz_users')->where('id',$user_id)->value('money');
		//计算扣除应付金额后余额
		$after_money = bcsub((string)$before_money,(string)$actual_payment,2);

		if( $after_money < 0 ){
			$return['msg'] 	= '您的余额为 ￥'.$before_money.',订单尚需支付 ￥'.$actual_payment.',余额不足,请充值';
			$return['code']	= 0;
			return $return;
		}

		$room_id = '';
		if(in_array($unpaidOrder[0]['resource_type'],$idc_arr) ){
			$room = DB::table('tz_business')->where(['business_number'=>$unpaidOrder[0]['business_sn']])->value('resource_detail');
			$room_id = json_decode($room)->machineroom_id;
		}elseif(in_array($unpaidOrder[0]['resource_type'],$defenseip_arr)) {
			$room_id = DB::table('tz_defenseip_package')->where('id',$unpaidOrder[0]['machine_sn'])->value('site');
		}elseif (in_array($unpaidOrder[0]['resource_type'],$overlay_arr)) {
			$room_id = DB::table('tz_overlay')->where('id',$unpaidOrder[0]['machine_sn'])->value('site');
		}
		

		$flow = [
			'serial_number'		=> $serial_number,
			'order_id'		=> json_encode($order_id_arr),
			'customer_id'		=> $user_id,
			'payable_money'	=> $payable_money,
			'actual_payment'	=> $actual_payment,
			'preferential_amount'	=> $preferential_amount,
			'coupon_id'		=> $coupon_id,
			'created_at'		=> date('Y-m-d H:i:s',time()),
			'business_id'		=> $business_id,
			'before_money'		=> $before_money,
			'after_money'		=> $after_money,
			'pay_time'		=> $pay_time,
			'business_number'	=> $business_sn,
			'room_id'		=> $room_id,
			'flow_type'		=> $unpaidOrder[0]['order_type'],
		];
		if (isset($check_note) && $check_note == 1) {
			$flow['note'] = '资源到期时间跟主业务到期时间一致，不足月按实际使用天数收费';
		}
		
		$creatFlow = DB::table('tz_orders_flow')->insert($flow);
		if($creatFlow == false){
			DB::rollBack();
			$return['msg'] = '创建支付流水失败';
			$return['code']	= 0;
			return $return;
		}

		// 订单支付成功后对客户的余额进行修改
		$user_model = new UserCenter();
		$usera = $user_model->find($user_id);
		$usera->money = $after_money;
		$payMoney = $usera->save();
		//$payMoney = DB::table('tz_users')->where('id',$user_id)->save(['money' => $after_money ]);
		if(!$payMoney){
			// 修改客户余额失败，进行事务回滚
			DB::rollBack();
			$return['msg'] 	= '扣除余额失败,支付失败';
			$return['code']	= 0;
			return $return;	
		}
		DB::commit();
		$return['msg'] 	= '余额支付成功';
		$return['code']	= 1;
	 		
		return $return;
	}

	// public function payOrderByBalance($business_sn,$coupon_id){
	// 	$return['data'] = '';
	// 	$user_id = Auth::id();
	// 	$unpaidOrder = $this
	// 			->where('order_status',0)
	// 			->where('business_sn',$business_sn)
	// 			->where('customer_id',$user_id)
	// 			->get()
	// 			->toArray();
	// 	if(count($unpaidOrder) == 0){
	// 		$return['msg'] 	= '无此业务未付款订单';
	// 		$return['code']	= 0;
	// 		return $return;
	// 	}
	// 	$serial_number = 'tz_'.time().'_'.$user_id;
	// 	$payable_money = '0.00';
	// 	$pay_time = date("Y-m-d h:i:s");
	// 	$order_id_arr = [];
	// 	$idc_arr = array(1,2,3,4,5,6,7,8,9);
	// 	$defenseip_arr = array(11);
		
	// 	DB::beginTransaction();//开启事务处理

	// 	for ($i=0; $i < count($unpaidOrder); $i++) { 
	// 		$checkCoupon = $this->checkCoupon($unpaidOrder[$i]['id'],$coupon_id);
	// 		if($checkCoupon != true){
	// 			$return['msg'] 	= '该优惠券不可用';
	// 			$return['code']	= 0;
	// 			return $return;
	// 		}
					
	// 		$processing = $this->paySuccess($unpaidOrder[$i]['id'],$pay_time);
	// 		if($processing['code'] != 1){
	// 			DB::rollBack();
	// 			return $processing;
	// 		} 
			
	// 		//更新订单内信息
	// 		$updateInfo['serial_number'] = $serial_number;
	// 		$updateInfo['order_status'] = 1;
	// 		$updateInfo['pay_time'] = $pay_time;
	// 		if(isset($processing['data']['end'])){
	// 			$updateInfo['end_time'] = $processing['data']['end'];
	// 		}
	// 		//重新计算单一订单应付金额
	// 		/*
	// 		*如需添加单一商品优惠券,在此添加计算
	// 		*/
	// 		$updateInfo['payable_money'] = bcmul($unpaidOrder[$i]['price'],$unpaidOrder[$i]['duration'],2);
			
	// 		//计算支付流水应付金额
	// 		$payable_money = bcadd($payable_money,$updateInfo['payable_money'],2);

	// 		$business_id = $unpaidOrder[$i]['business_id'];
	// 		$update = DB::table('tz_orders')->where('id',$unpaidOrder[$i]['id'])->update($updateInfo);
	// 		if($update == 0){
	// 			DB::rollBack();
	// 			$return['msg'] = '更新支付状态失败';
	// 			$return['code']	= 0;
	// 			return $return;
	// 		}
	// 		$order_id_arr[] = $unpaidOrder[$i]['id'];

	// 		if(in_array($unpaidOrder[$i]['resource_type'], $idc_arr)){
	// 			$type = 1;
	// 		} elseif(in_array($unpaidOrder[$i]['resource_type'], $defenseip_arr)){
	// 			$type = 2;
	// 		}else{
	// 			$type = 3;
	// 		}
	// 	}
	// 	switch ($type) {
	// 		case '1':
	// 			$customer_id = DB::table('tz_business')->where('business_number',$business_sn)->value('client_id'); 
	// 			break;
	// 		case '2':
	// 			$customer_id = DB::table('tz_defenseip_business')->where('business_number',$business_sn)->value('user_id'); 
	// 			break;
	// 		default:
	// 			$return['msg']  = '获取业务类型失败';
	// 			$return['code'] = 0;
	// 			return $return;
	// 			break;
	// 	}
	// 	if($customer_id == null){
	// 		$return['msg']  = '客户id获取失败';
	// 		$return['code'] = 0;
	// 		return $return;
	// 	}
		
	// 	//计算实际支付金额
	// 	$actual_payment = $this->countCoupon($payable_money,$coupon_id);
	// 	//优惠券抵扣了的金额
	// 	$preferential_amount = bcsub($payable_money,$actual_payment,2);
	// 	//获取余额
	// 	$before_money = DB::table('tz_users')->where('id',$customer_id)->value('money');
	// 	//计算扣除应付金额后余额
	// 	$after_money = bcsub((string)$before_money,(string)$actual_payment,2);

	// 	if( $after_money < 0 ){
	// 		$return['msg'] 	= '您的余额为 ￥'.$before_money.',订单尚需支付 ￥'.$actual_payment.',余额不足,请充值';
	// 		$return['code']	= 0;
	// 		return $return;
	// 	}
		
	// 	$flow = [
	// 		'serial_number'		=> $serial_number,
	// 		'order_id'		=> json_encode($order_id_arr),
	// 		'customer_id'		=> $customer_id,
	// 		'payable_money'	=> $payable_money,
	// 		'actual_payment'	=> $actual_payment,
	// 		'preferential_amount'	=> $preferential_amount,
	// 		'coupon_id'		=> $coupon_id,
	// 		'created_at'		=> date('Y-m-d H:i:s',time()),
	// 		'business_id'		=> $business_id,
	// 		'before_money'		=> $before_money,
	// 		'after_money'		=> $after_money,
	// 		'pay_time'		=> $pay_time,
	// 		'business_number'	=> $business_sn,
	// 	];
	// 	$creatFlow = DB::table('tz_orders_flow')->insert($flow);
	// 	if($creatFlow == false){
	// 		DB::rollBack();
	// 		$return['msg'] = '创建支付流水失败';
	// 		$return['code']	= 0;
	// 		return $return;
	// 	}

	// 	// 订单支付成功后对客户的余额进行修改
	// 	$payMoney = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]);
	// 	if($payMoney == false && $before_money != $after_money){
	// 		// 修改客户余额失败，进行事务回滚
	// 		DB::rollBack();
	// 		$return['msg'] 	= '扣除余额失败,支付失败';
	// 		$return['code']	= 0;
	// 		return $return;	
	// 	}
	// 	DB::commit();
	// 	$return['msg'] 	= '余额支付成功';
	// 	$return['code']	= 1;
	 		
	// 	return $return;
	// }

	/**
	*支付订单改状态方法
	**/
	protected function paySuccess($order_id,$pay_time,$is_api=0){
		$return['data'] = '';
		$row = $this->find($order_id)->toArray();

		if($row['resource_type'] < 4) {
			// 资源类型如果是机柜/主机，查找对应的业务状态
			$business_status = DB::table('tz_business')->where('business_number',$row['business_sn'])->value('business_status');
			if($business_status > 0 && $business_status < 4 && $business_status != 2){
				// 业务状态是审核通过且是使用状态将状态修改为付款使用即2
				$business['business_status'] = 2;
				$businessUp = DB::table('tz_business')->where('business_number',$row['business_sn'])->update($business);
				if($businessUp == 0) {
					$return['msg']  = '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
					$return['code'] = 3;
					return $return;
				}
			}
		} elseif($row['resource_type'] == 11){
			//如果是高防IP
			if($row['order_type'] == 1){
				//如果是新购的高防IP
				$checkBusiness = DB::table('tz_defenseip_business')
					->where('business_number',$row['business_sn'])
					->whereNull('deleted_at')
					->first();
				//如果存在该业务
				if($checkBusiness != null){
					//如果该业务是试用
					if ($checkBusiness->status == 4 ) {
						$start_time = Carbon::now();
						$start = $start_time->toDateTimeString();
						$business = [
							'status'            => 1,
							'start_time'	=> $start,
							'end_at'            => $row['end_time'],
						];
						$update_business = DB::table('tz_defenseip_business')
									->where('business_number',$row['business_sn'])
									->whereNull('deleted_at')
									->update($business);

						if($update_business == 0){
							$return['msg']  = '更新业务到期时间失败!';
							$return['code'] = 3;
							return $return;
						}
					}else{
						$return['msg']  = '业务已存在,请勿重复付款!';
						$return['code'] = 2;
						return $return;
					}
				}else{
					$package = DB::table('tz_defenseip_package')
					->select(['site','protection_value','price','channel_price'])
					->where('id',$row['machine_sn'])
					->whereNull('deleted_at')
					->first();
					
					if($package == null){
						$return['msg']  = '该套餐已下架!';
						$return['code'] = 2;
						return $return;
					}
					$sale_ip = DB::table('tz_defenseip_store')
							->select(['id','ip'])
							->where('site',$package->site)
							->where('protection_value',$package->protection_value)
							->where('status',0)
							->whereNull('deleted_at')
							->first();
					if($sale_ip == null){
						$return['msg']  = '该套餐IP库存不足!';
						$return['code'] = 2;
						return $return;
					}
					$update_ip =  DB::table('tz_defenseip_store')->where('id',$sale_ip->id)->whereNull('deleted_at')->update(['status' => 1]);
					if($update_ip == 0){
						$return['msg']  = '更新ip使用状态失败!';
						$return['code'] = 3;
						return $return;
					}

					$idc_ip = Ips::where('ip',$sale_ip->ip)->first();
					if ($idc_ip == null) {
						$return['msg']  = 'ip资源库ip信息获取失败!';
						$return['code'] = 3;
						return $return;
					}
					$idc_ip->ip_note = '高防使用中!';
					$idc_ip->ip_status = 1;
					if (!$idc_ip->save()) {
						$return['msg']  = 'ip资源库ip状态更改失败!';
						$return['code'] = 3;
						return $return;
					}
					/**** 生成业务信息 ****/
					
					$start_time = Carbon::now();
					$start = $start_time->toDateTimeString();
					$end = $start_time->addMonth($row['duration'])->toDateTimeString();
					$business = [
						'business_number'   => $row['business_sn'],
						'user_id'       => $row['customer_id'],
						'package_id'        => $row['machine_sn'],
						'ip_id'         => $sale_ip->id,
						'price'         => $package->price,
						'status'            => 1,
						'created_at'        => date("Y-m-d H:i:s"),
						'start_time'	=> $start,
						'end_at'		=> $end,
					];
					if ($is_api != 0) {	//如果是api传来的按渠道价给
						$business['price'] = $package->channel_price;
					}
					/****/



					$build_business = DB::table('tz_defenseip_business')->insert($business);

					if($build_business != true){
						$return['msg']  = '创建高防ip业务失败!';
						$return['code'] = 3;
						return $return;
					}
					$relevance = [
						'type'		=> 2,
						'business_id'	=> $business['business_number'],
						'created_at'	=> $business['created_at'],
					];
					$build_relevance = DB::table('tz_business_relevance')->insert($relevance);
					if($build_relevance != true){
						$return['msg'] 	= '创建高防ip业务关联失败!';
						$return['code']	= 3;
						return $return;
					}
					$update_order = DB::table('tz_orders')
						->where('id',$row['id'])
						->whereNull('deleted_at')
						->update([
							'resource'  => $sale_ip->ip,
							]);
					if($update_order == 0){
						$return['msg']  = '更新订单状态失败!';
						$return['code'] = 3;
						return $return;
					}
					$return['data'] = ['end' => $end];
				}
			}else{
				$business = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->whereNull('deleted_at')
						->first();
				//判断业务是否已下架
				if($business->status == 2||$business->status == 3)
				{
					$return['msg']  = '业务已下架,无法续费!';
					$return['code'] = 4;
					return $return;
				}

				$end = Carbon::parse($business->end_at)->addMonth($row['duration'])->toDateTimeString();
				$upEnd = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->whereNull('deleted_at')
						->update(['end_at'=>$end]);

				if($upEnd != 1){
					$return['msg']  = '更新业务结束时间失败!';
					$return['code'] = 3;
					return $return;
				}
				$return['data'] = ['end' => $end];
			}	
		}elseif ($row['resource_type'] == 12) { //如果订单是叠加包的话
			//生成归属信息
			$belong = [
				'overlay_id'	=> $row['machine_sn'],
				'user_id'		=> $row['customer_id'],
				'price'		=> $row['price'],
				'buy_time'	=> $pay_time,
				'order_sn'	=> $row['order_sn'],
				'status'		=> 0
			];
			
			$belong_model = new OverlayBelongModel();
			//duration记录购买数量,买了多少个就生成多少个
			for ($i=0; $i < $row['duration']; $i++) { 
				if(!$belong_model->create($belong)){
					return [
						'data'	=> [],
						'msg'	=> '用户增加所属叠加包失败',
						'code'	=> 3,
					];
				}
			}
		}

		$return['msg'] = '更新成功!!';
		$return['code'] = 1;
		return $return;
	}

}