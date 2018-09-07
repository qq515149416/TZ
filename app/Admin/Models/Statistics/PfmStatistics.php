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

class  PfmStatistics extends Model
{
   use SoftDeletes;
   
	protected $table = 'admin_pfm_statistics';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['user_id', 'performance','total_money','this_arrears','all_arrears','month','updated_at'];

	/**
	* 统计业绩的方法
	* @return 将数据及相关的信息返回到控制器
	*/

	public function statistics($key)
	{	
		//获取查询月份订单
		$order = $this->getOrder($key);
		$order = json_decode(json_encode($order),true);

		$return['data'] = [];

		if(count($order) == 0){
			$return['msg'] 	= '无数据';
			$return['code'] 	= 0;
			return $return;
		}

		//生成每个有业绩的业务员的空数组
		$order_arr = [];
		foreach ($order as $k => $v) {
			if(!isset($order_arr[$v['user_id']])){
				$order_arr[$v['user_id']]['user_id']		= $v['user_id'];
				$order_arr[$v['user_id']]['total_money']		= 0;
				$order_arr[$v['user_id']]['performance']		= 0;
				$order_arr[$v['user_id']]['this_arrears']		= 0;
				$order_arr[$v['user_id']]['all_arrears']		= $this->getAllArrears($v['user_id']);
				$order_arr[$v['user_id']]['month']			= $key;
			}
		}
		//总计
		$order_arr['0'] = [
			'user_id'			=> 0,
			'total_money'		=> 0,
			'performance'		=> 0,
			'this_arrears'		=> 0,
			'all_arrears'		=> $this->getAllArrears('*'),
			'month'			=> $key,
		];
		//开始统计
		foreach ($order as $k => $v) {
			if($v['order_status'] != 4||$v['order_status'] != 5||$v['order_status'] != 6){
				
				$order_arr['0']['total_money']			= bcadd($order_arr['0']['total_money'],$v['payable_money'],2);
				$order_arr[$v['user_id']]['total_money'] 		= bcadd($order_arr[$v['user_id']]['total_money'],$v['payable_money'],2);
				if($v['order_status'] == 1||$v['order_status'] == 2||$v['order_status'] == 3){
					$order_arr['0']['performance']		= bcadd($order_arr['0']['performance'],$v['payable_money'],2);
					$order_arr[$v['user_id']]['performance'] 	= bcadd($order_arr[$v['user_id']]['performance'],$v['payable_money'],2);
				}else{
					$order_arr['0']['this_arrears']		= bcadd($order_arr['0']['this_arrears'],$v['payable_money'],2);
					$order_arr[$v['user_id']]['this_arrears']	= bcadd($order_arr[$v['user_id']]['this_arrears'],$v['payable_money'],2);
				}
	
			}		
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
		$order = DB::table('tz_orders')->select('payable_money','business_id as user_id','order_status')->where('month',$month)->get();
		return $order;
	}

	/**
	* 获取业务所有欠款
	* @return 
	*/

	public function getAllArrears($user_id)
	{
		if($user_id == '*'){
			$order = DB::table('tz_orders')->where('order_status',0)->sum('payable_money');
		}else{
			$order = DB::table('tz_orders')->where('business_id',$user_id)->where('order_status',0)->sum('payable_money');
		}
		
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
					'user_id' 	=> $value['user_id'],
					'month'		=> $value['month'],
				],

				[
					'user_id' 	=> $value['user_id'] , 
					'total_money' 	=> $value['total_money'] , 
					'performance' 	=> $value['performance'] , 
					'this_arrears' 	=> $value['this_arrears'] , 
					'all_arrears' 	=> $value['all_arrears'] , 
					'month'		=> $value['month'],
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
				if($value['user_id'] == 0){
					$index[$key]['salesman'] = '本月总计';	
				}else{
					$index[$key]['salesman'] = $this->getSalesman($value['user_id']);	
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

	public function getSalesman($user_id)
	{
		$salesman = DB::table('admin_users')->select('name')->find($user_id);

		if($salesman != NULL){
			return $salesman->name;
		}else{
			return '查无此人';
		}
	}

	
  	
}
