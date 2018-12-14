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




class RechargeStatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @param 	$month  月份,格式date("Ym");
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



}
