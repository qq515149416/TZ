<?php

// +----------------------------------------------------------------------
// | Author: kiri<420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 业绩统计表的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-06 17:02:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  RechargeStatistics extends Model
{
   use SoftDeletes;
   
	protected $table = 'admin_recharge_statistics';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['customer_id', 'recharge_amount','month','updated_at'];

	/**
	* 统计业绩的方法
	* @return 将数据及相关的信息返回到控制器
	*/

	public function statistics($month)
	{	
		//获取查询月份订单
		$order = $this->getOrder($month);
		$order = json_decode(json_encode($order),true);

		$return['data'] = [];
		$return['code'] 	= 0;

		if(count($order) == 0){
			$return['msg'] 	= '无数据';		
			return $return;
		}

		//生成每个有业绩的业务员的空数组
		$order_arr = [];
		foreach ($order as $k => $v) {
			if(!isset($order_arr[$v['user_id']])){
				$order_arr[$v['user_id']]['customer_id']		= $v['user_id'];
				$order_arr[$v['user_id']]['recharge_amount']	= 0;
				$order_arr[$v['user_id']]['month']		= $month;
			}
		}
		//总计
		$order_arr['0'] = [
			'customer_id'		=> 0,
			'recharge_amount'	=> 0,
			'month'			=> $month,
		];
		//开始统计
		foreach ($order as $k => $v) {				
			$order_arr['0']['recharge_amount']		= bcadd($order_arr['0']['recharge_amount'],$v['money'],2);
			$order_arr[$v['user_id']]['recharge_amount'] 	= bcadd($order_arr[$v['user_id']]['recharge_amount'],$v['money'],2);				
		}

		//入库统计表
		$res = $this->insert($order_arr);
		if($res){
			$return['msg'] 	= '统计成功';
			$return['code'] 	= 1;
		}else{
			$return['msg'] 	= '统计失败';
			$return['code'] 	= 0;
		}
		return $return;
	}

	/**
	* 获取订单的方法
	* @return 将数据及相关的信息返回
	*/

	public function getOrder($month)
	{
		$order = DB::table('tz_recharge_flow')->select('user_id','recharge_amount as money')->where('month',$month)->where('trade_status',1)->get();
		return $order;
	}

	
	//插入统计数据的方法
	//	$data[
	//		'key' => ['room_id' => ?? , 'rent_inuse' => ?? , .....]
	//	]
	public function insert($data)
	{

		foreach($data as $key => $value){

			$res = $this->updateOrCreate(
				[
					'customer_id' 	=> $value['customer_id'],
					'month'		=> $value['month'],
				],

				[
					'customer_id' 		=> $value['customer_id'] , 
					'recharge_amount' 	=> $value['recharge_amount'] , 
					'month'			=> $value['month'],
				]);
			if($res == false){			
				return false;
			}		
		}
		return true;
	}


	/**
	* 查询统计表的数据
	* @param  $month : 需要查询的月份
	* @return 将该月数据及相关的信息返回到控制器
	*/
	public function getStatistics($month){
		// 用模型进行数据查询
		$index = $this->where("month",$month)->get($this->fillable);

		if(!$index->isEmpty()){
		// 判断存在数据就对部分需要转换的数据进行数据转换的操作
			$index = json_decode(json_encode($index),true);
			foreach($index as $key=>$value) {
			// 对应的字段的数据转换
				if($value['customer_id'] == 0){
					$index[$key]['customer'] = '本月总计';	
				}else{
					$index[$key]['customer'] = $this->getCustomer($value['customer_id']);	
				}				
			}
			
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = $index;
			$return['code'] = 0;
			$return['msg'] = '暂无数据';
		}
		// 返回
		return $return;
	}

	public function getCustomer($customer_id)
	{
		$customer = DB::table('tz_users')->select('name')->find($customer_id);

		if($customer != NULL){
			return $customer->name;
		}else{
			return '查无此人';
		}
	}

	
  	
}
