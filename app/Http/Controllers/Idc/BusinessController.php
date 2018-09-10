<?php

namespace App\Http\Controllers\Idc;

use App\Http\Controllers\Controller;
use App\Http\Models\Idc\Business;
use App\Http\Models\Idc\Order;
use App\Http\Requests\Idc\BusinessRequest;
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

	/**
	 * 进行主机及机柜续费操作
	 * @param  Request $request [description]
	 * @return json           返回相关的状态提示及信息
	 */
	public function renewOrders(Request $request){
		if($request->isMethod('post')){
			$data = $request->only(['id','client_id','client_name','sales_id','slaes_name','business_number','machine_number','resource_detail','money','length','endding_time','order_note','order_type','business_type']);
			$renew = new Order();
			$result = $renew->renewOrders($data);
			return tz_ajax_echo($result,$result['msg'],$result['code']);
		} else {
			return tz_ajax_echo('','无法进行续费',0);
		}
	}


	

}
