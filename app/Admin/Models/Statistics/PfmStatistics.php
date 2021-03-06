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
use Carbon\Carbon;

class  PfmStatistics extends Model
{
   use SoftDeletes;

	protected $table = 'tz_orders_flow';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['invoice_state']  ;
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

		$already = DB::table('tz_orders_flow as a')
			->select(DB::raw('sum(a.actual_payment) as payable_money, a.business_id as user_id,a.flow_type as order_type'))
			->leftjoin('tz_business_relevance as b','a.business_number','=','b.business_id')
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->where('b.type',1)
			->whereNull('a.deleted_at')
			->groupBy('a.business_id','order_type')
			->get()
			->toArray();
		// dd($already);
		//获取所有idc业务欠费订单
		$unpaid = DB::table('tz_orders')
			->select(DB::raw('payable_money as arrears, business_id as user_id , created_at ,order_type'))
			->where('order_status',0)
			->whereIn('remove_status',[0,1])
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
		$order_arr['count_all'] = [
			'user_id'			=> '总计',
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
			if($k != 'count_all'){
				$v['achievement'] 	= bcsub(bcadd($v['new_achievement'],$v['old_achievement'],2),$v['preferential_amount'],2);
				$v['this_arrears']	= bcadd($v['new_arrears'],$v['old_arrears'],2);
				$v['total_money']	= bcadd($v['achievement'],$v['this_arrears'],2);
				$order_arr['count_all']['achievement'] = bcadd($order_arr['count_all']['achievement'],$v['achievement'] ,2);
				$order_arr['count_all']['new_achievement'] = bcadd($order_arr['count_all']['new_achievement'],$v['new_achievement'] ,2);
				$order_arr['count_all']['old_achievement'] = bcadd($order_arr['count_all']['old_achievement'],$v['old_achievement'] ,2);
				$order_arr['count_all']['this_arrears'] = bcadd($order_arr['count_all']['this_arrears'],$v['this_arrears'] ,2);
				$order_arr['count_all']['new_arrears'] = bcadd($order_arr['count_all']['new_arrears'],$v['new_arrears'] ,2);
				$order_arr['count_all']['old_arrears'] = bcadd($order_arr['count_all']['old_arrears'],$v['old_arrears'] ,2);
				$order_arr['count_all']['all_arrears'] = bcadd($order_arr['count_all']['all_arrears'],$v['all_arrears'] ,2);
				$order_arr['count_all']['preferential_amount'] = bcadd($order_arr['count_all']['preferential_amount'],$v['preferential_amount'] ,2);
				$order_arr['count_all']['total_money'] = bcadd($order_arr['count_all']['total_money'],$v['total_money'] ,2);
				$orr[] = $v;
			}
		}
		$orr[] = $order_arr['count_all'];
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

		$user_info = DB::table('tz_users')->where('id',$customer_id)->first();
		$user_nickname = $user_info->nickname;
		$user_name = $user_info->name;
		$user_email = $user_info->email;


		$already = DB::table('tz_orders_flow as a')
			->select(DB::raw('sum(a.actual_payment) as payable_money,a.flow_type as order_type'))
			->leftjoin('tz_business_relevance as b','a.business_number','=','b.business_id')
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->where('a.customer_id',$customer_id)
			->where('b.type',1)
			->whereNull('a.deleted_at')
			->get()
			->toArray();

		//获取所有idc业务欠费订单
		$unpaid = DB::table('tz_orders')
			->select(['id','order_sn','serial_number','business_sn','customer_name','business_name','resource_type','order_type','machine_sn','resource','price','duration','payable_money','end_time','pay_time','order_status','order_note','remove_status','created_at'])
			->where('order_status',0)
			->whereIn('remove_status',[0,1])
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
			'user_name'		=> $user_nickname,
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

