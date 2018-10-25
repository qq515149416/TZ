<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\Business;
use App\Http\Models\Customer\Order;
use App\Http\Requests\Customer\BusinessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Business Controller 		-业务表的前端控制器
	|--------------------------------------------------------------------------
	| Author 			kiri / 420541662@qq.com
	| --------------------------------------------------------------------------
	|
	|
	*/



	/**
	* 获取用户对应的业务实例信息
	* @return json  返回相关的数据和状态提示及信息
	*/
	public function getBusinessList()
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$businessModel = new Business();
		$list = $businessModel->getList($user_id);
		return tz_ajax_echo($list['data'],$list['msg'],$list['code']);

	}
	

}
