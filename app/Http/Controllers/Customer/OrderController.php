<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\Order;
use App\Http\Requests\Customer\OrderRequest;
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

	/**
	 * 获取对应业务的增加资源的订单
	 * @param  Request $request [description]
	 * @return json           返回对应的信息和状态提示及信息
	 */
	public function resourceOrders(Request $request){
		if($request->isMethod('post')){
			$data = $request->only(['business_sn','resource_type']);
			$resource = new Order();
			$resource_orders = $resource->resourceOrders($data);
			return tz_ajax_echo($resource_orders['data'],$resource_orders['msg'],$resource_orders['code']);
		} else {
			return tz_ajax_echo('','无法获取资源订单信息',0);
		}
	}

	/**
	 * 对资源进行续费
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	public function renewResource(Request $request){
		if($request->isMethod('post')){
			$renew_data = $request->only(['customer_id','customer_name','business_sn','business_id','business_name','resource_type','machine_sn','resource','price','duration','end_time','order_note']);
			$renew = new Order();
			$renew_resource = $renew->renewResource($renew_data);
			return tz_ajax_echo($renew_resource,$renew_resource['msg'],$renew_resource['code']);
		} else {
			return tz_ajax_echo('','无法进行资源续费',0);
		}
	}

	/**
     * 当填完使用时长后进行到期时间计算比较，不符合不给予通过
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function endTime(Request $request){
        if($request->isMethod('post')){
            $time = $request->only('duration','business_sn');
            $end_time = new OrdersModel();
            $return = $end_time->endTime($time);
            return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
        } else {
            return tz_ajax_echo('','无法计算资源到期时间',0);
        }
    }

}
