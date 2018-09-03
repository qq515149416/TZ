<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥2.0
// +----------------------------------------------------------------------
// | Description: 用户业务表模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Business extends Model
{

	use SoftDeletes;

	protected $table = 'tz_business'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['business_number', 'machine_number','resource_detail','money','length','renew_time','start_time','end_time','business_status','business_note','created_at','client_id','client_name'];


	public function getList($user_id)
	{
		$business = $this->where('client_id',$user_id)->get();
		$business_status = [ 1 => '使用中' , 2 => '锁定中' , 3 => '到期' , 4 => '取消' , 5 => '退款'];
		
		foreach ($business as $key => $value) {
			$business[$key]['business_status'] = $business_status[$business[$key]['business_status']];
		}

		return $business;
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
	*		$num		需求,1代表所有信息,2代表订单的支付状况,3代表用id获取所有信息,4根据user_id获取该用户的所有订单
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
			$return['msg']	= '获取成功';
		}else{
			$return['data'] 	= '';
			$return['code'] 	= 0;
			$return['msg']	= '获取失败';
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
}