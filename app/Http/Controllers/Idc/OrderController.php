<?php

namespace App\Http\Controllers\Idc;

use App\Http\Controllers\Controller;
use App\Http\Models\Idc\Order;
use App\Http\Requests\Idc\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Business Controller 		-订单表的前端控制器
	|--------------------------------------------------------------------------
	| Author 			kiri / 420541662@qq.com
	| --------------------------------------------------------------------------
	|
	|
	*/



	/**
	* 获取登录中用户的订单列表的接口
	* @return 该用户所有订单,
	*/
	public function getOrderList()
	{
		//检测登录状态
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		//获取登录中用户id
		$user_id = Auth::id();
		$orderModel = new Order();
		//根据id获取所属订单
		$list = $orderModel->getList($user_id);

		if($list == false){
			$return['msg'] 	= '无订单记录';
			$return['code'] 	= 0;
		}else{
			$return['msg'] 	= '获取成功';
			$return['code'] 	= 1;
		}

		return tz_ajax_echo($list,$return['msg'],$return['code']);
	}

	/**
	* 删除订单的接口
	* @return 删除结果,
	*/
	public function delOrder(OrderRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$orderModel = new Order();
		$info = $request->only('order_id');
		$order_id = $info['order_id'];
	
		$return = $orderModel->delOrder($user_id,$order_id);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	* 订单支付的接口
	* @return 支付结果,
	*/
	public function payOrderByBalance(OrderRequest $request)
	{
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();
		$orderModel = new Order();

		$info = $request->only('order_id');
		$order_id = $info['order_id'];
	
		$return = $orderModel->payOrder($user_id,$order_id);

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
}
