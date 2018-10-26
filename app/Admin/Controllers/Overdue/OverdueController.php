<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 客户管理的控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-31 14:20:56
// +----------------------------------------------------------------------

namespace App\Admin\Controllers\Overdue;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Overdue\Overdue;
use App\Admin\Requests\Overdue\OverdueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Encore\Admin\Facades\Admin;


class OverdueController extends Controller
{
	/**
	* 查找5天内到期或过期未续费的机柜,提醒时间可在模型类里$overtime设置
	* @return json 返回相关的信息
	*/
	public function showOverdueCabinet(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showOverdueCabinet();
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查找5天内到期或过期未续费的租用主机,提醒时间可在模型类里$overtime设置
	* @return json 返回相关的信息
	*/
	public function showOverdueMachine(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showOverdueMachine();
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	

	
	
	/**
	* 查找未付款使用中主机
	* @return json 返回相关的信息
	*/
	public function showUnpaidMachine(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showUnpaidMachine();
	
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查找最近下架主机
	* @return json 返回相关的信息
	*/
	public function showXiaJiaMachine(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showXiaJiaMachine();
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查找未付款使用中机柜
	* @return json 返回相关的信息
	*/
	public function showUnpaidCabinet(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showUnpaidCabinet();
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	* 查找5天内到期或过期未续费的资源,提醒时间可在模型类里$overtime设置
	* @return json 返回相关的信息
	*/
	public function showOverdueRes(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showOverdueRes('overdue');
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查找最近下架资源
	* @return json 返回相关的信息
	*/
	public function showXiaJiaRes(){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$res = $customerModel->showOverdueRes('xiajia');
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查找5天内到期或过期未续费的资源详细类型
	* @return json 返回相关的信息
	*/
	public function showOverdueResDet(OverdueRequest $request){
		//设置时区
		date_default_timezone_set('PRC');
		$customerModel = new Overdue();
		$info = $request->only(['resource_type']);
		$resource_type = $info['resource_type'];
		$res = $customerModel->showOverdueRes('overdue',$resource_type);
	
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
