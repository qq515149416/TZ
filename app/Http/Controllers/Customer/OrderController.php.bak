<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Pay\AliPayController;


use App\Http\Models\Customer\Order;		//这个是订单表模型
use App\Http\Models\Customer\PayOrder;		//这个是支付订单模型,买单用
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
	public function getOrderList(Request $request)
	{
		//检测登录状态
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$type = $request->only(['resource_type','business_sn']);
		$orderModel = new Order();
		//根据id获取所属订单
		$list = $orderModel->getList($type);

		if($list == false){
			$return['msg'] 	= '无订单记录';
			$return['code'] 	= 0;
		}else{
			$return['msg'] 	= '获取成功';
			$return['code'] 	= 1;
		}

		return tz_ajax_echo($list,$return['msg'],$return['code']);
	}

	public function getOrderById(OrderRequest $request)
	{
		$par = $request->only('order_id');
		$order_id = $par['order_id'];
		$model = new Order();
		$list = $model->getOrderById($order_id);
		if($list == false){
			return tz_ajax_echo('','获取失败',0);
		}
		return tz_ajax_echo($list,'获取成功',1);
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
		// dump($info);
		$order_id = $info['order_id'];
	
		$return = $orderModel->delOrder($user_id,$order_id);

		return tz_ajax_echo($return,$return['msg'],$return['code']);
	}

	/**
	 * 获取对应业务的增加资源的订单
	 * @param  Request $request [description]
	 * @return json           返回对应的信息和状态提示及信息
	 */
	public function resourceOrders(Request $request){
		
			$data = $request->only(['business_sn','resource_type']);
			$resource = new Order();
			$resource_orders = $resource->resourceOrders($data);
			return tz_ajax_echo($resource_orders['data'],$resource_orders['msg'],$resource_orders['code']);
		
	}

	/**
	 * 进行续费操作
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	public function renewResource(Request $request){
		$renew_data = $request->only(['orders','length','order_note','business_number']);
		$renew = new Order();
		$renew_resource = $renew->renewResource($renew_data);
		return tz_ajax_echo($renew_resource['data'],$renew_resource['msg'],$renew_resource['code']);
	}

	/**
	 * 对订单进行付费
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	public function payOrderByBalance(OrderRequest $request){
		$par = $request->only(['business_sn','coupon_id']);
		$business_sn = $par['business_sn'];
		$coupon_id = $par['coupon_id'];

		$model = new PayOrder();
		$pay = $model->payOrderByBalance($business_sn,$coupon_id);
		return tz_ajax_echo($pay['data'],$pay['msg'],$pay['code']);
	}

	/**
	 * 获取该业务下的其他资源订单数据
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function allRenew(Request $request){
		$business = $request->only(['business_sn']);
		$order = new Order();
		$all_result = $order->allRenew($business);
		return tz_ajax_echo($all_result['data'],$all_result['msg'],$all_result['code']);
	}

	/**
	 * 展示之前续费新生成的订单
	 * @param  Request $request renew_order -- 续费产生的订单id组合
	 * @return [type]           [description]
	 */
	public function showRenewOrder(Request $request){
		$renew_order = $request->only(['business_sn']);//获取续费的订单id
		$biao = mb_substr($renew_order['business_sn'],0,3);
		if($biao == 'TRZ'){
			$session = session($renew_order['business_sn']);
			if(!empty($session)){
				unset($session['client_id']);
				$return['data'] = $session;
				$return['code'] = 1;
				$return['msg']  = '获取续费信息成功';
			} else {
				$return['data'] = $session;
				$return['code'] = 0;
				$return['msg']  = '无此续费信息,请确认无误';
			}
		} else {
			$show_renew = new Order();
			$return = $show_renew->showRenewOrder($renew_order);
		}
		
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 支付续费的订单
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function payRenew(Request $request){
		$pay_key = $request->only(['pay_key']);
		$pay = new Order();
		$result = $pay->payRenew($pay_key);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}


}
