<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥
// +----------------------------------------------------------------------
// | Description: 支付宝支付模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Pay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class AliRecharge extends Model
{

	use SoftDeletes;

	protected $table = 'tz_recharge_flow'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','created_at','trade_status','deleted_at','month'];

	//生成订单接口

	public function makeOrder($data)
	{
		
		$test = $this->where("user_id",$data['user_id'])->where('trade_status',0)->max('created_at');
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
		
		$row = $this->create($data);

		if($row != false){
			// 插入订单成功
			$return['data'] = $row->id;
			$return['code'] = 1;
			$return['msg'] = '订单录入成功!!';
		} else {
		// 插入数据失败
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '订单录入失败!!';
		}
		
		return $return;
	}

	/**
	* 支付宝跳回页面处理方法,支付成功才能进这里
	*$data['trade_no'] 			= 本地订单;	
		$info['voucher']			= 凭证,平台里的订单号;
		$info['recharge_amount']	= 充值金额;
		$info['timestamp']		= 充值时间;
		$info['recharge_way']		= 1-支付宝 ,2-微信 , 3-手动;
	* @return 将数据及相关的信息返回到控制器
	*/
	public function returnInsert($data)
	{
		//获取订单
		$order = $this->where('trade_no',$data['trade_no'])->first();

		$return['data'] = '';
		if($order == NULL){
			$return['code'] = 0;
			$return['msg'] = '无此单号!!请联系客服!!';
			return $return;
		}
		//如果已经付过款了
		if($order['trade_status'] == 1){
			//如果不是同一个支付方式的,就证明用别的支付方式支付过了
			if($order['recharge_way'] != $data['recharge_way']){
				$return['code'] = 2;
				$return['msg'] = '该订单已由其他支付方式付款完成!!';
			}else{	//是同一个支付方式的话,返回订单已完成
				$return['code'] = 1;
				$return['msg'] = '该订单已完成!!';	
			}	
			return $return;
		}
		//验证充值金额
		if($order['recharge_amount'] != $data['recharge_amount']){
			$return['code'] = 2;
			$return['msg'] = '支付金额与数据库不匹配';
			return $return;
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
		$data['money_after']	= bcadd($data['money_before'] , $data['recharge_amount'],2);
		$data['trade_status']	= 1;
		$data['month']		= date("Ym");
	
		// 存在数据就用model进行数据写入操作 , 改订单状态和充值信息
		DB::beginTransaction();
		$row = $this->where('trade_no',$data['trade_no'])->update($data);

		if($row != false){
			// 插入订单成功 , 更新用户余额
			$res = DB::table('tz_users')->where('id',$user_id)->update(['money' => $data['money_after']]); 
			if($res == false){
				//失败就回滚
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '订单录入成功!!充值失败!!';
			}else{
				DB::commit();
				$return['data'] = $row;
				$return['code'] = 1;
				$return['msg'] = '订单录入成功!!充值成功';
			}		
		} else {
		// 插入数据失败
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '订单录入失败!!';
		}
	
		return $return;
	}

	/**
	* 获取充值单情况的接口
	*@param 	$trade_no 	充值订单号
			$num		需求,1代表所有信息,2代表订单的支付状况,3代表用id获取所有信息,4根据user_id获取该用户的所有订单
	* @return 订单的支付情况,
	*/
	public function checkOrder($trade_no,$num){
		switch ($num) {
			case 1:
				$order = $this->where('trade_no',$trade_no)->first();
				break;		
			case 2:
				$order = $this->select('trade_status','recharge_amount','recharge_way','id')->where('trade_no',$trade_no)->first();
				break;
			case 3:
				$order = $this->where('id',$trade_no)->first();
				break;
			case 4:
				$order = $this
				->where('user_id',$trade_no)
				->orderBy('created_at','desc')
				->get();
				break;
		}
	
		if(!empty($order)){	
			
			$return['data'] 	= $order;
			$return['code'] 	= 1;
			$return['msg']	= '获取订单信息成功';
		}else{
			$return['data'] 	= '';
			$return['code'] 	= 0;
			$return['msg']	= '获取订单信息失败';
		}

		return $return;
	}
	//充值前,获取需要支付的订单的信息,并验证
	public function makePay($trade_id,$user_id){
	
		$order = $this->select('trade_no','recharge_amount','created_at','user_id','trade_status')->find($trade_id);
		
		if($order!=NULL){	
			$return['data'] 	= $order;
			$return['code'] 	= 1;
			$return['msg']	= '获取订单信息成功';

			if($order->trade_status == 1){
				$return['data'] 	= '';
				$return['code'] 	= 4;
				$return['msg']	= '订单已支付成功';
				return $return;
			}else{
				$created_at = strtotime($order->created_at);
				if(time()-$created_at >=7130 ){
					$return['data'] 	= $order;
					$return['code'] 	= 2;
					$return['msg']	= '订单已过期';
					return $return;
				}
				$id = $order->user_id;
				if($user_id != $id){
					$return['data'] 	= '';
					$return['code'] 	= 3;
					$return['msg']	= '订单用户与登录用户不一致';
					return $return;
				}	
			}	
		}else{
			$return['data'] 	= '';
			$return['code'] 	= 0;
			$return['msg']	= '订单不存在或已过期';
		}
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

	public function delOrder($trade_id)
	{
		$res = $this->where('id',$trade_id)->delete();
		return $res;
	}
}