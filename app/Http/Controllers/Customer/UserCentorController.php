<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\UserCenter;
use App\Http\Requests\Customer\UserCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCentorController extends Controller
{

	/**
	* 修改用户的昵称
	* @return 
	*/
	public function resetNickName(UserCenterRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$par = $request->only(['nick_name']);
		$model = new UserCenter();
		$res = $model->resetNickName($user_id,$par['nick_name']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}
	
	/**
	* 修改用户的登录账号
	* @return 
	*/
	public function resetAcc(UserCenterRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$par = $request->only(['user_name']);
		$model = new UserCenter();
		$res = $model->resetAcc($user_id,$par['user_name']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);

	}
}
