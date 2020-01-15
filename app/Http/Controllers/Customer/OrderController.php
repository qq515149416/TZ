<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Pay\AliPayController;


use App\Http\Models\Customer\Order;		//这个是订单表模型
use App\Http\Models\Customer\PayOrder;		//这个是支付订单模型,买单用
use App\Http\Requests\Customer\OrderRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
		$par = $request->only(['resource_type','business_sn','status']);
		$orderModel = new Order();
		//根据id获取所属订单
		$list = $orderModel->getList($par);

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
	 * 新客户端进行续费操作
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	public function newRenewResource(Request $request){
		$renew_data = $request->only(['resource','length']);
		$rules = ['resource'=>'required','length'=>'required|integer'];
		$messages = [
			'resource.required'=>'需要续费的资源必须选择',
			'length.required'=>'续费时长必须填写,且只能为整数',
			'length.integer'=>'续费时长必须填写,且只能为整数',
		];
		$validator = Validator::make($renew_data,$rules,$messages);
		if($validator->messages()->first()){
			return tz_ajax_echo('',$validator->messages()->first(),0);
		}
		$renew = new Order();
		$renew_result = $renew->newrenewResource($renew_data);
		return tz_ajax_echo($renew_result['data'],$renew_result['msg'],$renew_result['code']);
	}

	/**
	 * 对订单进行付费
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	//以下这个是新版的方法,子梁测试请打开注释,注释掉下面同名那个
	public function payOrderByBalance(OrderRequest $request){

		$par = $request->only(['order_id','coupon_id']);
		$order_id = $par['order_id'];
		//$coupon_id = $par['coupon_id'];
		if(!is_array($order_id)){
			return tz_ajax_echo([],'订单id格式错误',0);
		}

		$model = new PayOrder();
		$pay = $model->payOrderByBalance($order_id,0);
		return tz_ajax_echo($pay['data'],$pay['msg'],$pay['code']);
	}

	// public function payOrderByBalance(OrderRequest $request){
	// 	$par = $request->only(['business_sn','coupon_id']);
	// 	$business_sn = $par['business_sn'];
	// 	$coupon_id = $par['coupon_id'];

	// 	$model = new PayOrder();
	// 	$pay = $model->payOrderByBalance($business_sn,$coupon_id);
	// 	return tz_ajax_echo($pay['data'],$pay['msg'],$pay['code']);
	// }

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
	 * 新版客户端获取业务下的资源订单
	 * @param Request $request business_id--需要获取资源订单的业务id(数组形式)
	 * @return 
	*/
	public function newAllRenew(Request $request){
		$sn_array = $request->only(['business_id']);
		if(empty($sn_array['business_id'])){
			$$result['data'] = '';
			$$result['code'] = 0;
			$$result['msg'] = '无法获取相关的资源数据';
			return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
		}
		$order_return = [];//用来接收模型返回来的数据
		$data = ['IP'=>[],'cpu'=>[],'harddisk'=>[],'memory'=>[],'bandwidth'=>[],'protected'=>[]];//用来接收最后需要的数据
		foreach ($sn_array['business_id'] as $id) {//根据业务号进行资源的获取
			$order = new Order();
			$orders = $order->newAllRenew($id);
			$order_return[] = $orders;
		}
		foreach($order_return as $value){
			//...是数组的展开操作符,表示对数组进行数据的展开(变成普通的一维数组)
			// filter参考laravel模型的集合的可用方法
			if(!$value->isEmpty()){
				$ip = $value->filter(function($val,$key){return $val['resource_type'] == 4;})->values();
				$cpu = $value->filter(function($val,$key){return $val['resource_type'] == 5;})->values();
				$harddisk = $value->filter(function($val,$key){return $val['resource_type'] == 6;})->values();
				$memory = $value->filter(function($val,$key){return $val['resource_type'] == 7;})->values();
				$bandwidth = $value->filter(function($val,$key){return $val['resource_type'] == 8;})->values();
				$protected = $value->filter(function($val,$key){return $val['resource_type'] == 9;})->values();
				if(!$ip->isEmpty()){
					array_push($data['IP'],...$ip);//ip资源集合
				}
				if(!$cpu->isEmpty()){
					array_push($data['cpu'],...$cpu);//cpu资源集合
				}
				if(!$harddisk->isEmpty()){
					array_push($data['harddisk'],...$harddisk);//硬盘资源集合
				}
				if(!$memory->isEmpty()){
					array_push($data['memory'],...$memory);//内存资源集合
				}
				if(!$bandwidth->isEmpty()){
					array_push($data['bandwidth'],...$bandwidth);//带宽资源集合
				}
				if(!$protected->isEmpty()){
					array_push($data['protected'],...$protected);//防御资源集合
				}	
					
			}
			
		}
		
		$result['data'] = $data;
		$result['code'] = 1;
		$result['msg']  = '业务下的资源信息获取成功';
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}

	// /**
	//  * 展示之前续费新生成的订单
	//  * @param  Request $request renew_order -- 续费产生的订单id组合
	//  * @return [type]           [description]
	//  */
	// public function showRenewOrder(Request $request){
	// 	$renew_order = $request->only(['business_sn']);//获取续费的订单id
	// 	$biao = mb_substr($renew_order['business_sn'],0,3);
	// 	if($biao == 'TRZ'){
	// 		$session = session($renew_order['business_sn']);
	// 		if(!empty($session)){
	// 			unset($session['client_id']);
	// 			$return['data'] = $session;
	// 			$return['code'] = 1;
	// 			$return['msg']  = '获取续费信息成功';
	// 		} else {
	// 			$return['data'] = $session;
	// 			$return['code'] = 0;
	// 			$return['msg']  = '无此续费信息,请确认无误';
	// 		}
	// 	} else {
	// 		$show_renew = new Order();
	// 		$return = $show_renew->showRenewOrder($renew_order);
	// 	}

	// 	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	// }

	// /**
	//  * 支付续费的订单
	//  * @param  Request $request [description]
	//  * @return [type]           [description]
	//  */
	// public function payRenew(Request $request){
	// 	$pay_key = $request->only(['pay_key']);
	// 	$pay = new Order();
	// 	$result = $pay->payRenew($pay_key);
	// 	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	// }

	/**
	 * 展示之前续费新生成的订单
	 * @param  Request $request renew_order -- 续费产生的订单id组合
	 * @return [type]           [description]
	 */
	public function showRenewOrder(Request $request){
		$renew_order = $request->only(['business_sn']);
		$biao = mb_substr($renew_order['business_sn'],0,3);
		$get_redis = new Order();
		if($biao == 'TRZ'){
			$redis = $get_redis->getRenewRedis($renew_order['business_sn']);
			if(!empty($redis)){
				$return['data'] = $redis;
				$return['code'] = 1;
				$return['msg']  = '获取续费信息成功';
			} else {
				$return['data'] = $redis;
				$return['code'] = 0;
				$return['msg']  = '无此续费信息,请确认无误!';
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
		$pay = $request->only(['pay_key']);
		$renew_pay = new Order();
		$pay_result = $renew_pay->payRenew($pay);
		return tz_ajax_echo($pay_result['data'],$pay_result['msg'],$pay_result['code']);
	}

	/**
	 * 客户端查看支付流水
	 * @return [type] [description]
	 */
	public function flows(){
		$flow = new Order();
		$result = $flow->flows();
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}


}
