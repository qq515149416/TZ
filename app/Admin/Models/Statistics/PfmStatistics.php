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
	* 统计业绩数据
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getIdcStatisticsBig($begin,$end){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		//获取查询时间段内的已付费idc订单
		$already = DB::table('tz_orders')
			->select(DB::raw('sum(payable_money) as payable_money, business_id as user_id,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->groupBy('business_id','order_type')
			->get()
			->toArray();	

		//获取所有idc业务欠费订单
		$unpaid = DB::table('tz_orders')
			->select(DB::raw('payable_money as arrears, business_id as user_id , created_at ,order_type'))
			->where('order_status',0)
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->get()
			->toArray();	
		// dd($unpaid);
		if(count($already) == 0 && count($unpaid) == 0 ){
			$return['msg'] 	= '获取数据失败';
			$return['code'] 	= 0;
			return $return;
		}

		$order_arr = [];
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
			if(!isset( $order_arr[ $already[$i]->user_id ] )){
				$order_arr[ $already[$i]->user_id ] = [
					'user_id'		=> $already[$i]->user_id,
					'user_name'		=> DB::table('admin_users')->where('id',$already[$i]->user_id)->value('name'),
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

			if($already[$i]->order_type == 1){
				$order_arr[ $already[$i]->user_id ] ['new_achievement'] = $already[$i]->payable_money;	
			}else{
				$order_arr[ $already[$i]->user_id ] ['old_achievement'] = $already[$i]->payable_money;
			}
		}
		
		for ($j=0; $j < count($unpaid); $j++) { 
			if(!isset( $order_arr[ $unpaid[$j]->user_id ] )){
				$order_arr[ $unpaid[$j]->user_id ] = [
					'user_id'		=> $unpaid[$j]->user_id,
					'user_name'		=> DB::table('admin_users')->where('id',$unpaid[$j]->user_id)->value('name'),
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
	
			if($unpaid[$j]->created_at > $begin && $unpaid[$j]->created_at < $end){				
				if($unpaid[$j]->order_type == 1){
					$order_arr[ $unpaid[$j]->user_id ] ['new_arrears'] = bcadd($order_arr[ $unpaid[$j]->user_id ] ['new_arrears'],$unpaid[$j]->arrears,2);
				}else{
					$order_arr[ $unpaid[$j]->user_id ] ['old_arrears'] = bcadd($order_arr[ $unpaid[$j]->user_id ] ['old_arrears'],$unpaid[$j]->arrears,2);
				}
			}
			$order_arr[ $unpaid[$j]->user_id ]['all_arrears'] 	= bcadd($order_arr[ $unpaid[$j]->user_id ]['all_arrears'],$unpaid[$j]->arrears,2);		
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
	public function getIdcStatisticsSmall($begin,$end,$user_id){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		$orr = [];

		$already = DB::table('tz_orders')
			->select(DB::raw('sum(payable_money) as payable_money,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->where('business_id',$user_id)
			->groupBy('order_type')
			->get()
			->toArray();
		
		//获取未付款订单
		$unpaid = DB::table('tz_orders')
			->select(DB::raw('payable_money as arrears, created_at ,order_type'))
			->where('order_status',0)
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->where('business_id',$user_id)
			->get()
			->toArray();	
	
		if( count($already) == 0 && count($unpaid) == 0 ){
			$return['msg'] 	= '获取数据失败';
			$return['code'] 	= 0;
			return $return;
		}
		
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
			if($already[$i]->order_type == 1){
				$orr['new_achievement'] = $already[$i]->payable_money;
			}else{
				$orr['old_achievement'] = $already[$i]->payable_money;
			}
		}
		
		for ($j=0; $j < count($unpaid); $j++) { 
			if($unpaid[$j]->created_at > $begin && $unpaid[$j]->created_at < $end){
				if($unpaid[$j]->order_type == 1){
					$orr['new_arrears'] = bcadd($orr['new_arrears'],$unpaid[$j]->arrears,2);
				}else{
					$orr['old_arrears'] = bcadd($orr['old_arrears'],$unpaid[$j]->arrears,2);
				}
			}
			$orr['all_arrears'] = bcadd($orr['all_arrears'],$unpaid[$j]->arrears,2);
		}

		$orr['achievement']		= bcsub(bcadd($orr['new_achievement'],$orr['old_achievement'],2),$orr['preferential_amount'],2);
		$orr['this_arrears']		= bcadd($orr['new_arrears'],$orr['old_arrears'],2);
		$orr['total_money']		= bcadd($orr['achievement'],$orr['this_arrears'],2);

		$return['data'] 	= $orr;
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}
	
}
