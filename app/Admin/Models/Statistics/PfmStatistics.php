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

	public function statistics($month)
	{	


		

		//获取查询月份订单
		$order = DB::table('tz_orders')->select('id','achievement','business_id as user_id','order_status')->where('order_status','>',0)->where('order_status','<',4)->where('month',$month)->get();

		$return['data'] = [];

		if($order->isEmpty()){
			$return['msg'] 	= '无数据';
			$return['code'] 	= 0;
			return $return;
		}
		
		$order = json_decode(json_encode($order),true);
		//生成每个有业绩的业务员的空数组
		$order_arr = [];
		foreach ($order as $k => $v) {
			if(!isset($order_arr[$v['user_id']])){
				$order_arr[$v['user_id']]['user_id']		= $v['user_id'];
				$order_arr[$v['user_id']]['total_money']		= 0;
				$order_arr[$v['user_id']]['performance']		= 0;
				$order_arr[$v['user_id']]['this_arrears']		= $this->getArrears($v['user_id'],$month);
				$order_arr[$v['user_id']]['all_arrears']		= 'test';
				$order_arr[$v['user_id']]['month']		= $month;

			}
		}
		//总计
		$order_arr['0'] = [
			'user_id'		=> 0,
			'total_money'		=> 0,
			'performance'		=> 0,
			'this_arrears'		=> 0,
			'all_arrears'		=> 'test',
			'month'			=> $month,
		];
		//开始统计
	
		foreach ($order as $k => $v) {	
			if($v['achievement'] == NULL){
				$return['data']	= $v['id'];
				$return['msg'] 	= '该id数据有误';
				$return['code'] 	= 0;
				return $return;
			}		
			$order_arr['0']['total_money']			= bcadd($order_arr['0']['total_money'],$v['achievement'],2);
			$order_arr[$v['user_id']]['total_money'] 		= bcadd($order_arr[$v['user_id']]['total_money'],$v['achievement'],2);
			$order_arr['0']['performance']			= bcadd($order_arr['0']['performance'],$v['achievement'],2);
			$order_arr[$v['user_id']]['performance'] 		= bcadd($order_arr[$v['user_id']]['performance'],$v['achievement'],2);
		}
		dd($order_arr);
		//入库统计表
		$res = $this->insert($order_arr);
		if($res){
			$return['msg'] 	= '数据统计成功';
			$return['code'] 	= 1;
		}else{
			$return['msg'] 	= '数据统计失败';
			$return['code'] 	= 0;
		}
		return $return;
	}

	//获取欠款的方法
	//	
	public function getArrears($user_id,$month)
	{
		$Y = substr($month,0,4);
		$M = substr($month,4,strlen($month));
		
		$month = $Y.'-'.$M;
	
		$month_start = strtotime($month);//指定月份月初时间戳  
		$month_end = mktime(23, 59, 59, date('m', strtotime($month))+1, 00);
		dd($month_start);
		
		//获取本月开始及结束的时间戳再换成date
		$beginThismonth=date("Y-m-d H:i:s",mktime(0,0,0,$M,1,$Y));
		// //获取本月结束的时间戳
		$endThismonth=date("Y-m-d H:i:s",mktime(23,59,59,$M,date('t'),$Y));

		

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
