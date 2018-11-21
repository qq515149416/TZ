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
	 * @param  int $business_sn 	业务编号
	 * @param  int $coupon_id      	优惠券的id
	 * @return array          返回相关的状态提示及信息
	 */

	public function payOrderByBalance($business_sn,$coupon_id){
		$return['data'] = '';
		$user_id = Auth::id();
		$unpaidOrder = $this
				->where('order_status',0)
				->where('business_sn',$business_sn)
				->where('customer_id',$user_id)
				->get()
				->toArray();
		if(count($unpaidOrder) == 0){
			$return['msg'] 	= '无此业务未付款订单';
			$return['code']	= 0;
			return $return;
		}
		$serial_number = 'tz_'.time().'_'.$user_id;
		$payable_money = '0.00';
		$pay_time = date("Y-m-d h:i:s");
		$order_id_arr = [];

		DB::beginTransaction();//开启事务处理

		for ($i=0; $i < count($unpaidOrder); $i++) { 
			$checkCoupon = $this->checkCoupon($unpaidOrder[$i]['id'],$coupon_id);
			if($checkCoupon != true){
				$return['msg'] 	= '该优惠券不可用';
				$return['code']	= 0;
				return $return;
			}
					
			$processing = $this->paySuccess($unpaidOrder[$i]['id'],$pay_time);
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
			$updateInfo['payable_money'] = bcmul($unpaidOrder[$i]['price'],$unpaidOrder[$i]['duration'],2);
			
			//计算支付流水应付金额
			$payable_money = bcadd($payable_money,$updateInfo['payable_money'],2);

			$customer_id = $unpaidOrder[$i]['customer_id'];
			$business_id = $unpaidOrder[$i]['business_id'];

			$update = DB::table('tz_orders')->where('id',$unpaidOrder[$i]['id'])->update($updateInfo);
			if($update == 0){
				DB::rollBack();
				$return['msg'] = '更新支付状态失败';
				$return['code']	= 0;
				return $return;
			}
			$order_id_arr[] = $unpaidOrder[$i]['id'];
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
			$return['msg'] 	= '余额不足,请充值';
			$return['code']	= 0;
			return $return;
		}
		
		$flow = [
			'serial_number'		=> $serial_number,
			'order_id'		=> json_encode($order_id_arr),
			'customer_id'		=> $customer_id,
			'payable_money'	=> $payable_money,
			'actual_payment'	=> $actual_payment,
			'preferential_amount'	=> $preferential_amount,
			'coupon_id'		=> $coupon_id,
			'created_at'		=> date('Y-m-d H:i:s',time()),
			'business_id'		=> $business_id,
			'before_money'		=> $before_money,
			'after_money'		=> $after_money,
			'pay_time'		=> $pay_time,
		];
		$creatFlow = DB::table('tz_orders_flow')->insert($flow);
		if($creatFlow == false){
			DB::rollBack();
			$return['msg'] = '创建支付流水失败';
			$return['code']	= 0;
			return $return;
		}

		// 订单支付成功后对客户的余额进行修改
		$payMoney = DB::table('tz_users')->where('id',$user_id)->update(['money' => $after_money ]);
		if($payMoney == false){
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


	/**
	*支付订单改状态方法
	**/
	protected function paySuccess($order_id,$pay_time){
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
					$return['msg'] 	= '更改资源使用状态失败,订单可能为正在付款使用中状态,支付失败';
					$return['code']	= 3;
					return $return;
				}
			} 
		} elseif($row['resource_type'] == 11){
			//如果是高防IP
			if($row['order_type'] == 1){
				//如果是新购的高防IP
				$checkBusiness = DB::table('tz_defenseip_business')
					->where('business_number',$row['business_sn'])
					->first();
				if($checkBusiness != null){
					$return['msg'] 	= '业务已存在,请勿重复付款!';
					$return['code']	= 2;
					return $return;
				}

				$package = DB::table('tz_defenseip_package')
					->select(['site','protection_value','price'])
					->where('id',$row['machine_sn'])
					->first();
				if($package == null){
					$return['msg'] 	= '该套餐已下架!';
					$return['code']	= 2;
					return $return;
				}
				$sale_ip = DB::table('tz_defenseip_store')
						->select(['id','ip'])
						->where('site',$package->site)
						->where('protection_value',$package->protection_value)
						->where('status',0)
						->first();
				if($sale_ip == null){
					$return['msg'] 	= '该套餐IP库存不足!';
					$return['code']	= 2;
					return $return;
				}
				$update_ip =  DB::table('tz_defenseip_store')->where('id',$sale_ip->id)->update(['status' => 1]);
				if($update_ip == 0){
					$return['msg'] 	= '更新ip使用状态失败!';
					$return['code']	= 3;
					return $return;
				}
				$end = Carbon::now()->addMonth($row['duration'])->toDateTimeString();
		
				$business = [
					'business_number'	=> $row['business_sn'],
					'user_id'		=> $row['customer_id'],
					'package_id'		=> $row['machine_sn'],
					'ip_id'			=> $sale_ip->id,
					'price'			=> $package->price,
					'status'			=> 1,
					'end_at'			=> $end,
					'created_at'		=> date("Y-m-d H:i:s"),
				];
				$build_business = DB::table('tz_defenseip_business')->insert($business);
		
				if($build_business != true){
					$return['msg'] 	= '创建高防ip业务失败!';
					$return['code']	= 3;
					return $return;
				}
				$update_order = DB::table('tz_orders')
						->where('id',$row['id'])
						->update([
							'resource'	=> $sale_ip->ip,
							]);
				if($update_order == 0){
					$return['msg'] 	= '更新订单状态失败!';
					$return['code']	= 3;
					return $return;
				}
			}else{
				$business = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->first();
				//判断业务是否已下架
				if($business->status == 2||$business->status == 3)
				{
					$return['msg'] 	= '业务已下架,无法续费!';
					$return['code']	= 4;
					return $return;
				}

				$end = Carbon::parse($business->end_at)->addMonth($row['duration'])->toDateTimeString();
				$upEnd = DB::table('tz_defenseip_business')
						->where('business_number',$row['business_sn'])
						->update(['end_at'=>$end]);
				if($upEnd != 1){
					$return['msg'] 	= '更新业务结束时间失败!';
					$return['code']	= 3;
					return $return;
				}
			}
			$return['data'] = ['end' => $end];		
		}
		
		$return['msg'] = '更新成功!!';
		$return['code'] = 1;			
		return $return;
	}

}