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
		//获取查询月份
		$par = $request->only('month');
		//如无传值,则查当月
		if(isset($par['month'])){
			$month = $par['month'];
		}else{
			$month = date("Ym");
		}

		//更新统计数据
		$res = $this->pfmStatistics($month);
		if($res['code'] != 1){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}else{
			$msg = $res['msg'].',';
		}
		
		//获取统计数据
		$pfmModel = new PfmStatistics();
		$info = $pfmModel->getStatistics($month);	

		return tz_ajax_echo($info['data'],$msg.$info['msg'],$info['code']);

	}


	/**
	 * 按月份统计业务员业绩
	 * @param 	$month
	 * @return code,1为更新成功,0为失败
	 */

	public function pfmStatistics($month)
	{
		//如需单独调用此接口,放出下面的,再改下参数
		// $par = $request->only('month');
		// if(isset($par['month'])){
		// 	$month = $par['month'];
		// }else{
		// 	return tz_ajax_echo([],'参数错误!!',0);
		// }

		$pfmModel = new PfmStatistics();
		$result = $pfmModel->statistics($month);

		return $result;

	}

}
