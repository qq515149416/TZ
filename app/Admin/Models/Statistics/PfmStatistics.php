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
use App\Admin\Models\Business\OrdersModel;

class  PfmStatistics extends Model
{
   use SoftDeletes;
   
	protected $table = 'tz_orders_flow';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	// protected $fillable = ['user_id', 'achievement','total_money','this_arrears','all_arrears','month','updated_at'];

	/**
	* 统计idc业绩数据,财务用
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
			->whereNull('deleted_at')
			->groupBy('business_id','order_type')
			->get()
			->toArray();	

		//获取所有idc业务欠费订单
		$unpaid = DB::table('tz_orders')
			->select(DB::raw('payable_money as arrears, business_id as user_id , created_at ,order_type'))
			->where('order_status',0)
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->whereNull('deleted_at')
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
	* 统计业绩数据,财务用
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getIdcStatisticsBigByUser($begin,$end,$customer_id){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);

		//获取查询时间段内的已付费idc订单
		$already = DB::table('tz_orders')
			->select(['id','order_sn','serial_number','business_sn','customer_name','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','end_time','pay_time','order_status','order_note','remove_status','created_at'])
			->whereIn('order_status',[1,2,3,4])
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->whereNull('deleted_at')
			->where('customer_id',$customer_id)
			->get()
			->toArray();	

		//获取所有idc业务欠费订单
		$unpaid = DB::table('tz_orders')
			->select(['id','order_sn','serial_number','business_sn','customer_name','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','end_time','pay_time','order_status','order_note','remove_status','created_at'])
			->where('order_status',0)
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->whereNull('deleted_at')
			->where('customer_id',$customer_id)
			->get()
			->toArray();	
		
		if(count($already) == 0 && count($unpaid) == 0 ){
			return [
				'data'	=> [],
				'msg'	=> '无数据',
				'code'	=> 1,
			];
		}

		$order_arr = [
			'user_name'		=> '',
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
		if(!count($already) == 0){
			$order_arr['user_name'] = $already[0]->customer_name;
		}else{
			$order_arr['user_name'] = $unpaid[0]->customer_name;
		}
		if($order_arr['user_name'] == null){
			$order_arr['user_name'] = DB::table('tz_users')->where('id',$customer_id)->value('email');
		}
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if($already[$i]->order_type == 1){
				$order_arr['new_achievement'] = bcadd($order_arr['new_achievement'],$already[$i]->payable_money,2);	
			}else{
				$order_arr['old_achievement'] = bcadd($order_arr['old_achievement'],$already[$i]->payable_money,2);
			}		
		}
	
		for ($j=0; $j < count($unpaid); $j++) { 
			if($unpaid[$j]->created_at > $begin && $unpaid[$j]->created_at < $end){				
				if($unpaid[$j]->order_type == 1){
					$order_arr ['new_arrears'] = bcadd($order_arr['new_arrears'],$unpaid[$j]->payable_money,2);
				}else{
					$order_arr['old_arrears'] = bcadd($order_arr['old_arrears'],$unpaid[$j]->payable_money,2);
				}
			}
			$order_arr['all_arrears'] = bcadd($order_arr['all_arrears'],$unpaid[$j]->payable_money,2);		
		}
		$order_arr['achievement'] = bcsub(bcadd($order_arr['new_achievement'],$order_arr['old_achievement'],2),$order_arr['preferential_amount'],2);
		$order_arr['this_arrears'] = bcadd($order_arr['new_arrears'],$order_arr['old_arrears'],2);
		$order_arr['total_money'] = bcadd($order_arr['achievement'],$order_arr['this_arrears'],2);
		
		$orr = [];
		foreach ($already as $k => $v) {
			$orr[] = $v;
		}
		foreach ($unpaid as $k => $v) {
			$orr[] = $v;
		}

		for ($i=0; $i < count($orr); $i++) { 
			$orr[$i] = $this->trans($orr[$i]);
		}

		$return['data'] 	= [$order_arr];
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
			->whereNull('deleted_at')
			->groupBy('order_type')
			->get()
			->toArray();
		
		//获取未付款订单
		$unpaid = DB::table('tz_orders')
			->select(DB::raw('payable_money as arrears, created_at ,order_type'))
			->where('order_status',0)
			->whereIn('resource_type',[1,2,3,4,5,6,7,8,9])
			->where('business_id',$user_id)
			->whereNull('deleted_at')
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
	
	/**
	* 统计高防IP业绩数据,财务用
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getDefenseipStatisticsBigByUser($begin,$end,$customer_id){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		//获取查询时间段内的已付费高防IP订单
		$already = DB::table('tz_orders')
			->select(['id','order_sn','serial_number','business_sn','customer_name','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','end_time','pay_time','order_status','order_note','remove_status','created_at'])
			->whereIn('order_status',[1,2,3,4])
			->where('resource_type',11)
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->where('customer_id',$customer_id)
			->whereNull('deleted_at')
			->groupBy('business_id','order_type')
			->get()
			->toArray();	

		if(count($already) == 0){
			return [
				'data'	=> [],
				'msg'	=> '无高防IP订单',
				'code'	=> 1,
			];
		}

		$order_arr= [	
			'user_name'			=> $already[0]->customer_name,
			'new_achievement'		=> 0,	
			'old_achievement'		=> 0,
			'preferential_amount'		=> 0,
			'total_money'			=> 0,
		];
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if($already[$i]->order_type == 1){
				$order_arr['new_achievement'] = bcadd($order_arr['new_achievement'],$already[$i]->payable_money,2);	
			}else{
				$order_arr['old_achievement'] = bcadd($order_arr['old_achievement'],$already[$i]->payable_money,2);
			}
			$order_arr['total_money'] = bcadd($order_arr['total_money'],$already[$i]->payable_money,2);
		}
		for ($i=0; $i < count($already); $i++) { 
			$already[$i] = $this->trans($already[$i]);
		}
		

		$return['data'] 	= [$order_arr];
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}
	


	/**
	* 统计指定客户高防IP消费情况,财务用
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getDefenseipStatisticsBig($begin,$end){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		//获取查询时间段内的已付费高防IP订单
		$already = DB::table('tz_orders')
			->select(DB::raw('sum(payable_money) as payable_money, business_id as user_id,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->where('resource_type',11)
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->whereNull('deleted_at')
			->groupBy('business_id','order_type')
			->get()
			->toArray();	
	
		if(count($already) == 0){
			return [
				'data'	=> [],
				'msg'	=> '获取数据失败',
				'code'	=> 1,
			];
		}
	
		$order_arr = [];
		$order_arr['总计'] = [
			'user_id'			=> '总计',		
			'user_name'			=> '总计',
			'new_achievement'		=> 0,	
			'old_achievement'		=> 0,
			'preferential_amount'		=> 0,
			'total_money'			=> 0,
		];
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			if(!isset( $order_arr[ $already[$i]->user_id ] )){
				$order_arr[ $already[$i]->user_id ] = [
					'user_id'		=> $already[$i]->user_id,
					'user_name'		=> DB::table('admin_users')->where('id',$already[$i]->user_id)->value('name'),
					'new_achievement'		=> 0,	
					'old_achievement'		=> 0,
					'preferential_amount'		=> 0,
					'total_money'			=> 0,
				];
			}

			if($already[$i]->order_type == 1){
				$order_arr[ $already[$i]->user_id ] ['new_achievement'] = $already[$i]->payable_money;	
				$order_arr['总计']['new_achievement'] = bcadd($order_arr['总计']['new_achievement'],$already[$i]->payable_money,2);
			}else{
				$order_arr[ $already[$i]->user_id ] ['old_achievement'] = $already[$i]->payable_money;
				$order_arr['总计']['old_achievement'] = bcadd($order_arr['总计']['old_achievement'],$already[$i]->payable_money,2);
			}
			$order_arr[ $already[$i]->user_id ]['total_money'] = bcadd($order_arr[ $already[$i]->user_id ]['total_money'],$already[$i]->payable_money,2);
			$order_arr['总计']['total_money'] = bcadd($order_arr['总计']['total_money'],$already[$i]->payable_money,2);
		}
		$orr = [];
		foreach ($order_arr as $k => $v) {
			$orr[] = $v;
		}

		$return['data'] 	= $orr;
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}
	/**
	* 统计高防IP业绩数据,财务用
	* @param  $begin -开始时间 / $end -结束时间
	* @return 
	*/
	public function getDefenseipStatisticsSmall($begin,$end,$user_id){
		$begin = date("Y-m-d H:i:s",$begin);
		$end = date("Y-m-d H:i:s",$end);
		
		//获取查询时间段内的已付费高防IP订单
		$already = DB::table('tz_orders')
			->select(DB::raw('payable_money,order_type'))
			->whereIn('order_status',[1,2,3,4])
			->where('resource_type',11)
			->where('business_id',$user_id)
			->where('pay_time','>',$begin)
			->where('pay_time','<',$end)
			->whereNull('deleted_at')
			->get()
			->toArray();	
	
		if(count($already) == 0){
			return [
				'data'	=> [],
				'msg'	=> '无已支付订单',
				'code'	=> 1,
			];
		}

		$order_arr = [
			'new_achievement'		=> 0,	
			'old_achievement'		=> 0,
			'preferential_amount'		=> 0,
			'total_money'			=> 0,
		];
		//开始统计
		for ($i=0; $i < count($already); $i++) { 
			
			if($already[$i]->order_type == 1){
				$order_arr['new_achievement'] = bcadd($order_arr['new_achievement'],$already[$i]->payable_money,2);	
			}else{
				$order_arr['old_achievement'] = bcadd($order_arr['old_achievement'],$already[$i]->payable_money,2);
			}
			$order_arr['total_money'] = bcadd($order_arr['total_money'],$already[$i]->payable_money,2);
		}
		

		$return['data'] 	= $order_arr;
		$return['msg'] 	= '统计成功';
		$return['code']	= 1;
		return $return;
	}
	