		$already = DB::table('tz_orders_flow as a')
			->select(DB::raw('sum(a.actual_payment) as payable_money,a.flow_type as order_type'))
			->leftjoin('tz_business_relevance as b','a.business_number','=','b.business_id')
			->where('a.pay_time','>',$begin)
			->where('a.pay_time','<',$end)
			->where('a.business_id',$user_id)
			->where('b.type',1)
			->whereNull('a.deleted_at')
			->groupBy('flow_type')
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
			$return['data']	= [];
			$return['msg'] 	= '无数据';
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
		$order_arr['count_all'] = [
			'user_id'				=> '总计',
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
				$order_arr['count_all']['new_achievement'] = bcadd($order_arr['count_all']['new_achievement'],$already[$i]->payable_money,2);
			}else{
				$order_arr[ $already[$i]->user_id ] ['old_achievement'] = $already[$i]->payable_money;
				$order_arr['count_all']['old_achievement'] = bcadd($order_arr['count_all']['old_achievement'],$already[$i]->payable_money,2);
			}
			$order_arr[ $already[$i]->user_id ]['total_money'] = bcadd($order_arr[ $already[$i]->user_id ]['total_money'],$already[$i]->payable_money,2);
			$order_arr['count_all']['total_money'] = bcadd($order_arr['count_all']['total_money'],$already[$i]->payable_money,2);
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
	//按机房分消费记录
	public function test2($begin,$end){
		$already = $this->where('pay_time','>',$begin)
				->where('pay_time','<',$end)
				->select(['business_number' , 'payable_money' ,'serial_number','customer_id','order_id' ,'pay_time'])
				->get()
				->toArray();

		foreach ($already as $k => $v) {

			if ($v['business_number'] == '叠加包') {
				$machine_room = DB::table('tz_orders as a')
							->leftjoin('tz_overlay as b' , 'b.id' , '=' , 'a.machine_sn')
							->leftjoin('idc_machineroom as c' , 'c.id' , '=' , 'b.site')
							->where('a.serial_number',$v['serial_number'])
							->value('c.machine_room_name');
				$already[$k]['type'] = '叠加包';
			}else{
				$v['order_id'] = json_decode($v['order_id']);
				if (is_array($v['order_id'])) {
					$resource_type = DB::table('tz_orders')->where('id' , $v['order_id'][0])->value('resource_type');
				}else{
					$resource_type = DB::table('tz_orders')->where('id' , $v['order_id'])->value('resource_type');
				}

				switch ($resource_type) {
					case '1':
					case '2':
					case '3':
					case '4':
					case '5':
					case '6':
					case '7':
					case '8':
					case '9':


						$resource_detail = DB::table('tz_business')
							->where('business_number',$v['business_number'])
							->value('resource_detail');
						$resource_detail = json_decode($resource_detail);
						$machine_room = $resource_detail->machineroom_name;
						$already[$k]['type'] = 'idc';
						break;

					case '11':
						$machine_room = DB::table('tz_defenseip_business as a')
							->leftjoin('tz_defenseip_store as b' , 'b.id' , '=' , 'a.ip_id')
							->leftjoin('idc_machineroom as c' , 'c.id' , '=' , 'b.site')
							->where('a.business_number',$v['business_number'])
							->value('c.machine_room_name');
						$already[$k]['type'] = '高防';
						break;
					default:
						$machine_room = '机房信息获取失败';
						$already[$k]['type'] = '未知';
						break;
				}
			}
			$already[$k]['machine_room'] = $machine_room;
			$customer_info =  DB::table('tz_users')->where('id',$v['customer_id'])->first(['name' , 'nickname' , 'email']);
			if($customer_info == null){
				$already[$k]['customer_name'] = '客户名字获取失败';
			}else{
				if ($customer_info->nickname != null) {
					$already[$k]['customer_name'] = $customer_info->nickname;
				}else{
					$already[$k]['customer_name'] = $customer_info->email?$customer_info->email:$customer_info->name;
				}
			}
		}
		return $already;
	}

	//按客户分
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
			'maybe'			=> 0,
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
					'maybe'			=> 0,
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

