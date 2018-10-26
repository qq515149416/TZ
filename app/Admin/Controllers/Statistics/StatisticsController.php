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




class StatisticsController extends Controller
{
	use ModelForm;

	/**
	* 查找统计表的相关信息
	* @return json 返回相关的信息
	*/
	public function index( StatisticsRequest $request){
		$res = $this->machineStatistics();
		if($res == 1){
			$msg = '数据更新成功 , ';
		}else{
			$msg = '数据更新失败 , ';
		}
		if($request->isMethod('post')) {
			$machineModel = new MachineStatistics();

			$month = $request->only(['month']);
			if(isset($month['month'])){
				$month = $month['month'];
			}else{
				$month = date("y-m");
			}	

			$info = $machineModel->getStatistics($month);	

			return tz_ajax_echo($info['data'],$msg.$info['msg'],$info['code']);
		}else{
			return tz_ajax_echo([],$msg.'信息获取失败!!',0);
		}
	}

	/**
	 * 按机房统计machine各地区使用状况并存入或更新数据库,按月份区分
	 * @param 
	 * @return code,1为更新成功,0为失败
	 */

	public function machineStatistics()
	{

		$machineModel = new MachineStatistics();

		$result = $machineModel->statistics();
		
		return $result['code'];

	}
}
