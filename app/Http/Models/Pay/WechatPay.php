<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 66666
// +----------------------------------------------------------------------
// | Description: 微信支付充值模型
// +----------------------------------------------------------------------
// | @DateTime: 2019-07-24
// +----------------------------------------------------------------------

namespace App\Http\Models\Pay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class WechatPay extends Model
{

	use SoftDeletes;

	protected $table = 'tz_recharge_flow'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','created_at','trade_status','deleted_at','month'];

	//生成订单接口

	public function makeRechargeOrder($total_amount,$user_id)
	{
		$test = $this->where("user_id",$user_id)->where('trade_status',0)->max('created_at');
		$test = json_decode(json_encode($test),true);
		if($test!=NULL){
			$created_at = strtotime($test);
			$time = time();
			if($time - $created_at <= 120){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '2分钟内只能创建一张订单!!!!!';
				return $return;
			}
		}

		$data = [
			'trade_no'		=> 'tz_'.time().'_'.substr(md5($user_id.'tz'),0,4),
			'recharge_amount'	=> $total_amount,
			'user_id'			=> $user_id,
			'recharge_way'		=> 2,
			'trade_status'		=> 0,
		];

		$row = $this->create($data);

		if($row != false){
			// 插入订单成功
			return [
				'data'	=> $row->id,
				'code'	=> 1,
				'msg'	=> '订单录入成功!!',
				'trade_no'	=> $row->trade_no,
			];
		} else {
			// 插入数据失败
			return [
				'data'	=> [],
				'code'	=> 0,
				'msg'	=> '订单录入失败!!',
			];
		}
	}

	//根据充值单的信息
	public function getFlow($flow_id)
	{
		$flow = $this->find($flow_id);
		if(!$flow){
			return [
				'data'	=> [],
				'msg'	=> '订单不存在',
				'code'	=> 0,
			];
		}
		$flow = $flow->toArray();
		return [
			'data'	=> $flow,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}


	/**
	* 微信的支付成功后数据处理方法,支付成功才能进这里
	* @param $check -就是微信返回的查询结果
	* @return 将数据及相关的信息返回到控制器
	*	code 	-1 处理成功 	-2 失败
	*/
	protected function rechargePaySuccess($check)
	{
		//获取订单
		$order = $this->where('trade_no',$check['out_trade_no'])->first();

		if($order == NULL){
			return [
				'data'	=> $flow,
				'msg'	=> '无此单号!!请联系客服!!',
				'code'	=> 2,
			];
		}

		$user_id = $order['user_id'];
		$money_now 		= DB::table('tz_users')->find($user_id,['money']);
		if($money_now == null){
			return [
				'data'	=> [],
				'code'	=> 2,
				'msg'	=> '客户余额获取失败',
			];
		}
		//获取现在余额,计算充值后余额
		$data['money_before'] 	= floatval($money_now->money);
		$data['money_after']	= bcadd($data['money_before'] , $order['recharge_amount'],2);
		$data['trade_status']	= 1;
		$data['month']		= date("Ym");
		$data['voucher']		= $check['transaction_id'];
		$data['timestamp']	= date("Y-m-d H:i:s");
		// 存在数据就用model进行数据写入操作 , 改订单状态和充值信息
		DB::beginTransaction();

		$row = $order->update($data);
		if($row){
			// 插入订单成功 , 更新用户余额
			$res = DB::table('tz_users')->where('id',$user_id)->update(['money' => $data['money_after']]);
			if($res == false){
				//失败就回滚
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 2;
				$return['msg'] = '订单录入成功!!充值失败!!';
			}else{
				DB::commit();
				$return['data'] = [];
				$return['code'] = 1;
				$return['msg'] = '订单录入成功!!充值成功';
			}
		} else {
		// 插入数据失败
			$return['data'] = '';
			$return['code'] = 2;
			$return['msg'] = '订单录入失败!!';
		}

		return $return;
	}


}