	/**
	 * 根据产品类型进行业务员业绩的统计
	 * @param  array $time --begin查询开始时间,--end查询结束时间
	 * @return [type]       [description]
	 */
	public function performance($time){
		$begin_end = $this->queryTime($time);
		//实付金额
		$actual_payment = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('deleted_at')
					->sum('actual_payment');
		//优惠金额
		$preferential_amount = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('deleted_at')
					->sum('preferential_amount');
		//应付金额
		$payable_money = DB::table('tz_orders_flow')
					->whereBetween('pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('deleted_at')
					->sum('payable_money');
		if($time['business_type'] == 1){
			$admin_users = DB::table('admin_users')->get(['id','name'])->toArray();//查询全员营销人员
			$where = 'flow.business_id';
		} elseif($time['business_type'] == 2){
			$admin_users = DB::table('idc_machineroom')->whereNull('deleted_at')->get(['id','machine_room_name as name'])->toArray();//查机房
			$where = 'flow.room_id';
		}

		$admin_users = $this->total($admin_users,$begin_end,$where);
		//取出二维数组里面的sum字段的值
		$sort_sum = array_column($admin_users,'sum');
		//根据sum字段值进行降序排序,由多到少
		array_multisort($sort_sum,SORT_DESC,$admin_users);

		$data['actual_payment'] = $actual_payment;//实际付款
		$data['preferential_amount'] = $preferential_amount;//优惠额度
		$data['payable_money'] = $payable_money;//应付款
		$data['count'] = $admin_users;
		$return['code'] = 1;
		$return['msg'] = '';
		$return['data'] = $data;
		return $return;
	}

	/**
	 * 计算查询的起始时间和结束时间
	 * @param  array $query_time begin--查询时间段的开始时间 end--查询时间段的结束时间
	 * @return array             返回查询的起始时间和结束时间
	 */
	public function queryTime($query_time){
		if(!isset($query_time['begin']) && !isset($query_time['end'])){//当查询开始间和结束时间都未设置时

			$end_time = date('Y-m-d',strtotime("+1 day"));//结束时间等于当前时间往后推一天，即当前天的23:59:59
			$month = date('Y-m',time());//获取结束时间所属自然月
			$start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

		} elseif(isset($query_time['begin']) && !isset($query_time['end'])){//当设置查询开始时间，未设置结束时间时

			$start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
			$month = date('Y-m',$query_time['begin']);//获取开始时间所属自然月
			$last_day = date('t',$month);//获取开始时间所属自然月的总天数
			$end_time = date('Y-m-d',strtotime($month.'-'.$last_day."+1 day"));//结束时间设置为开始时间所属自然月的最后一天的23:59:59

		} elseif(!isset($query_time['begin']) && isset($query_time['end'])){//当起始时间未设置，结束时间设置时

			$end_time = date('Y-m-d',strtotime(date('Y-m-d',$query_time['end'])."+1 day"));//结束时间等于设置的结束时间
			$month = date('Y-m',$query_time['end']);//获取结束时间所属的自然月
			$start_time = $month.'-01';//获取结束时间所属自然月的第一天的零点为查询的开始时间

		} elseif(isset($query_time['begin']) && isset($query_time['end'])){//当查询的起始时间和结束时间都设置时

			$start_time = date('Y-m-d',$query_time['begin']);//起始时间等于设置的起始时间
			$end_time = date('Y-m-d',strtotime(date('Y-m-d',$query_time['end'])."+1 day"));//结束时间等于设置的结束时间
		}
		return ['start_time'=>$start_time,'end_time'=>$end_time];
	}

	public function statistics(){

		$now = date('Y-m-d',time());//现在的日期

		$last_start = date('Y-m-01',strtotime($now.'-1 month'));//上个月的第一天

		$seven_end = date('Y-m-d',strtotime($now.'+1 day'));//7天/今天统计的结束日期（由于数据库的存储时间原因,所以日期需往后延一天）

		$seven_start = date('Y-m-d',strtotime($seven_end.'-7 day'));//7天统计的开始日期

		$month_start = date('Y-m-01',time());//当前月所在的第一天

		$month_last = date('Y-m-t',time());//当前月所在的最后一天

		$month_end = date('Y-m-d',strtotime($month_last.'+1 day'));//当前月统计的结束日期（由于数据库的存储时间原因,所以日期需往后延一天）

	}

	/**
	 * performance方法的统计复用
	 * @param  array $admin_users  机房集合/业务员集合
	 * @param  array $begin_end   查询的时间段
	 * @return [type]              [description]
	 */
	protected function total($admin_users,$begin_end,$where){
		$idc_count = 0;//总计idc销售额
		$defense = 0;//总计高防销售额
		$flow = 0;//总计叠加包销售额
		$cdn = 0;//总计cdn销售额
		$cloud = 0;//总计云销售额
		$total = 0;//总额

		foreach($admin_users as $key=>$value){
			/**
			 * 每个业务员IDC销售额
			 * @var [type]
			 */
			$value->idc_count = DB::table('tz_orders_flow as flow')
					->join('tz_business as business','flow.business_number','=','business.business_number')
					->where([$where=>$value->id])
					->whereBetween('flow.pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('flow.deleted_at')
					->whereNull('business.deleted_at')
					->sum('actual_payment');
			$idc_count = bcadd($idc_count,$value->idc_count,2);//总计IDC销售额

			/**
			 * 每个业务员高防销售额
			 * @var [type]
			 */
			$value->defense_count = DB::table('tz_orders_flow as flow')
					->join('tz_defenseip_business as business','flow.business_number','=','business.business_number')
					->where([$where=>$value->id])
					->whereBetween('flow.pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('flow.deleted_at')
					->whereNull('business.deleted_at')
					->sum('actual_payment');
			$defense = bcadd($defense,$value->defense_count,2);//总计高防销售额

			/**
			 * 每个业务员叠加包销售额
			 * @var [type]
			 */
			$value->flow_count = DB::table('tz_orders_flow as flow')
					->join('tz_orders as business','flow.business_number','=','business.business_sn')
					->where([$where=>$value->id,'business.resource_type'=>12])
					->whereBetween('flow.pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('flow.deleted_at')
					->whereNull('business.deleted_at')
					->select('flow.id','flow.actual_payment')
					->distinct('id')
					->get()
					->sum('actual_payment');

			$flow = bcadd($flow,$value->flow_count,2);//总计叠加包销售额

			$value->cdn_count = 0;//每个业务员cdn销售额
			$cdn = bcadd($cdn,$value->cdn_count,2);//总计cdn销售额

			$value->cloud_count = 0;//每个业务员云销售额
			$cloud = bcadd($cloud,$value->cloud_count,2);//总计云销售额

			/**
			 * 每个业务员总销售额
			 * @var [type]
			 */
			$value->sum = DB::table('tz_orders_flow as flow')
					->where([$where=>$value->id])
					->whereBetween('pay_time',[$begin_end['start_time'],$begin_end['end_time']])
					->whereNull('deleted_at')
					->sum('actual_payment');
			if($value->sum == 0){
				unset($admin_users[$key]);
			}
			$total = bcadd($value->sum,$total,2);//总销售额

		}
		//总计数据传入数组
		$object = (object)[
					'name'=>'总计',
					'idc_count'=>$idc_count,
					'defense_count'=>$defense,
					'flow_count'=>$flow,
					'cdn_count'=>$cdn,
					'cloud_count'=>$cloud,
					'sum'=>$total
				];
		array_unshift($admin_users,$object);
		return $admin_users;
	}

	public function consumptionTwelve()
	{
		$this_month = date('Y-m').'-01 00:00:00';
		$dt = Carbon::parse($this_month);

		$res = [];
		for ($i=6; $i >= 1; $i--) { 

			$month = date('Y-m',$dt->copy()->subMonths($i)->timestamp);
			$res[] = [
				'time'		=> $month,
				'amount'	=> $this->getConsumptionByMonth($month)+0,
			];
		}

		return [
			'data'	=> $res,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	/**
	 * 统计消费,按月
	 * @param  $month -	格式:Y-m ; 例: 2019-09
	 * @param
	 * @return [type]              [description]
	 */
	public function getConsumptionByMonth($month)
	{
		$begin = $month.'-01 00:00:00';
		$end = date('Y-m-t 23:59:59',strtotime($begin));

		$all_actual_payment = $this->where('pay_time','>',$begin)
				->where('pay_time','<',$end)
				->sum('actual_payment');

		return $all_actual_payment;
	}

	public function consumptionToday()
	{
		$begin = date('Y-m-d').' 00:00:00';
		$end = date('Y-m-d').' 23:59:59';

		$all_actual_payment = $this->where('pay_time','>',$begin)
				->where('pay_time','<',$end)
				->sum('actual_payment');

		return $all_actual_payment;
	}
	/***
	* 按月获取消费统计
	*
	*
	**/
	public function getConsumptionDetailed($month)
	{
		//拼接出月份开始的date (头一天的0点)
		$begin = $month.'-01 00:00:00';
		//获取月份的结束date (最后一天的最后一秒)
		$end = date('Y-m-t 23:59:59',strtotime($begin));
		//月份的最后一天的 日
		$month_day = date('t',strtotime($begin));
		//获取月份
		$month_small = date('m',strtotime($begin));

		//获取所有消费流水
		$all_actual_payment = $this->leftJoin('admin_users as b' , 'b.id' , '=' , 'tz_orders_flow.business_id')
				->leftjoin('tz_users as c' , 'c.id' , '=' , 'tz_orders_flow.customer_id')
				->where('tz_orders_flow.pay_time','>',$begin)
				->where('tz_orders_flow.pay_time','<',$end)
				// ->select(DB::raw('sum(tz_orders_flow.actual_payment) as actual_payment') , 'b.name')
				// ->groupBy('tz_orders_flow.business_id')
				// ->get()->toArray();
				->orderBy('tz_orders_flow.pay_time','desc')
				->get(['tz_orders_flow.actual_payment' , 'tz_orders_flow.id as flow_id' , 'tz_orders_flow.order_id' , 'b.name' , 'tz_orders_flow.serial_number' , 'tz_orders_flow.pay_time' , 'c.name as cusname' , 'c.nickname' , 'c.email']);
		//dd($all_actual_payment);
		if ($all_actual_payment->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '当月无业绩',
				'code'	=> 1,
			];
		}
		$all_actual_payment = $all_actual_payment->toArray();

		//生成该月每天的数组
		for ($j=1; $j <= $month_day; $j++) { 
			$arr[] = [
				'time'			=> $month_small .'-'.$j,
				'actual_payment'	=> 0,
			];
		}
		//业务员数组
		$user_arr = [];
		//业务类型数组
		$type_arr = [
			0	=> [
				'type'			=> 'idc',
				'actual_payment'	=> 0,
			],
			1	=> [
				'type'			=> 'cdn',
				'actual_payment'	=> 0,
			],
			2	=> [
				'type'			=> '高防',
				'actual_payment'	=> 0,
			],
			3	=> [
				'type'			=> '流量叠加包',
				'actual_payment'	=> 0,
			],
			4	=> [
				'type'			=> '未知业务种类',
				'actual_payment'	=> 0,
			],
		];
		foreach ($all_actual_payment as $k => $v) {
			//获取客户名称,昵称>邮箱>登录名
			$all_actual_payment[$k]['customer_name'] = $all_actual_payment[$k]['nickname']?:$all_actual_payment[$k]['email']?:$all_actual_payment[$k]['cusname'];
			if ($v['name'] == null) {
				$v['name'] = '已删业务员';
			}
			//这订单id存的不统一,有点存的json数组,有的就存的一个数字
			$v['order_id'] = json_decode($v['order_id'] , true);
			if (!is_array($v['order_id'] ) ) {
				$all_actual_payment[$k]['order_id'] = array( 0 => $v['order_id'] );
			}else{
				$all_actual_payment[$k]['order_id'] = $v['order_id'];
			}

			//计算种类的
			$type = DB::table('tz_orders')->where('id',$all_actual_payment[$k]['order_id'][0])->value('resource_type');
			switch ($type) {
				case '1':				
				case '2':
				case '3':
				case '4':
				case '5':
				case '6':
				case '7':
				case '8':
				case '9':
					$all_actual_payment[$k]['type'] = 'IDC';
					$type_arr[0]['actual_payment'] = round($type_arr[0]['actual_payment']+$v['actual_payment'] ,2);
					break;
				case '10':
					$all_actual_payment[$k]['type'] = 'CDN';
					$type_arr[1]['actual_payment'] = round($type_arr[1]['actual_payment']+$v['actual_payment'] ,2);
					break;
				case '11':
					$all_actual_payment[$k]['type'] = '高防IP';
					$type_arr[2]['actual_payment'] = round($type_arr[2]['actual_payment']+$v['actual_payment'] ,2);
					break;
				case '12':
					$all_actual_payment[$k]['type'] = '流量叠加包';
					$type_arr[3]['actual_payment'] = round($type_arr[3]['actual_payment']+$v['actual_payment'] ,2);
					break;
				default:
					$all_actual_payment[$k]['type'] = '未知类型';
					$type_arr[4]['actual_payment'] = round($type_arr[4]['actual_payment']+$v['actual_payment'] ,2);
					break;
			}
			
			//计算业务员的
			if (!isset($user_arr[$v['name']])) {
				$user_arr[$v['name']] = $v['actual_payment']+0;
			}else{
				$user_arr[$v['name']] = $user_arr[$v['name']] + $v['actual_payment'];
			}

			//计算日期的
			$day = date('j',strtotime($v['pay_time']));
			$arr[$day-1]['actual_payment'] = round($arr[$day-1]['actual_payment']+$v['actual_payment'] ,2);
		}

		$user_sta = [];
		foreach ($user_arr as $k => $v) {
			$user_sta[] = [
				'name'	=> $k,
				'pfm'	=> round($v,2),
			];
		}
		//dd($type_arr);
		return [
			'data'	=> [
				'user_sta'	=> $user_sta,
				'type_sta'	=> $type_arr,
				'list'		=> $all_actual_payment,
				'line'		=> $arr,
			],
			'msg'	=> '获取成功',
			'code'	=> 1,
		];

	}
	/**
	* @param
	*
	*/
	public function getOrderByFlowId($flow_id)
	{
		$order_id = $this->where('id',$flow_id)->value('order_id');	
		if(!$order_id){
			return [
				'data'	=> [],
				'msg'	=> '流水不存在',
				'code'	=> 0,
			];
		}
		$order_id = json_decode($order_id,true);

		$orr = [];
		//dd($order_id);
		$check = 0;
		$fail = '';
		if (is_array($order_id)) {	//数组类型的,从里面一个个找出来

			foreach ($order_id as $k => $v) {
				$order = $this->showOrderDetail($v);
				if ($order['code'] == 1) {
					$orr[] = $order['data'];
				}else{
					$check = 1;
					$fail.= $v.' , ';
				}
			}
		}else{
			$order = $this->showOrderDetail($order_id);
			if ($order['code'] == 1) {
				$orr[] = $order['data'];
			}else{
				$check = 1;
				$fail.= $v;
			}	
		}
		if ($check == 0) {
			return [
				'data'	=> $orr,
				'msg'	=> '获取成功',
				'code'	=> 1
			];
		}else{
			return [
				'data'	=> $orr,
				'msg'	=> '以下id获取失败 : ' .  $fail,
				'code'	=> 0
			];
		}
	}

	/**
	*
	* @param 
	* 
	*
	*
	**/
	public function showOrderDetail($order_id)
	{
		$model = new OrdersModel();
		$order = $model->where('id' , $order_id)->first( ['business_sn','resource_type' , 'machine_sn' , 'price' , 'duration' ,'end_time' ,'pay_time','resource' ,'order_type' , 'order_sn'] );
		if (!$order) {
			return [
				'data'	=> [],
				'msg'	=> '获取订单信息失败',
				'code'	=> 0,
			];
		}else{
			$order = $order->toArray();
		}

		$detail = [];
		$order_type_arr = [ 1 => '新购' , 2 => '续费'];
		$detail['order_type'] = $order_type_arr[$order['order_type']];
		$detail['order_sn'] = $order['order_sn'];
		$detail['business_sn'] = $order['business_sn'];
		//资源的类型(1.租用主机，2.托管主机，3.租用机柜，4.IP，5.CPU，6.硬盘，7.内存，8.带宽，9.防护，10.cdn , 11.高防IP ; 12.流量叠加包 )
		$detail['type'] = $order['resource_type'];
		if (in_array($order['resource_type'], [ 1,2,3,4,5,6,7,8,9]) ) {
			$business = DB::table('tz_business')
						->where('business_number' , $order['business_sn'])
						->first(['resource_detail']);
			if ($business == null) {
				return [
					'data'	=> [],
					'msg'	=> '获取详细信息失败',
					'code'	=> 0,
				];
			}
			$business = json_decode($business->resource_detail , true);
			if ($order['resource_type'] != 3) {
				$detail['machine_num'] 		= $business['machine_num'];
				$detail['machine_type'] 		= $business['machine_type'];
			}
			
			$detail['machineroom'] 		= $business['machineroom_name'];
		}

		switch ($order['resource_type']) {
			case '1':
			case '2':
				if ($order['resource_type'] == 1) {
					$detail['resource_type'] = '租用主机';
				}elseif ($order['resource_type'] == 2) {
					$detail['resource_type'] = '托管主机';
				}
				$detail['resource'] 		= [
					'cpu'			=> $business['cpu'],
					'memory'		=> $business['memory'],
					'harddisk'		=> $business['harddisk'],
					'bandwidth'		=> $business['bandwidth'],
					'protect'		=> $business['protect'],
					'machine_type'		=> $business['machine_type'],
				];	
				break;
			case '3':
				$detail['resource_type'] 		= '租用机柜';
				$detail['resource'] 		= $business['cabinet_id'];
				break;
			case '4':
				$detail['resource_type'] 		= 'IP';
				$detail['resource'] 		= $order['resource'];
				break;
			case '5':
				$detail['resource_type'] 		= 'CPU';
				$detail['resource'] 		= $order['resource'];
				break;
			case '6':
				$detail['resource_type'] 		= '硬盘';
				$detail['resource'] 		= $order['resource'];
				break;
			case '7':
				$detail['resource_type'] 		= '内存';
				$detail['resource'] 		= $order['resource'];
				break;
			case '8':
				$detail['resource_type'] 		= '带宽';
				$detail['resource'] 		= $order['resource'];
				break;
			case '9':
				$detail['resource_type'] 		= '防护';
				$detail['resource'] 		= $order['resource'];
				break;
			case '10':
				$detail['resource_type'] 		= 'CDN';
				$detail['resource'] 		= $order['resource'];
				break;
			case '11':
				$detail['resource_type'] 		= '高防IP';
				$package = DB::table('tz_defenseip_package as a')
						->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'a.site')
						->where('a.id',$order['machine_sn'])
						->first(['a.name' , 'a.description' , 'a.protection_value' , 'b.machine_room_name']);
				if ($package == null) {
					$detail['resource'] 	= [
						'name'			=> '获取高防信息失败',
						'description'		=> '获取高防信息失败',
						'protection_value'	=> '获取高防信息失败',
					];
					$detail['machineroom'] 	= '';
				}else{
					$detail['resource'] 	= [
						'name'			=> $package->name,
						'description'		=> $package->description,
						'protection_value'	=> $package->protection_value.'G',
					];
				
					$detail['machineroom'] 		= $package->machine_room_name;
				}
				break;
			case '12':
				$detail['resource_type'] 		= '流量叠加包';
				$package = DB::table('tz_overlay as a')
					->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'a.site')
					->where('a.id',$order['machine_sn'])
					->first(['a.name' , 'a.description' , 'b.machine_room_name' , 'a.protection_value']);
				if ($package == null) {
					$detail['resource'] 	= [
						'name'			=> '获取叠加包信息失败',
						'description'		=> '获取叠加包信息失败',
						'protection_value'	=> '获取叠加包信息失败',
					];
					$detail['machineroom'] 	= '';
				}else{
					$detail['resource'] 	= [
						'name'			=> $package->name,
						'description'		=> $package->description,
						'protection_value'	=> $package->protection_value.'G',
					];
					$detail['machineroom'] 		= $package->machine_room_name;

				}
				break;

			default:
				# code...
				break;
		}
		$detail['price'] 			= $order['price'];
		$detail['duration'] 		= $order['duration'];
		$detail['end_time'] 		= $order['end_time'];
		$detail['pay_time'] 		= $order['pay_time'];

		return [
			'data'	=> $detail,
			'msg'	=> '获取订单信息成功',
			'code'	=> 1,
		];
	}
}
