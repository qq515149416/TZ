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
	
	protected $fillable = ['user_id', 'achievement','total_money','this_arrears','all_arrears','month','updated_at'];

	/**
	* 统计业绩的方法
	* @return 将数据及相关的信息返回到控制器
	*/

	public function statistics($month)
	{		
		//获取查询月份订单
		$already = DB::table('tz_orders')
			->select(DB::raw('sum(achievement) as achievement, business_id as user_id'))
			->whereIn('order_status',[1,4])
			->where('month',$month)
			->groupBy('business_id')
			->get();	

		$unpaid = DB::table('tz_orders')
			->select(DB::raw('sum(payable_money) as arrears, business_id as user_id , month'))
			->whereIn('order_status',[0,7])
			->groupBy('business_id','month')
			->get();	
		
		$return['data'] = [];
		if($already->isEmpty() && $this_month_unpaid->isEmpty() &&$all_unpaid->isEmpty() ){
			$return['msg'] 	= '无数据';
			$return['code'] 	= 0;
			return $return;
		}
		$already = json_decode($already,true);
		$unpaid = json_decode($unpaid,true);
		
		$order_arr = [];
		$order_arr['0'] = [
			'user_id'		=> 0,
			'total_money'		=> 0,
			'achievement'		=> 0,
			'this_arrears'		=> 0,
			'all_arrears'		=> 0,
			'month'			=> $month,
		];
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if(!isset( $order_arr[ $already[$i]['user_id'] ] )){
				$order_arr[ $already[$i]['user_id'] ] = [
					'user_id'		=> $already[$i]['user_id'],
					'total_money'		=> 0,
					'achievement'		=> 0,
					'this_arrears'		=> 0,
					'all_arrears'		=> 0,
					'month'			=> $month,
				];
			}

			$order_arr[ $already[$i]['user_id'] ] ['achievement'] 	= $already[$i]['achievement'];
			$order_arr[ $already[$i]['user_id'] ] ['month'] 		= $month;
			$order_arr[ $already[$i]['user_id'] ] ['total_money'] 	= $already[$i]['achievement'];

			$order_arr['0']['achievement'] = bcadd($order_arr['0']['achievement'],$already[$i]['achievement'],2);
		}

		for ($j=0; $j < count($unpaid); $j++) { 
			if(!isset( $order_arr[ $unpaid[$j]['user_id'] ] )){
				$order_arr[ $unpaid[$j]['user_id'] ] = [
					'user_id'		=> $unpaid[$j]['user_id'],
					'total_money'		=> 0,
					'achievement'		=> 0,
					'this_arrears'		=> 0,
					'all_arrears'		=> 0,
					'month'			=> $month,
				];
			}
			
			if($unpaid[$j]['month'] == $month){
				$order_arr[ $unpaid[$j]['user_id'] ]['this_arrears'] 	= $unpaid[$j]['arrears'];
				$order_arr['0']['this_arrears']	= bcadd($order_arr['0']['this_arrears'],$unpaid[$j]['arrears'],2);
			}
			$order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'] 		= bcadd($order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'],$unpaid[$j]['arrears'],2);
			$order_arr[ $unpaid[$j]['user_id'] ]['total_money']	= bcadd($order_arr[ $unpaid[$j]['user_id'] ]['achievement'],$order_arr[ $unpaid[$j]['user_id'] ]['this_arrears'],2);
			$order_arr['0']['all_arrears'] 	= bcadd($order_arr['0']['all_arrears'],$unpaid[$j]['arrears'],2);
		}
		
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
					'achievement' 	=> $value['achievement'] , 
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