	/*
	*转换状态方法,适用订单
	*/
	protected function trans($arr){
		switch ($arr->order_type) {
			case '1':
				$arr->order_type = '新购';
				break;
			case '2':
				$arr->order_type = '续费';
				break;	
			default:
				$arr->order_type = '无此类型';
				break;
		}
		switch ($arr->order_status) {
			case '0':
				$arr->order_status = '待支付';
				break;
			case '1':
				$arr->order_status = '已支付';
				break;
			case '2':
				$arr->order_status = '财务确认';
				break;
			case '3':
				$arr->order_status = '订单完成';
				break;
			case '4':
				$arr->order_status = '到期';
				break;
			case '5':
				$arr->order_status = '取消';
				break;
			case '6':
				$arr->order_status = '待支付';
				break;
			case '8':
				$arr->order_status = '退款完成';
				break;
			case '9':
				$arr->order_status = '需支付尚未支付';
				break;
			default:
				$arr->order_status = '无此支付状态';
				break;
		}
		switch ($arr->remove_status) {
			case '0':
				$arr->remove_status = '正常';
				break;
			case '1':
				$arr->remove_status = '下架申请中';
				break;
			case '2':
				$arr->remove_status = '等待机房处理';
				break;
			case '3':
				$arr->remove_status = '清空下架中';
				break;
			case '4':
				$arr->remove_status = '下架完成';
				break;
			default:
				$arr->remove_status = '无此状态';
				break;
		}
		switch ($arr->resource_type) {
			case '1':
				$arr->resource_type = '租用主机';
				break;
			case '2':
				$arr->resource_type = '托管主机';
				break;
			case '3':
				$arr->resource_type = '租用机柜';
				break;
			case '4':
				$arr->resource_type = 'IP';
				break;
			case '5':
				$arr->resource_type = 'CPU';
				break;
			case '6':
				$arr->resource_type = '硬盘';
				break;
			case '7':
				$arr->resource_type = '内存';
				break;
			case '8':
				$arr->resource_type = '带宽';
				break;
			case '9':
				$arr->resource_type = '防护';
				break;
			case '10':
				$arr->resource_type = 'cdn';
				break;
			case '11':
				$arr->resource_type = '高防IP';
				break;
			default:
				$arr->resource_type = '无此类型';
				break;
		}
		return $arr;
	}

