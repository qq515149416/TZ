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
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;

class  RechargeStatistics extends Model
{
   use SoftDeletes;

	protected $table = 'tz_recharge_flow';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = [];

	/**
	* 统计业绩的方法
	* @return 将数据及相关的信息返回到控制器
	*/

	public function statistics($begin,$end)
	{
		//获取查询时间内的订单
		$flow = DB::table('tz_recharge_flow')
				->select(
					'recharge_way',
					'user_id',
					DB::raw('
						SUM(recharge_amount) AS money
						')
					)
				->groupBy('recharge_way','user_id')
				->whereNull('deleted_at')
				->where('timestamp','<',$end)
				->where('timestamp','>',$begin)
				->where('trade_status',1)
				->get();
		if($flow->isEmpty()){
			return [
				'data'	=> '',
				'code'	=> 0,
				'msg'	=> '无数据',
			];
		}

		$flow = json_decode(json_encode($flow),true);

		//生成每个有充值的用户的空数组
		$order_arr = [];
		//总计
		$order_arr['总计'] = [
			'customer_id'		=> 0,
			'customer_name'	=> '总计',
			'recharge_amount'	=> 0,
			'artificial_amount'	=> 0,
			'self_amount'		=> 0,
		];
		foreach ($flow as $k => $v) {
			if(!isset($order_arr[$v['user_id']])){
				$order_arr[$v['user_id']]['customer_id']		= $v['user_id'];
				$order_arr[$v['user_id']]['customer_name']	= DB::table('tz_users')->where('id', $v['user_id'])->value('name');
				if($order_arr[$v['user_id']]['customer_name'] == null){
					$order_arr[$v['user_id']]['customer_name']	= DB::table('tz_users')->where('id', $v['user_id'])->value('email');
				}
				$order_arr[$v['user_id']]['recharge_amount']	= 0;
				$order_arr[$v['user_id']]['artificial_amount']	= 0;
				$order_arr[$v['user_id']]['self_amount']		= 0;
			}

			if($v['recharge_way'] == 3){	//如果是手动充值
				$order_arr[$v['user_id']]['artificial_amount']	= $v['money'];
				$order_arr['总计']['artificial_amount']		= bcadd( $order_arr['总计']['artificial_amount'] , $v['money'],2);
			}else{				//其余的是自助充
				$order_arr[$v['user_id']]['self_amount']		= $v['money'];
				$order_arr['总计']['self_amount']		= bcadd( $order_arr['总计']['self_amount'] , $v['money'],2);
			}
			$order_arr[$v['user_id']]['recharge_amount']	= bcadd($order_arr[$v['user_id']]['recharge_amount'], $v['money'],2);
			$order_arr['总计']['recharge_amount']		= bcadd( $order_arr['总计']['recharge_amount'] , $v['money'],2);
		}
		$arr = [];
		foreach($order_arr as $k => $v){
			$arr[] = $v;
		}
		return [
				'data'	=> $arr,
				'code'	=> 1,
				'msg'	=> '统计成功',
			];
	}

 	public function getFLow ($begin,$end){

		$flow = DB::table('tz_recharge_flow as a')
		->leftjoin('tz_users as b','a.user_id','=','b.id')
		->select(DB::raw('b.id as customer_id,b.name as customer_name,b.nickname,b.email,a.id as flow_id,a.recharge_amount,a.recharge_way,a.trade_no,a.voucher,a.timestamp,a.money_before,a.money_after,a.tax'))
		->whereNull('a.deleted_at')
		->where('a.trade_status',1)
		->where('a.timestamp','>',$begin)
		->where('a.timestamp','<',$end)
		->orderBy('a.timestamp','desc')
		->get();

		$flow = json_decode($flow,true);
		$mr = [];
		for ($i=0; $i < count($flow); $i++) {
			$flow[$i] = $this->trans($flow[$i]);
			if(!isset($mr[ $flow[$i]['customer_id'] ])){
				$mr[ $flow[$i]['customer_id'] ]['customer_id'] = $flow[$i]['customer_id']	;

				$business = DB::table('tz_business')
				->where('client_id',$flow[$i]['customer_id'])
				->whereIn('business_status',[1,2,4])
				->where('remove_status',0)
				->get();
				if(!$business->isEmpty()){
					for ($j=0; $j < count($business); $j++) {
						$room = json_decode($business[$j]->resource_detail);
						$mr[ $flow[$i]['customer_id'] ]['machineroom'][] = $room->machineroom_name;
					}
					$mr[ $flow[$i]['customer_id'] ]['machineroom'] = array_unique($mr[ $flow[$i]['customer_id'] ]['machineroom']);
				}else{
					$mr[ $flow[$i]['customer_id'] ]['machineroom'] = '暂无业务';
				}
			}
			if(is_array($mr[ $flow[$i]['customer_id'] ]['machineroom'])){
				$flow[$i]['machineroom'] = implode(',',$mr[ $flow[$i]['customer_id'] ]['machineroom']);
			}else{
				$flow[$i]['machineroom'] = $mr[ $flow[$i]['customer_id'] ]['machineroom'];
			}
		}
		return $flow;
 	}

	private function trans($flow){
		$recharge_way = [ 1 => '支付宝' , 2 => '微信' , 3 => '工作人员手动充值' ];

		if($flow['recharge_way'] != 3){
			$salesman_id = DB::table('tz_users')->where('id',$flow['customer_id'])->value('salesman_id');
			$flow['recharge_way'] = $recharge_way[$flow['recharge_way']].' / 自助充值';
			$flow['bank'] = $flow['recharge_way'];
		}else{
			$salesman_id = DB::table('tz_recharge_admin')->where('trade_no',$flow['trade_no'])->value('recharge_uid');
			$auditor_id = DB::table('tz_recharge_admin')->where('trade_no',$flow['trade_no'])->value('auditor_id');
			$bank_num = DB::table('tz_recharge_admin')->where('trade_no',$flow['trade_no'])->value('recharge_way');
			switch ($bank_num) {
				case '1':
					$bank = '腾正公帐(建设银行)';
					break;
				case '2':
					$bank = '腾正公帐(工商银行)';
					break;
				case '3':
					$bank = '腾正公帐(招商银行)';
					break;
				case '4':
					$bank = '腾正公帐(农业银行)';
					break;
				case '5':
					$bank = '正易公帐(中国银行)';
					break;
				case '6':
					$bank = '支付宝';
					break;
				case '7':
					$bank = '公帐支付宝';
					break;
				case '8':
					$bank = '财付通';
					break;
				case '9':
					$bank = '微信支付';
					break;
				case '10':
					$bank = '新支付宝';
					break;
				default:
					$bank = '无此支付模式';
					break;
			}
			$flow['recharge_way'] = DB::table('admin_users')->where('id',$auditor_id)->value('name').' / 审核';
			$flow['bank'] = $bank;
		}
		$flow['salesman_name'] = DB::table('admin_users')->where('id',$salesman_id)->value('name');
		$flow['customer_name'] = $flow['customer_name'] ? $flow['customer_name'] : $flow['email'];
		return $flow;
	}

	//获取充值折线图所需数据接口
	public function rechargeTwelve()
	{
		$this_month_carbon = Carbon::parse(date('Y-m').'-01 00:00:00');

		$res = [];

		for ($i=6; $i >= 1; $i--) { 

			$month_timestamp = $this_month_carbon->copy()->subMonths($i)->timestamp;
			$res[] = [
				'time'		=> date('Y-m',$month_timestamp),
				'amount'	=> $this->getRechargeByMonth(date('Ym',$month_timestamp))+0,
			];
		}

		return [
			'data'	=> $res,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	/**
	 * 统计充值额,按月
	 * @param  $month -	格式:Ym ; 例: 201909
	 * @param
	 * @return [type]              [description]
	 */
	public function getRechargeByMonth($month)
	{
		$month_begin = $month.'-01 00:00:00';
		$month_end = date('Y-m-t 23:59:59' , strtotime($month_begin));
		
		$all_recharge = $this->where('trade_status',1)
				->where('timestamp','>',$month_begin)
				->where('timestamp','<',$month_end)
				->sum('recharge_amount');

		return $all_recharge;
	}

	public function rechargeToday()
	{
		$begin = date('Y-m-d').' 00:00:00';
		$end = date('Y-m-d').' 23:59:59';

		$all_recharge = $this->where('trade_status',1)
				->where('timestamp','>',$begin)
				->where('timestamp','<',$end)
				->sum('recharge_amount');

		return $all_recharge;
	}

	public function getRechargeDetailed($month)
	{
		$month_begin = $month.'-01 00:00:00';
		$month_end = date('Y-m-t 23:59:59' , strtotime($month_begin));
		$month_day = date('t',strtotime($month_begin));
		$month_small = date('m',strtotime($month_begin));

		$arr 	= [];
		for ($j=1; $j <= $month_day; $j++) { 
			$arr[] = [
				'time'			=> $month_small .'-'.$j,
				'recharge_amount'	=> 0,
			];
		}
		$salesman_sta = $this->leftjoin('tz_users as b' , 'b.id' , '=' , 'tz_recharge_flow.user_id')
				->leftjoin('admin_users as c' , 'c.id' , '=' , 'b.salesman_id')
				->where('tz_recharge_flow.trade_status',1)
				->where('tz_recharge_flow.timestamp','>',$month_begin)
				->where('tz_recharge_flow.timestamp','<',$month_end)
				->select(DB::raw('sum(tz_recharge_flow.recharge_amount) as recharge_amount') , 'c.name')
				->groupBy('b.salesman_id')
				->get()
				->toArray();

		$flow = $this->leftjoin('tz_users as b' , 'b.id' , '=' , 'tz_recharge_flow.user_id')
				->leftjoin('admin_users as c' , 'c.id' , '=' , 'b.salesman_id')
				->where('tz_recharge_flow.trade_status',1)
				->where('tz_recharge_flow.timestamp','>',$month_begin)
				->where('tz_recharge_flow.timestamp','<',$month_end)
				->orderBy('tz_recharge_flow.timestamp','desc')
				//->get(['tz_recharge_flow.recharge_amount' , 'b.id' , 'b.salesman_id' , 'c.name'])
				->get(['tz_recharge_flow.id as flow_id' ,'tz_recharge_flow.recharge_amount', 'tz_recharge_flow.user_id as customer_id' , 'tz_recharge_flow.recharge_way'  ,'tz_recharge_flow.tax' ,'tz_recharge_flow.trade_no' , 'tz_recharge_flow.timestamp' ,'b.name as customer_name','b.email as customer_email','b.nickname as customer_nickname', 'b.salesman_id' , 'c.name as salesman_name' ])
				->toArray();

		$recharge_way = [ 1 => '支付宝' , 2 => '微信' , 3 => '工作人员手动充值' ];

		for ($i=0; $i < count($flow); $i++) { 
			if($flow[$i]['recharge_way'] != 3){	
				$flow[$i]['recharge_way'] = $recharge_way[$flow[$i]['recharge_way']].' / 自助充值';
				$flow[$i]['recharge_man'] = '用户自助';
				$flow[$i]['bank'] = $flow[$i]['recharge_way'];
			}else{
				$admin_flow = DB::table('tz_recharge_admin')
					->whereNull('deleted_at')
					->where('trade_no',$flow[$i]['trade_no'])
					->first(['auditor_id' , 'recharge_way' ,'recharge_uid']);
				
				if(!$admin_flow){
					$flow[$i]['recharge_way'] = '后台手动充值数据有误';
					$flow[$i]['bank'] = '后台手动充值数据有误';
				}else{

					switch ($admin_flow->recharge_way) {
						case '1':
							$bank = '腾正公帐(建设银行)';
							break;
						case '2':
							$bank = '腾正公帐(工商银行)';
							break;
						case '3':
							$bank = '腾正公帐(招商银行)';
							break;
						case '4':
							$bank = '腾正公帐(农业银行)';
							break;
						case '5':
							$bank = '正易公帐(中国银行)';
							break;
						case '6':
							$bank = '支付宝';
							break;
						case '7':
							$bank = '公帐支付宝';
							break;
						case '8':
							$bank = '财付通';
							break;
						case '9':
							$bank = '微信支付';
							break;
						case '10':
							$bank = '新支付宝';
							break;
						default:
							$bank = '无此支付模式';
							break;
					}
					$flow[$i]['recharge_man'] = DB::table('admin_users')->where('id',$admin_flow->recharge_uid)->value('name');
					$flow[$i]['recharge_way'] = DB::table('admin_users')->where('id',$admin_flow->auditor_id)->value('name').' / 审核';
					$flow[$i]['bank'] = $bank;
				}
			}
			$flow[$i]['customer_name'] = $flow[$i]['customer_nickname']?:$flow[$i]['customer_email']?:	$flow[$i]['customer_name']?:'客户信息有误';
			if ($flow[$i]['salesman_name'] == null) {
				$flow[$i]['salesman_name'] = '业务员信息或已删除';
			}
			$day = date('j',strtotime($flow[$i]['timestamp']));
			$arr[$day-1]['recharge_amount'] = $arr[$day-1]['recharge_amount']+$flow[$i]['recharge_amount'];
		}

		foreach ($salesman_sta as $k => $v) {
			if ($v['name'] == null) {
				$salesman_sta[$k]['name'] = '业务员信息或已删除';
			}
		}

		$brr = [
			'line'		=> $arr,
			'salesman_sta'	=> $salesman_sta,
			'flow'		=> $flow,
		];
		return $brr;
	}

}
