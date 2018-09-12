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
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','created_at','trade_status','deleted_at'];


	public function makeOrder($data)
	{
		if ($data) {
			$test = $this->where("user_id",$data['user_id'])->where('trade_status',0)->max('created_at');
			$test = json_decode(json_encode($test),true);
			if($test!=NULL){				
				$created_at = strtotime($test);
				$time = time();	
				if($time - $created_at <= 300){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '5分钟内只能创建一张订单!!!!!';
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
		}else{
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
		}
		return $return;
	}

	/**
	* 支付宝跳回页面处理方法
	* @return 将数据及相关的信息返回到控制器
	*/
	public function returnInsert($data)
	{
		$order = $this->select('user_id','trade_status')->where('trade_no',$data['trade_no'])->get();
		if(count($order) == 0){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无此单号!!请联系客服!!';
			return $return;
		}

		$trade_status = $order[0]['trade_status'];
		if($trade_status == 1){
			$return['data'] = '';
			$return['code'] = 1;
			$return['msg'] = '该订单已完成!!';
			return $return;
		}

		$user_id = $order[0]['user_id'];

		$data['money_before'] 	= floatval($this->getMoney($user_id)->money);
		$data['money_after']	= floatval($data['money_before'] + $data['recharge_amount']);
		$data['trade_status']	= 1;

		if($data){
			// 存在数据就用model进行数据写入操作
			DB::beginTransaction();
			$row = $this->where('trade_no',$data['trade_no'])->update($data);

			if($row != false){
				// 插入订单成功
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
		} else {
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
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
				$order = $this->where('trade_no',$trade_no)->get();
				break;		
			case 2:
				$order = $this->select('trade_status','id')->where('trade_no',$trade_no)->get();
				break;
			case 3:
				$order = $this->where('id',$trade_no)->get();
				break;
			case 4:
				$order = $this->where('user_id',$trade_no)->get();
				break;
		}
		
	
		if(count($order) != 0){		
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

	public function makePay($trade_id,$user_id){
	
		$order = $this->select('trade_no','recharge_amount','subject','created_at','user_id')->find($trade_id);
		
		if($order!=NULL){	
			$created_at = strtotime($order->created_at);
			if(time()-$created_at >=300 ){
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
			$return['data'] 	= $order;
			$return['code'] 	= 1;
			$return['msg']	= '获取订单信息成功';
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