<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计充值情况用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-18 11:00:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\RechargeStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\RechargeStatisticsRequest;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;



class RechargeStatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @param 	
	* @return 	json 返回相关的信息
	*/
	public function index( RechargeStatisticsRequest $request){
		//获取查询时间
		$par = $request->only(['begin' , 'end']);
		$begin = date("Y-m-d H:i:s",$par['begin']);
		$end = date("Y-m-d H:i:s",$par['end']);
		// dd($begin.'-------'.$end);
		$rechargeModel = new RechargeStatistics();

		$return = $rechargeModel->statistics($begin,$end);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

	}

	public function getFlow(RechargeStatisticsRequest $request){
		$par = $request->only(['begin','end']);
		$rechargeModel = new RechargeStatistics();

		$res = $rechargeModel->getFLow($par['begin'],$par['end']);

		return tz_ajax_echo($res,'获取成功',1);
	}

	/**
	 * 获取充值折线图所需数据接口
	 * @return [type] [description]
	 */
	public function rechargeTwelve(){
		$statistics = new RechargeStatistics();
		$result = $statistics->rechargeTwelve();
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	/**
	 * 获取充值
	 * @param  $need 	1 - 获取当日 ; 2 - 获取当月 ; 3 - 获取上月
	 * @return
	 */
	public function getRecharge(RechargeStatisticsRequest $request){
		$par = $request->only(['need']);
		$this_month = date('Y-m');
		$statistics = new RechargeStatistics();

		if ($par['need'] == 1) { // 取当日
			$result = $statistics->rechargeToday();
		}elseif ($par['need'] == 2) {// 取当月
			$result = $statistics->getRechargeByMonth($this_month);
		}elseif ($par['need'] == 3) {// 取上月
			$last_month =date('Y-m',Carbon::parse( date('Y-m-01 00:00:00') )->subMonths(1)->timestamp);
			$result = $statistics->getRechargeByMonth($last_month);
		}		

		return tz_ajax_echo($result,'获取成功',1);
	}

	/**
	 * 获取充值
	 * @param  $month 	-月份,格式:2019-08
	 * @return
	 */
	public function getRechargeDetailed(RechargeStatisticsRequest $request){
		$par = $request->only(['month']);
		$statistics = new RechargeStatistics();

		$result = $statistics->getRechargeDetailed($par['month']);
		
		return tz_ajax_echo($result,'获取成功',1);
	}
}
