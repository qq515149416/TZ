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
		//获取查询月份订单
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


	
}