	public function test($begin,$end){
		
		$already = DB::table('tz_orders_flow as a')
			->leftJoin('tz_users as b','a.customer_id','=','b.id')
			->select('a.customer_id','b.name as customer_name','b.nickname as customer_nickname','b.email as customer_email',DB::raw('SUM(a.actual_payment) as money'))
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->groupBy('a.customer_id')
			->get();

		$order_model = new OrdersModel();
		
		$not = DB::table('tz_orders as a')
			->leftJoin('tz_users as b','a.customer_id','=','b.id')
			->select('a.customer_id','b.name as customer_name','b.nickname as customer_nickname','b.email as customer_email',DB::raw('SUM(a.payable_money) as money'))
			->where('a.created_at','>',$begin)
			->where('a.created_at','<',$end)
			->where('a.order_status',0)
			->where('a.remove_status',0)
			->groupBy('a.customer_id')
			->get();

		$maybe = DB::table('tz_business as a')
			->leftJoin('tz_users as b','a.client_id','=','b.id')
			->select('a.client_id as customer_id','b.name as customer_name','b.nickname as customer_nickname','b.email as customer_email',DB::raw('SUM(a.money) as money'))
			->where('a.endding_time','>',$begin)
			->where('a.endding_time','<',$end)
			->groupBy('a.client_id')
			->get();

		$maybe_res = DB::table('tz_orders as a')
			->leftJoin('tz_users as b','a.customer_id','=','b.id')
			->select('a.customer_id','b.name as customer_name','b.nickname as customer_nickname','b.email as customer_email',DB::raw('SUM(a.price) as money'))
			->where('a.end_time','>',$begin)
			->where('a.end_time','<',$end)
			->whereIn('a.order_status',[0,1])
			->where('a.remove_status',0)
			->groupBy('a.customer_id')
			->get();
		
		$arr['heji'] = [
			'already' 		=> 0,
			'not'			=> 0,
			'maybe'		=> 0,
			'customer_id'		=> 0,
			'customer_email'	=> '合计',
			'customer_name'	=> '合计',
			'customer_nickname'	=> '合计',
		];

		foreach ($already as $k => $v) {
			if(!isset($arr[$v->customer_id])){
				$arr[$v->customer_id] = [
					'already' 		=> $v->money,
					'not'			=> 0,
					'maybe'		=> 0,
					'customer_id'		=> $v->customer_id,
					'customer_name'	=> $v->customer_name,
					'customer_email'	=> $v->customer_email,
					'customer_nickname'	=> $v->customer_nickname,
				];
			}
			$arr['heji']['already'] = bcadd($arr['heji']['already'], $v->money,2);
		}
		foreach ($not as $k => $v) {
			if(!isset($arr[$v->customer_id])){
				$arr[$v->customer_id] = [
					'already' 		=> 0,
					'not'			=> $v->money,
					'maybe'		=> 0,
					'customer_id'		=> $v->customer_id,
					'customer_name'	=> $v->customer_name,
					'customer_email'	=> $v->customer_email,
					'customer_nickname'	=> $v->customer_nickname,
				];
			}else{
				$arr[$v->customer_id]['not'] = bcadd($arr[$v->customer_id]['not'], $v->money,2);
			}
			$arr['heji']['not'] = bcadd($arr['heji']['not'], $v->money,2);
		}

		foreach ($maybe as $k => $v) {
			if(!isset($arr[$v->customer_id])){
				$arr[$v->customer_id] = [
					'already' 		=> 0,
					'not'			=> 0,
					'maybe'		=> $v->money,
					'customer_id'		=> $v->customer_id,
					'customer_name'	=> $v->customer_name,
					'customer_email'	=> $v->customer_email,
					'customer_nickname'	=> $v->customer_nickname,
				];
			}else{
				$arr[$v->customer_id]['maybe'] = bcadd($arr[$v->customer_id]['maybe'], $v->money,2);
			}
			$arr['heji']['maybe'] = bcadd($arr['heji']['maybe'], $v->money,2);
		}

		foreach ($maybe_res as $k => $v) {
			if(!isset($arr[$v->customer_id])){
				$arr[$v->customer_id] = [
					'already' 		=> 0,
					'not'			=> 0,
					'maybe'		=> $v->money,
					'customer_id'		=> $v->customer_id,
					'customer_name'	=> $v->customer_name,
					'customer_email'	=> $v->customer_email,
					'customer_nickname'	=> $v->customer_nickname,
				];
			}else{
				$arr[$v->customer_id]['maybe'] = bcadd($arr[$v->customer_id]['maybe'], $v->money,2);
			}
			$arr['heji']['maybe'] = bcadd($arr['heji']['maybe'], $v->money,2);
		}
	
		$brr = [];
		foreach ($arr as $k => $v) {
			$brr[] = $v;
		}
		
		return $brr;
	}
}
