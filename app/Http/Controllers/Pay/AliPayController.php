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

use App\Http\Models\Pay\AliRecharge;
use App\Http\Requests\Pay\AliPayRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

use Illuminate\Support\Facades\Auth;

class AliPayController extends Controller
{
	protected $seller_id = '';
	protected $config = [
		'app_id' => '',
		'notify_url' => 'http://tz.jungor.cn/home/payRechargeNotify',
		// 'return_url' => 'http://tz.jungor.cn/home/payRechargeReturn',
		'return_url' => 'http://localhost/home/payRechargeReturn',
		'ali_public_key' => '',
		// 加密方式： **RSA2**  
		'private_key' => '',
		'log' => [ // optional
			'file' => './logs/alipay.log',
			'level' => 'debug'
			// 'type' => 'single', // optional, 可选 daily.
   //          			'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
		],
		'mode' => 'dev', // optional,设置此参数，将进入沙箱模式

	];

	/**
	*生成支付宝付款订单的页面
	*@param 	$pay_for 	用于确认付款用途,1为充值
			$total_amount	订单金额
			$subject 	商品名称
			$trade_no 	本地订单号

	*@return 创建订单的id
 	**/
 	
 	public function __construct()
 	{
 		$this->seller_id			= env('SELLER_ID');
 		$this->config['private_key'] 	= env('ALI_PRIVATE_KEY');
 		$this->config['ali_public_key'] 	= env('ALI_PUBLIC_KEY');
 		$this->config['app_id'] 		= env('ALI_APP_ID');
 	}

	public function index(AliPayRequest $request)
	{
		//获取支付信息
		$info = $request->only(['pay_for', 'total_amount']);   
		//这里对接要改,获取user_id 

		
		//实际获取
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		//生成订单参数
		$order = [
			'out_trade_no' 	=> 'tz_'.time().'_'.$user_id,	//本地订单号
			'total_amount' 	=> $info['total_amount'],	//金额
			'subject' 	=> '充值',			//商品名称
		];

		//根据支付信息生成支付宝的调回地址及异步通知地址
		//再顺便生成订单
		switch ($info['pay_for'])
		{
			case 1:
				
				$model = new AliRecharge();
				$data['trade_no'] 		= $order['out_trade_no'];
				$data['recharge_amount']	= $order['total_amount'];
				$data['user_id']			= $user_id;
				$data['recharge_way']		= '支付宝';
				$data['trade_status']		= 0;

				$makeOrder = $model->makeOrder($data);
			
				break;

			default:
				$makeOrder = [
					'data'	=> '',
					'msg'	=> '请提供付款用途',
					'code'	=> 0,
				];
		}
		
		return $makeOrder;
		
	}

	/**
	* 跳转支付页面方法
	*@param $trade_id 	充值订单号的id
	*/
	public function goToPay(Request $request)
	{
		
		//实际获取
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		$info		= $request->only(['trade_id','way']);
		if(!isset($info['trade_id']) || !isset($info['way'])  ){
			return tz_ajax_echo('','请提供完整信息',0); 
		}
		$trade_id 	= $info['trade_id'];
		$way 		= $info['way'];
		
		$model 	= new AliRecharge();
		$res 		= $model->makePay($trade_id,$user_id);
		if($res['code'] == 0||$res['code'] == 3){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}
		

		$info = json_decode(json_encode($res['data']),true);

		if($res['code'] == 2){
			$cancel =  Pay::alipay($this->config)->cancel($info['trade_no']);
			if($cancel->code == '10000'){
				$del = $model->delOrder($trade_id);
				if($del == true){
					$res['msg'].=',删除订单成功';
				}else{
					$res['msg'].=',删除订单失败';
				}
			}
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}

		$order = [
			'out_trade_no' 		=> $info['trade_no'],		//本地订单号
			'total_amount' 		=> $info['recharge_amount'],	//金额
			'subject' 		=> $info['subject'],		//商品名称
			'timeout_express'	=> '5m',
		];
		//生成支付宝链接

		switch ($way) {
			case 'web':
				$alipay = Pay::alipay($this->config)->web($order);
				break;		
			case 'scan':
				$alipay = Pay::alipay($this->config)->scan($order);
				break;
			default:
				return tz_ajax_echo('','请选择正确的支付方式',0); 
		}
		
		//跳转到支付宝链接
		return $alipay;// laravel 框架中请直接 `return $alipay`
	}

