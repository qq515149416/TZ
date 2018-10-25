<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Pay\AliPayController;


use App\Http\Models\Customer\Order;		//这个是订单表模型,相当于加入购物车
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

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	* 订单支付的接口
	* @return 支付结果,
	*/
	public function payTradeByBalance(OrderRequest $request)
	{	
		$orderModel = new PayOrder();
		$info = $request->only('serial_number');
		$serial_number = $info['serial_number'];
		$user_id = Auth::id();
	
		$return = $orderModel->payTradeByBalance($user_id,$serial_number);
		
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 根据登录账号获取所有支付流水号
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return 支付订单号
	 */
	public function showTrade(){
		$user_id = Auth::id();
		$orderModel = new PayOrder();
		$order = $orderModel->showTrade($user_id,'all');
		return tz_ajax_echo($order['data'],$order['msg'],$order['code']);
	}

	/**
	 * 根据登录账号获取未支付的支付流水号
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return 支付订单号
	 */
	public function showUnpaidTrade(){
		$user_id = Auth::id();
		$orderModel = new PayOrder();
		$order = $orderModel->showTrade($user_id,'unpaid');
		return tz_ajax_echo($order['data'],$order['msg'],$order['code']);
	}

	/**
	 * 根据传入支付流水号获取该支付流水号信息
	 * @param  $serial_number
	 * @return 支付订单号
	 */
	public function showSelectTrade(OrderRequest $request){
		$user_id = Auth::id();
		$orderModel = new PayOrder();
		$info = $request->only(['serial_number']);
		$serial_number = $info['serial_number'];

		$order = $orderModel->showTrade($serial_number,'serial_number',$user_id);
		return tz_ajax_echo($order['data'],$order['msg'],$order['code']);
	}

	/**
	 * 通过传入id生成支付订单接口
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return 支付订单号
	 */
	public function makeTrade(OrderRequest $request)
	{
		$arr = $request->only(['order_id','coupon_id']);

		$order_id = $arr['order_id'];
		$coupon_id = $arr['coupon_id'];
		$user_id = Auth::id();
		
		$payModel = new PayOrder();
		$makeOrder = $payModel->makeTrade($order_id,$coupon_id,$user_id);
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	 * 预留的检测优惠券是否可用方法
	 * @param  $order_id[]		-订单id的数组; $coupon_id	-优惠券id
	 * @return true/false
	 */
	public function checkCoupon(OrderRequest $request){

		$orderModel = new Order();
		$arr = $request->only(['order_id','coupon_id']);
		$order_id = $arr['order_id'];
		$coupon_id = $arr['coupon_id'];

		$check = $orderModel->checkCoupon($order_id,$coupon_id);
		$return['data'] = '';
		if($check != true){
			$return['code'] = 0;
			$return['msg'] = '不可用';
		}else{
			$return['code'] = 1;
			$return['msg'] = '可用';
		}
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);

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
	 * 对资源进行续费
	 * @param  Request $request [description]
	 * @return json           续费的反馈信息和提示
	 */
	public function renewResource(Request $request){
		
			$renew_data = $request->only(['business_number','order_sn','price','length','order_note','resource_type']);
			$renew = new Order();
			$renew_resource = $renew->renewResource($renew_data);
			return tz_ajax_echo($renew_resource,$renew_resource['msg'],$renew_resource['code']);
		
	}

	public function checkTrade(OrderRequest $request){
		$info = $request->only(['serial_number']);
		$serial_number = $info['serial_number'];
		
		$model = new PayOrder();
		$check = $model->checkPayStatus($serial_number);
		if($check == NULL){
			return tz_ajax_echo('','查找不到该支付流水号',0);
		}
		$return['data'] = $check;
		if($check['pay_status'] != 1){
			$ali = $this->checkAliPayAndInsert($serial_number);
			
			if($ali['code'] != 0){
				$return['data'] = $model->checkPayStatus($serial_number);
				$return['msg'] = $ali['msg'];
				$return['code'] = $ali['code'];
			}else{
				//还有别的支付方式往这加
				$return['msg'] = '尚未支付';
				$return['code']	= 0;	
			}	
		}else{
			$return['msg'] = '支付成功';
			$return['code'] = 1;
		}
		
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}
	/**
	 * 取消支付流水订单
	 * @param  Request 	$
	 * @return json           续费的反馈信息和提示
	 */
	public function delTrade(OrderRequest $request){
		
		$info = $request->only(['serial_number']);
		$serial_number = $info['serial_number'];
		$return['data'] = '';
		$return['code'] = 0;
		$model = new PayOrder();
		$check = $model->checkPayStatus($serial_number);
		if($check == NULL){
			return tz_ajax_echo('','查找不到该支付流水号',0);
		}
		if($check['pay_status'] != 1){
			$ali = $this->checkAliPayAndInsert($serial_number);
			if($ali['code'] != 0 && $ali['code'] != 1){
				$return['msg'] = '订单状态异常,暂时无法删除';
				return $return;
			}
		}
		$del = $model->delTrade($serial_number);
		if($del == true){
			$return['msg']='删除订单成功';
			$return['code'] = 1;
		}else{
			$return['msg']='删除订单失败';
		}
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}


	/****以下为支付宝接口****/


	/**
	* 订单支付宝支付的接口
	* @return 支付结果,
	*/
	public function payTradeByAli(OrderRequest $request){
		if(!Auth::check()){
			return tz_ajax_echo('','请先登录',0);
		}
		$user_id = Auth::id();

		$info 		= $request->only(['serial_number','way']);
		$serial_number 	= $info['serial_number'];
		$way 		= $info['way'];

		$orderModel = new PayOrder();
		$res = $orderModel->makePay($serial_number,$user_id);
		if($res['code'] != 1){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}

		$Pay = new AliPayController();
		$order = [
			'out_trade_no' 		=> $serial_number,			//本地订单号
			'total_amount' 		=> $res['data']['actual_payment'],	//金额
			'subject' 		=> $res['data']['subject'],		//商品名称
			'timeout_express'	=> '1c',	
			//该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。该参数在请求到支付宝时开始计时。			
			'product_code'		=> 'FAST_INSTANT_TRADE_PAY',	//销售产品码，与支付宝签约的产品码名称。 注：目前仅支持FAST_INSTANT_TRADE_PAY

			// 'auth_token'		=> 'XXXXXX',			//获取用户授权信息，可实现如免登功能。
		];
	
		//生成支付宝跳转及ajax链接
		$returnUrl	= env('APP_URL').'/home/customer/aliReturn';
		$notifyUrl 	= env('APP_URL').'/home/customer/aliNotify';
		//$notifyUrl 	= 'http://tz.jungor.cn/home/recharge/payRechargeNotify';

		//生成支付宝链接
		$alipay = $Pay->goToPay($order,$way,$returnUrl,$notifyUrl);
		
		//跳转到支付宝链接或返回结果
		return $alipay;// laravel 框架中请直接 `return $alipay`
	}

	//用户支付完成后的跳转处理页面
	public function aliReturn()
	{
		//实例化阿里支付控制器
		$PayController = new AliPayController();
		//获取验签结果
		$return = $PayController->checkByReturn(); 
		//失败就返回失败结果
		if($return['code'] == 0){
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
		}
		//成功就获取订单参数
		$data = $return['data'];
		$serial_number = $data->out_trade_no;	//本地订单

		$res = $this->checkAliPayAndInsert($serial_number);
		//跳转确认页面
		$domain_name = env('APP_URL');
		return redirect("{$domain_name}/auth/pay.html?serial_number=".$serial_number);
	}

	public function aliNotify()
	{
		//验签
		$PayController = new AliPayController();
		$res = $PayController->checkByAjax();
		//成功就更新数据库信息
		if($res['code'] == 1){
			$data = $res['data'];	
			$info['serial_number'] 		= $data->out_trade_no;

			$insert = $this->checkAliPayAndInsert($info['serial_number']);
			if($insert['code'] != 1){
				$res['msg'] = '储存失败';
			}
		}	
		return $res['msg'];					
	}

	

	public function checkAliPayAndInsert($serial_number){
		
		//实例化模型,询问支付宝该流水号是否买单
		$PayController = new AliPayController();
		$res = $PayController->check($serial_number);
		//判断支付状态,未支付就直接返回未支付,已支付就继续往下走
		if($res->trade_status != 'TRADE_SUCCESS'&&$res->trade_status != 'TRADE_FINISHED'){
			return [
				'data'	=> '',
				'code'	=> 0,
				'msg'	=> '用户尚未付款',
			];
		}else{
			$return = [
				'msg'	=> '用户已付款',
			];
		}	

		$model 	= new PayOrder();

		//根据支付宝参数获取支付信息
		$info['serial_number'] 		= $serial_number;			//支付流水
		$info['voucher']			= $res->trade_no;			//支付宝凭证
		$info['pay_time']		= $res->send_pay_date;			//支付宝支付时间
		$info['pay_type']		= 2;					//支付宝对应支付类型
		$info['total_amount']		= $res->total_amount;			//支付宝收到金额
	
		$checkAndInsert 		= $model->checkAliPayAndInsert($info);

		$return['msg'] 	= $return['msg'].$checkAndInsert['msg'];
		$return['code']	= $checkAndInsert['code'];
		$return['data'] = $checkAndInsert['data'];
		if($checkAndInsert['code'] == 2){
			$res = $PayController->cancel($serial_number);
			if($res->code == '10000'){
				$return['msg'].= '如已付款,款项会原路返回';
			}
		}

		return $return;
	}
	/****支付宝接口结束****/

}
