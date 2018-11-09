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

	// public function statistics($month)
	// {		
	// 	//获取优惠券优惠的金额
	// 	$coupon = DB::table('tz_orders_flow as a')
	// 		->select(DB::raw('sum(a.preferential_amount) as preferential_amount, a.business_id'))
	// 		->where('a.month',$month)
	// 		->groupBy('a.business_id')
	// 		->get();	
	
	// 	//获取查询月份订单
	// 	$already = DB::table('tz_orders')
	// 		->select(DB::raw('sum(achievement) as achievement, business_id as user_id'))
	// 		->whereIn('order_status',[1,2,3,4])
	// 		->where('month',$month)
	// 		->groupBy('business_id')
	// 		->get();	
	// 	//获取未付款订单
	// 	$unpaid = DB::table('tz_orders as a')
	// 		->leftjoin('tz_business as b','a.business_sn','=','b.business_number')
	// 		->select(DB::raw('sum(a.payable_money) as arrears, a.business_id as user_id , a.month'))
	// 		->whereIn('a.order_status',[0,7])
	// 		->where('b.business_status',3)
	// 		->groupBy('a.business_id','a.month')
	// 		->get();	

		
	// 	$return['data'] = [];
	// 	if($already->isEmpty() ){
	// 		$return['msg'] 	= '获取数据失败';
	// 		$return['code'] 	= 0;
	// 		return $return;
	// 	}
	// 	$coupon = json_decode($coupon,true);
	// 	$already = json_decode($already,true);
	// 	$unpaid = json_decode($unpaid,true);
		
	// 	$order_arr = [];
	// 	$order_arr['0'] = [
	// 		'user_id'		=> 0,
	// 		'total_money'		=> 0,
	// 		'achievement'		=> 0,
	// 		'this_arrears'		=> 0,
	// 		'all_arrears'		=> 0,
	// 		'preferential_amount'	=> 0,
	// 		'month'			=> $month,
	// 	];
	// 	//开始统计
	// 	for ($i=0; $i < count($already); $i++) { 
	// 		if(!isset( $order_arr[ $already[$i]['user_id'] ] )){
	// 			$order_arr[ $already[$i]['user_id'] ] = [
	// 				'user_id'		=> $already[$i]['user_id'],
	// 				'total_money'		=> 0,
	// 				'achievement'		=> 0,
	// 				'this_arrears'		=> 0,
	// 				'all_arrears'		=> 0,
	// 				'preferential_amount'	=> 0,
	// 				'month'			=> $month,
	// 			];
	// 		}

	// 		$order_arr[ $already[$i]['user_id'] ] ['achievement'] 	= $already[$i]['achievement'];
	// 		$order_arr[ $already[$i]['user_id'] ] ['month'] 		= $month;
	// 		$order_arr[ $already[$i]['user_id'] ] ['total_money'] 	= $already[$i]['achievement'];

	// 		$order_arr['0']['achievement'] = bcadd($order_arr['0']['achievement'],$already[$i]['achievement'],2);
	// 	}

	// 	for ($j=0; $j < count($unpaid); $j++) { 
	// 		if(!isset( $order_arr[ $unpaid[$j]['user_id'] ] )){
	// 			$order_arr[ $unpaid[$j]['user_id'] ] = [
	// 				'user_id'		=> $unpaid[$j]['user_id'],
	// 				'total_money'		=> 0,
	// 				'achievement'		=> 0,
	// 				'this_arrears'		=> 0,
	// 				'all_arrears'		=> 0,
	// 				'preferential_amount'	=> 0,
	// 				'month'			=> $month,
	// 			];
	// 		}
			
	// 		if($unpaid[$j]['month'] == $month){
	// 			$order_arr[ $unpaid[$j]['user_id'] ]['this_arrears'] 	= $unpaid[$j]['arrears'];
	// 			$order_arr['0']['this_arrears']	= bcadd($order_arr['0']['this_arrears'],$unpaid[$j]['arrears'],2);
	// 		}
	// 		$order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'] 		= bcadd($order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'],$unpaid[$j]['arrears'],2);
	// 		$order_arr[ $unpaid[$j]['user_id'] ]['total_money']	= bcadd($order_arr[ $unpaid[$j]['user_id'] ]['achievement'],$order_arr[ $unpaid[$j]['user_id'] ]['this_arrears'],2);
	// 		$order_arr['0']['all_arrears'] 	= bcadd($order_arr['0']['all_arrears'],$unpaid[$j]['arrears'],2);	
	// 	}
	// 	$order_arr['0']['total_money'] 	= bcadd($order_arr['0']['this_arrears'],$order_arr['0']['achievement'],2);
	
		
	// 	for ($k=0; $k < count($coupon); $k++) { 
	// 		if(!isset( $order_arr[ $coupon[$k]['business_id'] ] )){
	// 			$order_arr[ $coupon[$k]['business_id'] ] = [
	// 				'user_id'		=> $coupon[$k]['business_id'],
	// 				'total_money'		=> 0,
	// 				'achievement'		=> 0,
	// 				'this_arrears'		=> 0,
	// 				'all_arrears'		=> 0,
	// 				'preferential_amount'	=> 0,
	// 				'month'			=> $month,
	// 			];
	// 		}
			
	// 		if($coupon[$k]['business_id'] == 0){
	// 			$order_arr[ $coupon[$k]['business_id'] ]['achievement'] = bcsub($order_arr[ $coupon[$k]['business_id'] ]['achievement'],$coupon[$k]['preferential_amount'],2);
	// 			$order_arr[ $coupon[$k]['business_id'] ]['total_money'] = bcsub($order_arr[ $coupon[$k]['business_id'] ]['total_money'],$coupon[$k]['preferential_amount'],2);	
	// 			$order_arr[ $coupon[$k]['business_id'] ]['preferential_amount']	= bcadd($order_arr[ $coupon[$k]['business_id'] ]['preferential_amount'],$coupon[$k]['preferential_amount'],2);
	// 		}else{
	// 			$order_arr[ $coupon[$k]['business_id'] ]['achievement'] = bcsub($order_arr[ $coupon[$k]['business_id'] ]['achievement'],$coupon[$k]['preferential_amount'],2);
	// 			$order_arr[ $coupon[$k]['business_id'] ]['total_money'] = bcsub($order_arr[ $coupon[$k]['business_id'] ]['total_money'],$coupon[$k]['preferential_amount'],2);	
	// 			$order_arr[ $coupon[$k]['business_id'] ]['preferential_amount']	= bcadd($order_arr[ $coupon[$k]['business_id'] ]['preferential_amount'],$coupon[$k]['preferential_amount'],2);

	// 			$order_arr[0]['achievement'] = bcsub($order_arr[0]['achievement'],$coupon[$k]['preferential_amount'],2);
	// 			$order_arr[0]['total_money'] = bcsub($order_arr[0]['total_money'],$coupon[$k]['preferential_amount'],2);
	// 			$order_arr[0]['preferential_amount']	= bcadd($order_arr[0]['preferential_amount'],$coupon[$k]['preferential_amount'],2);
	// 		}
			
	// 	}
		
	// 	$res = $this->insert($order_arr);
	// 	if($res){
	// 		$return['msg'] 	= '数据统计更新成功';
	// 		$return['code'] 	= 1;
	// 	}else{
	// 		$return['msg'] 	= '数据统计更新失败';
	// 		$return['code'] 	= 0;
	// 	}
	// 	return $return;
	// }

	//插入统计数据的方法
	//	$data[
	//		'key' => ['room_id' => ?? , 'rent_inuse' => ?? , .....]
	//	]
	// public function insert($data)
	// {
	// 	DB::beginTransaction();
	// 	foreach($data as $key => $value){

	// 		$res = $this->updateOrCreate(
	// 			[
	// 				'user_id' 	=> $value['user_id'],
	// 				'month'		=> $value['month'],
	// 			],

	// 			[
	// 				'user_id' 	=> $value['user_id'] , 
	// 				'total_money' 	=> $value['total_money'] , 
	// 				'achievement' 	=> $value['achievement'] , 
	// 				'this_arrears' 	=> $value['this_arrears'] , 
	// 				'all_arrears' 	=> $value['all_arrears'] , 
	// 				'month'		=> $value['month'],
	// 			]);
	// 		if($res == false){
	// 			DB::rollBack();			
	// 			return false;
	// 		}		
	// 	}
	// 	DB::commit();
	// 	return true;
	// }


	/**
	* 统计业绩数据
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getStatistics($begin,$end){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
	
		//获取优惠券优惠的金额
		$coupon = DB::table('tz_orders_flow as a')
			->select(DB::raw('sum(a.preferential_amount) as preferential_amount, a.business_id'))
			->where('a.pay_status',1)
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->groupBy('a.business_id')
			->get();	
		
		//获取查询月份订单
		$already = DB::table('tz_orders')
			->select(DB::raw('sum(achievement) as achievement, business_id as user_id,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->groupBy('business_id','order_type')
			->get();	
		//获取未付款订单
		$unpaid = DB::table('tz_orders as a')
			->leftjoin('tz_business as b','a.business_sn','=','b.business_number')
			->select(DB::raw('a.payable_money as arrears, a.business_id as user_id , a.created_at ,a.order_type'))
			->whereIn('a.order_status',[0,7])
			->where('b.business_status',3)
			->get();	

		if($already->isEmpty() && $coupon->isEmpty() && $unpaid->isEmpty()){
			$return['msg'] 	= '获取数据失败';
			$return['code'] 	= 0;
			return $return;
		}
		$coupon = json_decode($coupon,true);
		$already = json_decode($already,true);
		$unpaid = json_decode($unpaid,true);

		$order_arr = [];
		$order_arr['0'] = [
			'user_id'		=> 0,
			'user_name'		=> '无业务员,自助购买',
			'total_money'		=> 0,
			'achievement'		=> 0,
			'new_achievement'	=> 0,
			'old_achievement'	=> 0,
			'this_arrears'		=> 0,
			'new_arrears'		=> 0,
			'old_arrears'		=> 0,
			'all_arrears'		=> 0,
			'preferential_amount'	=> 0,
		];
		$order_arr['总计'] = [
			'user_id'		=> '总计',
			'user_name'		=> '总计',
			'total_money'		=> 0,
			'achievement'		=> 0,
			'new_achievement'	=> 0,
			'old_achievement'	=> 0,
			'this_arrears'		=> 0,
			'new_arrears'		=> 0,
			'old_arrears'		=> 0,
			'all_arrears'		=> 0,
			'preferential_amount'	=> 0,
		];
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if(!isset( $order_arr[ $already[$i]['user_id'] ] )){
				$order_arr[ $already[$i]['user_id'] ] = [
					'user_id'		=> $already[$i]['user_id'],
					'user_name'		=> DB::table('admin_users')->where('id',$already[$i]['user_id'])->value('name'),
					'total_money'		=> 0,
					'achievement'		=> 0,
					'new_achievement'	=> 0,
					'old_achievement'	=> 0,
					'this_arrears'		=> 0,
					'new_arrears'		=> 0,
					'old_arrears'		=> 0,
					'all_arrears'		=> 0,
					'preferential_amount'	=> 0,
				];
			}

			if($already[$i]['order_type'] == 1){
				$order_arr[ $already[$i]['user_id'] ] ['new_achievement'] = $already[$i]['achievement'];	
			}else{
				$order_arr[ $already[$i]['user_id'] ] ['old_achievement'] = $already[$i]['achievement'];
			}
		}
		//dd($unpaid);
		for ($j=0; $j < count($unpaid); $j++) { 
			if(!isset( $order_arr[ $unpaid[$j]['user_id'] ] )){
				$order_arr[ $unpaid[$j]['user_id'] ] = [
					'user_id'		=> $unpaid[$j]['user_id'],
					'user_name'		=> DB::table('admin_users')->where('id',$unpaid[$j]['user_id'])->value('name'),
					'total_money'		=> 0,
					'achievement'		=> 0,
					'new_achievement'	=> 0,
					'old_achievement'	=> 0,
					'this_arrears'		=> 0,
					'new_arrears'		=> 0,
					'old_arrears'		=> 0,
					'all_arrears'		=> 0,
					'preferential_amount'	=> 0,
				];
			}
	
			if($unpaid[$j]['created_at'] > $begin && $unpaid[$j]['created_at'] < $end){				
				if($unpaid[$j]['order_type'] == 1){
					$order_arr[ $unpaid[$j]['user_id'] ] ['new_arrears'] = bcadd($order_arr[ $unpaid[$j]['user_id'] ] ['new_arrears'],$unpaid[$j]['arrears'],2);
				}else{
					$order_arr[ $unpaid[$j]['user_id'] ] ['old_arrears'] = bcadd($order_arr[ $unpaid[$j]['user_id'] ] ['old_arrears'],$unpaid[$j]['arrears'],2);
				}
			}
			$order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'] 	= bcadd($order_arr[ $unpaid[$j]['user_id'] ]['all_arrears'],$unpaid[$j]['arrears'],2);		
		}

		for ($k=0; $k < count($coupon); $k++) { 
			if(!isset( $order_arr[ $coupon[$k]['business_id'] ] )){
				$order_arr[ $coupon[$k]['business_id'] ] = [
					'user_id'		=> $coupon[$k]['business_id'],
					'user_name'		=> DB::table('admin_users')->where('id',$coupon[$k]['business_id'])->value('name'),
					'total_money'		=> 0,
					'achievement'		=> 0,
					'new_achievement'	=> 0,
					'old_achievement'	=> 0,
					'this_arrears'		=> 0,
					'new_arrears'		=> 0,
					'old_arrears'		=> 0,
					'all_arrears'		=> 0,
					'preferential_amount'	=> 0,
				];
			}

			$order_arr[ $coupon[$k]['business_id'] ]['preferential_amount']	= bcadd($order_arr[ $coupon[$k]['business_id'] ]['preferential_amount'],$coupon[$k]['preferential_amount'],2);	
		}
		
		$orr = [];
		
		foreach ($order_arr as $k => $v) {
			if($k != '总计'){
				$v['achievement'] 	= bcsub(bcadd($v['new_achievement'],$v['old_achievement'],2),$v['preferential_amount'],2);
				$v['this_arrears']	= bcadd($v['new_arrears'],$v['old_arrears'],2);
				$v['total_money']	= bcadd($v['achievement'],$v['this_arrears'],2);
				$order_arr['总计']['achievement'] = bcadd($order_arr['总计']['achievement'],$v['achievement'] ,2);
				$order_arr['总计']['new_achievement'] = bcadd($order_arr['总计']['new_achievement'],$v['new_achievement'] ,2);
				$order_arr['总计']['old_achievement'] = bcadd($order_arr['总计']['old_achievement'],$v['old_achievement'] ,2);
				$order_arr['总计']['this_arrears'] = bcadd($order_arr['总计']['this_arrears'],$v['this_arrears'] ,2);
				$order_arr['总计']['new_arrears'] = bcadd($order_arr['总计']['new_arrears'],$v['new_arrears'] ,2);
				$order_arr['总计']['old_arrears'] = bcadd($order_arr['总计']['old_arrears'],$v['old_arrears'] ,2);
				$order_arr['总计']['all_arrears'] = bcadd($order_arr['总计']['all_arrears'],$v['all_arrears'] ,2);
				$order_arr['总计']['preferential_amount'] = bcadd($order_arr['总计']['preferential_amount'],$v['preferential_amount'] ,2);
				$order_arr['总计']['total_money'] = bcadd($order_arr['总计']['total_money'],$v['total_money'] ,2);
				$orr[] = $v;
			}	
		}
		$orr[] = $order_arr['总计'];

		$return['data'] 	= $orr;
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}

	/**
	* 
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getStatisticsSmall($begin,$end,$user_id){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		$orr = [];
		//获取优惠券优惠的金额
		$coupon = DB::table('tz_orders_flow as a')
			->select(DB::raw('sum(a.preferential_amount) as preferential_amount'))
			->where('a.pay_status',1)
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->where('a.business_id',$user_id)
			->first();
		
		$already = DB::table('tz_orders')
			->select(DB::raw('sum(achievement) as achievement,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->where('business_id',$user_id)
			->groupBy('order_type')
			->get();	
		
		//获取未付款订单
		$unpaid = DB::table('tz_orders as a')
			->leftjoin('tz_business as b','a.business_sn','=','b.business_number')
			->select(DB::raw('a.payable_money as arrears, a.created_at ,a.order_type'))
			->whereIn('a.order_status',[0,7])
			->where('b.business_status',3)
			->where('a.business_id',$user_id)
			->get();	
	
		if($already->isEmpty() && $coupon->isEmpty() && $unpaid->isEmpty()){
			$return['msg'] 	= '获取数据失败';
			$return['code'] 	= 0;
			return $return;
		}
		$coupon = json_decode(json_encode($coupon),true);
		$already = json_decode($already,true);
		$unpaid = json_decode($unpaid,true);

		$orr = [
			'user_id'		=> $user_id,
			'user_name'		=> DB::table('admin_users')->where('id',$user_id)->value('name'),
			'total_money'		=> 0,
			'achievement'		=> 0,
			'new_achievement'	=> 0,
			'old_achievement'	=> 0,
			'this_arrears'		=> 0,
			'new_arrears'		=> 0,
			'old_arrears'		=> 0,
			'all_arrears'		=> 0,
			'preferential_amount'	=> 0,
		];
		
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if($already[$i]['order_type'] == 1){
				$orr['new_achievement'] = $already[$i]['achievement'];
			}else{
				$orr['old_achievement'] = $already[$i]['achievement'];
			}
		}
		
		//dd($unpaid);
		for ($j=0; $j < count($unpaid); $j++) { 
			if($unpaid[$j]['created_at']>$begin && $unpaid[$j]['created_at']<$end){
				if($unpaid[$j]['order_type'] == 1){
					$orr['new_arrears'] = bcadd($orr['new_arrears'],$unpaid[$j]['arrears'],2);
				}else{
					$orr['old_arrears'] = bcadd($orr['old_arrears'],$unpaid[$j]['arrears'],2);
				}
			}
			$orr['all_arrears'] = bcadd($orr['all_arrears'],$unpaid[$j]['arrears'],2);
		}

		
		$orr['preferential_amount'] 	= $coupon['preferential_amount'];
		$orr['achievement']		= bcsub(bcadd($orr['new_achievement'],$orr['old_achievement'],2),$orr['preferential_amount'],2);
		$orr['this_arrears']		= bcadd($orr['new_arrears'],$orr['old_arrears'],2);
		$orr['total_money']		= bcadd($orr['achievement'],$orr['this_arrears'],2);
		
		$return['data'] 	= $orr;
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}
	
}
