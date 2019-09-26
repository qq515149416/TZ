<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\Api;
use App\Http\Requests\Customer\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

	/**
	* 申请api权限
	* @return 
	*/
	public function apiApply(ApiRequest $request)
	{

		$model = new Api();
		$res = $model->apiApply();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}

	/**
	* 展示登录中用户的申请
	* @return 
	*/
	public function show(ApiRequest $request)
	{

		$model = new Api();
		$res = $model->show();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}

	/**
	* 展示登录中用户的api_key和secret
	* @return 
	*/
	public function showKey(ApiRequest $request)
	{
		
		$model = new Api();
		$res = $model->showKey();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}

	/**
	* 已开通api用户查看可购买的高防ip套餐
	* @return 
	*/
	public function showDIPPackage(ApiRequest $request)
	{
		
		$model = new Api();
		$res = $model->showDIPPackage();

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}
}
