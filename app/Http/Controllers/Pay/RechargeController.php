<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 不知道啥
// +----------------------------------------------------------------------
// | Description: 支付宝充值支付控制器
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Pay\AliPayController;
use App\Http\Models\Pay\AliRecharge;
use App\Http\Controllers\Pay\WechatPayController;
use App\Http\Models\Pay\WechatPay;

use App\Http\Requests\Pay\RechargeRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class RechargeController extends Controller
{

	/**
	*生成支付宝付款订单的页面
	*@param 	$total_amount	订单金额
	*@return 创建订单的id
 	**/

	public function index(RechargeRequest $request)
	{
		//获取充值金额
		$info = $request->only(['total_amount']);

		//获取登录中用户id
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		//生成订单参数
		//再生成订单

		$model = new AliRecharge();
		//我们的trade_no对于支付宝来说就是 out_trade_no
		$data['trade_no'] 		= 'tz_'.time().'_'.substr(md5($user_id.'tz'),0,4);	//本地订单号,需保证不重复
		$data['recharge_amount']	= $info['total_amount'];		//订单总金额，单位为元，精确到小数点后两位
		$data['user_id']			= $user_id;
		$data['recharge_way']		= 1;
		$data['trade_status']		= 0;
		//$data['product_code']		=  'FAST_INSTANT_TRADE_PAY';	//销售产品码，与支付宝签约的产品码名称。 注：目前仅支持FAST_INSTANT_TRADE_PAY
		$makeOrder = $model->makeOrder($data);

		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	*微信支付充值的方接口,集合两个过程的接口,请求之后会先去生成一个充值单,失败的话会返回失败信息,成功则会去请求微信接口,将刚生成的订单发送过去,然后返回生成二维码的url
	*@param 	$total_amount	订单金额
	*@return 	data{ url - 二维码url 	; flow_id - 生成的订单id }
 	**/

	public function rechargeByWechat(RechargeRequest $request)
	{
		//获取充值金额
		$info = $request->only(['total_amount']);

		//获取登录中用户id
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		//生成订单
		$makeOrder = $this->makeRechargeOrder($info['total_amount'],$user_id);

		if ($makeOrder['code'] != 1) {	//生成订单失败的话,就返回错误信息
			return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
		}

		//生成完订单,就去获取二维码链接
		$getUrl = $this->getWechatUrl($makeOrder['data']);

		$data = [
			'url'	=> $getUrl['data'],
			'flow_id'	=> $makeOrder['data'],
		];
		return tz_ajax_echo($data,$getUrl['msg'],$getUrl['code']);

		// return view('test',[ 'url' => $data['url']]);
	}

	//生成微信支付充值的订单
	protected function makeRechargeOrder($total_amount , $user_id)
	{
		$model = new WechatPay();
		$makeOrder = $model->makeRechargeOrder($total_amount,$user_id);
		return $makeOrder;
	}

	/**
	* 接口,用充值单的id获取支付二维码url的接口
	*这个接口会先去请求一遍微信接口,查询订单的支付状态,如果已经支付了,他会自动做数据处理,如果处理有什么问题也会返回错误信息,如果没支付,就会去请求微信接口,获取二维码url,code是1时就返回二维码url,注意,订单的充值方式不是微信的获取不了
	*@param 	$flow_id 	充值订单号的id
	*@return 	code 	0-获取失败 	1-获取成功 	2-已付款,无需获取二维码
	*/
	public function getWechatUrlOut(RechargeRequest $request){
		$par = $request->only(['flow_id']);
		//获取订单信息
		$model 	= new WechatPay();
		$get_flow_res 	= $model->getFlow($par['flow_id']);
		if( $get_flow_res['code'] == 0){
			return tz_ajax_echo([],'获取订单信息失败',0);
		}
		if ($get_flow_res['data']['recharge_way'] != 2 ) {
			return tz_ajax_echo([],'该订单支付方式不是微信',0);
		}
		//先检测一遍订单的支付状态,已支付的话会处理数据
		$check = $this->WechatCheckAndInsert($get_flow_res['data']['trade_no']);
		//dd($check);
		if ($check['code'] != 0) {		//表示已付款,无需获取二维码,返回错误信息,除了0,都是付过款了的
			return tz_ajax_echo($check['data'],$check['msg'],2);	//有问题,统一返回code2
		}

		//获取url
		$res = $this->getWechatUrl($par['flow_id']);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		//return view('test',[ 'url' => $res['data']]);
	}

	//获取微信支付充值的二维码地址
	protected function getWechatUrl($flow_id)
	{
		$wechat = new WechatPayController();
		$res = $wechat->getWechatUrl($flow_id);
		return $res;
	}


	/**
	* 跳转支付页面方法
	*@param 	$trade_id 	充值订单号的id
	*		$way 		支付途径:	web代表直接跳转
	*						scan代表获取二维码
	*/
	public function goToPay(RechargeRequest $request)
	{
		//检查登录状态
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		//获取用户id
		$user_id = Auth::id();

		//获取订单id和需要的支付方式
		$info		= $request->only(['trade_id','way']);

		$trade_id 	= $info['trade_id'];
		$way 		= $info['way'];
		//获取订单的信息
		$model 	= new AliRecharge();
		$res 		= $model->makePay($trade_id,$user_id);

		if($res['code'] != 1){
			return redirect('/tz/?uphash=0#/rechargeRecord')
    				->withErrors([$res['msg']]);
			// return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}
		//根据订单信息拼出支付宝方的接口所需信息
		$info = json_decode(json_encode($res['data']),true);
		$created_at = strtotime($info['created_at']);
		$end_time = $created_at+7200;
		$timeout_express = $end_time-time();
		$m = bcsub(bcdiv($timeout_express,'60'),1);
		$m = "{$m}m";

		//实例化阿里支付控制器
		$Pay = new AliPayController();
		// $check_order = [
		// 	'out_trade_no' 		=> $info['trade_no'],
		// 	'refund_amount'	=> $info['recharge_amount'],	
		// ];
		
		$check = $Pay->check2($info['trade_no']);
		//交易不存在 ,40004
		
		
		// // $refund = $Pay->cancel($check_order);
		if($check['code'] != '40004'){
			$check_res = $this->AliCheckAndInsert($info['trade_no']);
			if ($check_res['code'] != 0) {
				return redirect('/tz/?uphash=0#/rechargeRecord')
    				->withErrors([$check_res['msg']]);
			}
		}

		//阿里接口的传值
		$order = [
			'out_trade_no' 		=> $info['trade_no'],		//本地订单号
			'total_amount' 		=> $info['recharge_amount'],	//金额
			'subject' 		=> '余额充值',			//商品名称
			'timeout_express'	=> $m,
			//该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。该参数在请求到支付宝时开始计时。
			'product_code'		=> 'FAST_INSTANT_TRADE_PAY',	//销售产品码，与支付宝签约的产品码名称。 注：目前仅支持FAST_INSTANT_TRADE_PAY

			// 'auth_token'		=> 'XXXXXX',			//获取用户授权信息，可实现如免登功能。
		];

		//生成支付宝跳转及ajax链接
		$returnUrl	= config('ali_pay.tz_url').'/home/recharge/payRechargeReturn';
		$notifyUrl 	= config('ali_pay.tz_url').'/home/recharge/payRechargeNotify';
		//$notifyUrl 	= 'http://tz.jungor.cn/home/recharge/payRechargeNotify';

		//生成支付宝链接
		$alipay = $Pay->goToPay($order,$way,$returnUrl,$notifyUrl);
		
		//跳转到支付宝链接或返回结果
		return $alipay;// laravel 框架中请直接 `return $alipay`
	}


	public function delOrder(RechargeRequest $request)
	{
		//获取登录中用户id
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		//获取删除的id
		$info 		= $request->only(['del_trade_id']);
		$trade_id 	= $info['del_trade_id'];
		//验证该订单是否可以删除
		$model 	= new AliRecharge();
		$order 		= $model->checkOrder($trade_id,3);
		if($order['code'] != 1){
			return tz_ajax_echo($order['data'],$order['msg'],$order['code']);
		}

		$order = json_decode($order['data'],true);
		$trade_no = $order['trade_no'];
		//查询订单的支付情况并根据回信处理数据
		$check = $this->AliCheckAndInsert($trade_no);
		if($check['code'] != 1 && $check['code'] != 0){
			return tz_ajax_echo('',$check['msg'].'订单状态异常,暂时无法删除',0);
		}
		//验证
		$check_user_id = $order['user_id'];
		if($user_id != $check_user_id){
			return tz_ajax_echo('','该订单不属于您,无法删除',0);
		}

		$return['data']	= '';
		//验证没问题才删掉
		$del = $model->delOrder($trade_id);

		if($del == true){
			$return['msg']='删除订单成功';
			$return['code'] = 1;
		}else{
			$return['msg']='删除订单失败';
			$return['code'] = 0;
		}

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	// /**
	// * 退款的跳转页面
	// *@param $trade_id 	充值订单号的id
	// */
	// public function refund(Request $request)
	// {
	// 	$info		= $request->only(['trade_id']);
	// 	$trade_id 	= $info['trade_id'];

	// 	$model 	= new AliRecharge();
	// 	$res 		= $model->checkOrder($trade_id,3);
	// 	$info = json_decode(json_encode($res['data'][0]),true);
	// 	if($info['trade_status'] != 1){
	// 		return tz_ajax_echo('','该订单尚未付款成功',0);
	// 	}

	// 	$order = [
	// 		'trade_no'		=> $info['voucher'],
	// 		'refund_amount' 	=> $info['recharge_amount'],	//金额
	// 	];

	// 	//生成支付宝链接
	// 	$alipay = Pay::alipay($this->config)->refund($order);

	// 	//跳转到支付宝链接
	// 	return $alipay;// laravel 框架中请直接 `return $alipay`
	// }






	/**
	* 查询登录中用户的所有充值单的接口
	*
	* @return 订单信息,
	*/
	public function getOrderByUser(){
		// date_default_timezone_set('PRC');
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		$model 	= new AliRecharge();
		$res 		= $model->checkOrder($user_id,4);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 查询指定充值单的接口
	*@param $trade_no 	充值订单号
	* @return 订单信息,
	*/
	public function getOrder(RechargeRequest $request){

		$info 		= $request->only(['trade_no']);
		$trade_no 	= $info['trade_no'];
		$model 	= new AliRecharge();
		$res 		= $model->checkOrder($trade_no,1);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	/**
	* 查询指定充值单支付情况的接口
	*@param $trade_no 	充值订单号
	* @return 订单的支付情况,
	*/
	public function checkRechargeOrder(RechargeRequest $request){

		$info 		= $request->only(['trade_no']);
		$trade_no 	= $info['trade_no'];
		//获取订单信息
		$get_flow_res 	= WechatPay::where('trade_no',$trade_no)->first();

		if( $get_flow_res == null){
			return tz_ajax_echo([],'获取订单信息失败',0);
		}
		$get_flow_res = $get_flow_res->toArray();

		// if ($get_flow_res['trade_status'] != 0) {
		// 	return tz_ajax_echo([],'订单已交易完毕',1);
		// }

		if ($get_flow_res['recharge_way'] == 1) {	//如果是支付宝支付
			$return = $this->AliCheckAndInsert($trade_no);
		}elseif ($get_flow_res['recharge_way'] == 2) {	//如果是微信
			$return = $this->WechatCheckAndInsert($trade_no);
		}

		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}




	//用户支付完成后的跳转处理页面
	public function AliRechargeReturn()
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
		$trade_no 			= $data->out_trade_no;	//本地订单
		$res = $this->AliCheckAndInsert($trade_no);
		//跳转确认页面
		$domain_name = config('ali_pay.tz_url');
		return redirect("{$domain_name}/auth/pay.html?order=".$trade_no);
	}


	//支付宝用的ajax通知接收的方法,中间件处有屏蔽此接收方法的csrf

	public function AliRechargeNotify()
	{
		//验签
		$PayController = new AliPayController();
		$res = $PayController->checkByAjax();
		//成功就更新数据库信息
		if($res['code'] == 1){
			$data = $res['data'];
			$info['trade_no'] 		= $data->out_trade_no;
			//调用查询接口
			$insert = $this->AliCheckAndInsert($info['trade_no']);
			if($insert['code'] != 1){
				$res['msg'] = '储存失败';
			}
		}
		return $res['msg'];
	}


	/**
	*核心方法 , 请求微信接口查询订单是否支付,并根据结果进行数据处理
	*@param $trade_no -订单号
	*充值后无论啥回调方法都要经过这个方法,比较稳,直接向支付宝查询
	*return 	code 	-0 : 未付款
	*			-1 : 已付款并且数据处理成功
	*			-2 : 已付款但付款信息有问题
	*/
	protected function WechatCheckAndInsert($trade_no){
		$wechat_controller = new WechatPayController();
		$res = $wechat_controller->checkOrder($trade_no);	//直接向微信查询订单支付状态
		//此方法返回code
		//0-未付款	1-付过款并且信息没问题,尚未发货 	2-付过款了并且信息没问题,已经发货了 	3-付过款,信息有问题,尚未发货,需要工作人员处理
		//4-付款状态异常,需重新下单
		//0和2不用操作,直接返回结果 , 3要工作人员处理 , 1要进行数据处理,把余额进账
		if($res['code'] == 3){	//就是要退款了
			return [
				'data'	=> [],
				'code'	=> 2,
				'msg'	=> $res['msg'].'请联系工作人员',
			];

		}elseif ($res['code'] == 2) {
			return [
				'data'	=> [],
				'code'	=> 1,
				'msg'	=> '此订单已交易成功',
			];
		}elseif ($res['code'] != 1) {
			return [
				'data'	=> $res['data'],
				'code'	=> $res['code'],
				'msg'	=> $res['msg'],
			];
		}

		$recharge_res = $wechat_controller->rechargePaySuccess($res['data']);
		return $recharge_res;
	}

	/**
	*核心方法 , 请求支付宝接口查询订单是否支付,并根据结果进行数据处理
	*
	*充值后无论啥回调方法都要经过这个方法,比较稳,直接向支付宝查询
	*return 	code 	-0 : 未付款
	*			-1 : 已付款并且数据处理成功
	*			-2 : 已付款但需要退款
	*/
	protected function AliCheckAndInsert($trade_no){
		//用阿里控制器的方法,查询下订单号的支付状况
		$PayController = new AliPayController();
		//dd($trade_no);
		$res = $PayController->check($trade_no);
		
		//TRADE_SUCCESS表示支付成功 , TRADE_FINISHED 表示订单已交易结束
		if($res->trade_status != 'TRADE_SUCCESS'&&$res->trade_status != 'TRADE_FINISHED'){	//如果未付款,直接返回未付款
			return [
				'data'	=> '',
				'code'	=> 0,
				'msg'	=> '用户尚未付款',
			];
		}else{		//如果已付款,做数据处理
			$return = [
				'data'	=> '',
				'msg'	=> '用户已付款',
			];
		}
		//用返回来的数据,组成数组传值,
		$model 			= new AliRecharge();

		$info['trade_no'] 		= $trade_no;	//本地订单
		$info['voucher']			= $res->trade_no;
		$info['recharge_amount']	= $res->total_amount;
		$info['timestamp']		= $res->send_pay_date;
		$info['recharge_way']		= 1;

		//更新数据库信息
		$update = $model->returnInsert($info);

		$return['msg'] = $return['msg'].','.$update['msg'];
		$return['code'] = $update['code'];

		if($update['code'] == 2){	//如果已经由别的支付方式支付过了,退款
			$cancel = $PayController->cancel($serial_number);
			if($cancel->code == '10000'){
				$return['msg'].= '如已付款,款项会原路返回';
			}else{
				$return['msg'].= '如已付款,请联系工作人员';
			}
		}

		return $return;
	}

}
