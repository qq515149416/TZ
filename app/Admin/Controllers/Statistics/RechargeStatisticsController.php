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
		//获取查询月份
		$par = $request->only('month');
		//如无传值,则查当月
		if(isset($par['month'])){
			$month = $par['month'];
		}else{
			$month = date("Ym");
		}

		//更新统计数据
		$res = $this->rechargeStatistics($month);
		if($res['code'] == 1){
			$msg = '数据更新成功 , ';
		}else{
			$msg = '数据更新失败 , ';
		}
		
		//获取统计数据
		$rechargeModel = new RechargeStatistics();
		$info = $rechargeModel->getStatistics($month);	

		return tz_ajax_echo($info['data'],$msg.$info['msg'],$info['code']);

	}


	/**
	 * 按月份统计充值情况
	 * @param 	$month
	 * @return 	code,1为更新成功,0为失败
	 */

	public function rechargeStatistics($month)
	{

		$RechargeModel = new RechargeStatistics();
		$result = $RechargeModel->statistics($month);

		return $result;                                                                                                                                                                                                                                                      
	}

}