<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计用控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-20 15:47:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Statistics\MachineStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Admin\Requests\Statistics\StatisticsRequest;

use App\Admin\Models\Idc\MachineModel;


class StatisticsController extends Controller
{
	use ModelForm;

	// /**
	// * 查找文章表的相关信息
	// * @return json 返回相关的信息
	// */
	// public function index(){
	// 	$index = new Statistics();
	// 	$statistics = $index->index();
	// 	// dd($ips['data']);
	// 	return tz_ajax_echo($statistics['data'],$statistics['msg'],$statistics['code']);
	// }

	/**
	 * 按机房统计machine各地区使用状况并存入数据库
	 * @param 
	 * @return json             将相关的信息进行返回前台
	 */

	public function machine_statistics()
	{
		// return 123;
		$machineModel = new MachineModel();
	}
}
