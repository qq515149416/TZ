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
use App\Admin\Models\Business\BusinessModel;
use App\Admin\Models\DefenseIp\BusinessModel as DipModel;
use App\Admin\Models\DefenseIp\OverlayBelongModel;

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
		
		$machineModel = new MachineStatistics();

		$month = $request->only(['month']);
		if(isset($month['month'])){
			$month = $month['month'];
		}else{
			$month = date("y-m");
		}	

		$info = $machineModel->getStatistics($month);	

		return tz_ajax_echo($info['data'],$msg.$info['msg'],$info['code']);		
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

	/**
	* 按条件获取机器数量
	* @param  
	* @return [type]           [description]
	*/
	public function getMachineNum(){
		$model = new BusinessModel();

		$this_month_begin   = date('Y-m-01 00:00:00');
		$this_month_end     = date('Y-m-t 23:59:59');
		// $this_month_begin = '2019-05-01 00:00:00';
		// $this_month_end = '2019-05-31 23:59:59';
		$today_begin = date('Y-m-d 00:00:00');
		$today_end = date('Y-m-d 23:59:59');

		$this_month_on = $model->where(function($query) use ($this_month_begin,$this_month_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$this_month_begin)
						->where('start_time','<',$this_month_end)
						->whereIn('business_status',[0,1,3,4])
						->where('remove_status',0);
					})
					->orWhere(function($query) use ($this_month_begin,$this_month_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$this_month_begin)
						->where('start_time','<',$this_month_end)
						->where('business_status' , 2);
					})
					->count();

		$this_month_down = $model->whereIn('business_type',[1,2])
					->where('updated_at','>',$this_month_begin)
					->where('updated_at','<',$this_month_end)
					->where('remove_status','=',4)
					->whereIn('business_status',[2,5,6])
					->count();
		
		$today_on_idc = $model->where(function($query) use ($today_begin,$today_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$today_begin)
						->where('start_time','<',$today_end)
						->whereIn('business_status',[0,1,3,4])
						->where('remove_status',0);
					})
					->orWhere(function($query) use ($today_begin,$today_end){
						$query->whereIn('business_type',[1,2])
						->where('start_time','>',$today_begin)
						->where('start_time','<',$today_end)
						->where('business_status' , 2);
					})
					->count();

		$dip_model = new DipModel();
		$today_on_dip = $dip_model->where(function($query) use ($today_begin,$today_end){
						$query->where('created_at' , '>' , $today_begin)
						->where('created_at' , '<' , $today_end)
						->where('status',4);
					})
					->orWhere(function($query) use ($today_begin,$today_end){
						$query->whereIn('status',[1,2,3])
						->where('start_time' , '>' , $today_begin)
						->where('start_time' , '<' , $today_end);		
					})
					->count();

		$overlay_model = new OverlayBelongModel();
		$today_on_overlay = $overlay_model->where('buy_time' , '>' , $today_begin)
						->where('buy_time' , '<' , $today_end)
						->count();


		// $using = $model->whereIn('business_type',[1,2])
		// 		->where('remove_status',0)
		// 		->whereIn('business_status',[1,2])
		// 		->count();
		$arr = [
			'this_month_on'		=> $this_month_on,
			'this_month_down'	=> $this_month_down,
			'today_on'		=> $today_on_idc+$today_on_dip+$today_on_overlay,
		];

		return tz_ajax_echo($arr,'统计成功',1);
	}
}