	public function delOrder(Request $request)
	{
		//实际获取
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		$info = $request->only(['del_trade_id']);
		if( !isset($info['del_trade_id']) ){
			return tz_ajax_echo('','请提供完整信息',0); 
		}
		$trade_id = $info['del_trade_id'];

		$model 	= new AliRecharge();
		$res 		= $model->makePay($trade_id,$user_id);
		
		if($res['code'] == 0||$res['code'] == 3){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}
		
		$info = json_decode(json_encode($res['data']),true);

		$cancel =  Pay::alipay($this->config)->cancel($info['trade_no']);	

		$return['data']	= '';
		if($cancel->code == '10000'){
			$return['msg']	= '取消订单成功';

			$del = $model->delOrder($trade_id);

			if($del == true){
				$return['msg'].=',删除订单成功';
				$return['code'] = 1;
			}else{
				$return['msg'].=',删除订单失败';
				$return['code'] = 0;
			}
		}else{
			$return['msg']	= '取消订单失败';
			$return['code']	= 0;
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

	//用户支付完成后的跳转页面
	public function rechargeReturn()
	{
		
		//验签
		$data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

		//验证app_id和seller_id
		$return['code']	= 1;
		$app_id				= $data->app_id;
		$seller_id			= $data->seller_id;

		if($seller_id != $this->seller_id){
			$return['data'] 	= '';
			$return['code']	= 0;
			$return['msg']	= '卖家id错误,请检查';
		}
		if($app_id != $this->config['app_id']){
			$return['data'] 	= '';
			$return['code']	= 0;
			$return['msg']	= 'app_id错误,请检查';
		}

		//如果通过验证,则获取信息并根据订单号插入数据库
		if($return['code'] != 0){
			$info['trade_no'] 		= $data->out_trade_no;	//本地订单
			$info['voucher']			= $data->trade_no;
			$info['recharge_amount']	= $data->total_amount;
			$info['timestamp']		= $data->timestamp;
		
			$model = new AliRecharge();
			$return = $model->returnInsert($info);
		}
		return redirect("http://localhost/auth/pay.html?order=".$info['trade_no']);
		// 订单号：$data->out_trade_no
		// 支付宝交易号：$data->trade_no
		// 订单总金额：$data->total_amount
	}


	//支付宝用的ajax通知接收的方法

	public function rechargeNotify(Request $request)
	{
		

		$alipay = Pay::alipay($this->config);
	
		try{
			$data = $alipay->verify($request->all()); // 是的，验签就这么简单！

			$app_id				= $data->app_id;
			$seller_id			= $data->seller_id;
			if($seller_id != $this->seller_id){
				return tz_ajax_echo('','卖家id错误,请检查',0);
			}
			if($app_id != $this->config['app_id']){
				return tz_ajax_echo('','app_id错误,请检查',0);
			}
			
			$info['trade_no'] 		= $data->out_trade_no;
			$info['voucher']			= $data->trade_no;
			$info['recharge_amount']	= $data->total_amount;
			$info['timestamp']		= $data->timestamp;

			$model = new AliRecharge();
			$res = $model->returnInsert($info);
			if($res['code'] != 1){
				return $res['msg'];
			}
			// 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
			// 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
			// 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
			// 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
			// 4、验证app_id是否为该商户本身。
			// 5、其它业务逻辑情况

			Log::debug('Alipay notify', $data->all());
		} catch (Exception $e) {
			$e->getMessage();
		}

		return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
	}


	/**
	* 查询指定用户的所有充值单的接口
	*@param $user_id 	用户id
	* @return 订单信息,
	*/
	public function getOrderByUser(Request $request){
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
	public function getOrder(Request $request){

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
	public function checkRechargeOrder(Request $request){

		$info 		= $request->only(['trade_no']);
		$trade_no 	= $info['trade_no'];
		$model 	= new AliRecharge();
		$res 		= $model->checkOrder($trade_no,2);
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	public function form(){
		return view('form');
	}
}