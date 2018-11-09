<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计业绩用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-06 15:47:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\PfmStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\PfmStatisticsRequest;
use Encore\Admin\Facades\Admin;




class PfmStatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @param 	$month  月份,格式date("Ym");
	* @return 	json 返回相关的信息
	*/
	public function index( PfmStatisticsRequest $request){
		
		$par = $request->only(['begin','end']);
		$pfmModel = new PfmStatistics();
		$return = $pfmModel->getStatistics($par['begin'],$par['end']);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	public function pfmSmall(PfmStatisticsRequest $request){
		$par = $request->only(['begin','end']);
		$user_id = Admin::user()->id;
		$pfmModel = new PfmStatistics();
		$return = $pfmModel->getStatisticsSmall($par['begin'],$par['end'],$user_id);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
}
