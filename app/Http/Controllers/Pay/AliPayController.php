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

use App\Http\Requests\Pay\AliPayRequest;
use App\Http\Models\Pay\AliRecharge;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

use Illuminate\Support\Facades\Auth;

class AliPayController extends Controller
{
	protected $seller_id = '';
	protected $domain_name = '';
	protected $config = [
		'charset' => 'UTF-8',
		'app_id' => '',
		'notify_url' => '',
		'return_url' => '',
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
	*从env获取敏感配置信息
	*@param 	
 	**/
 	
 	public function __construct()
 	{
 		$this->seller_id			= env('SELLER_ID');
		$this->domain_name		= env('APP_URL');

		//这条实际应用要换
 		$this->config['notify_url'] 	= env('APP_URL').'/home/recharge/payRechargeNotify';
 		//$this->config['notify_url'] 	= 'http://tz.jungor.cn/home/recharge/payRechargeNotify';

 		$this->config['return_url'] 	= env('APP_URL').'/home/recharge/payRechargeReturn';
 		$this->config['private_key'] 	= env('ALI_PRIVATE_KEY');
 		$this->config['ali_public_key'] 	= env('ALI_PUBLIC_KEY');
 		$this->config['app_id'] 		= env('ALI_APP_ID');
 	}

	/**
	* 按支付方式返回支付链接
	*@param 	$order 	-订单信息 	$way 	支付方式: 	web直接跳转
	*								scan返回二维码图片url
	*/
	public function goToPay($order,$way)
	{
	
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



	//用户支付完成后的跳转的处理方法

	public function checkByReturn()
	{	
		//验签
		$data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

		//验证app_id和seller_id
		$return['data']	= $data;
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

		//返回验证结果
		return $return;

		// 订单号：$data->out_trade_no
		// 支付宝交易号：$data->trade_no
		// 订单总金额：$data->total_amount
	}


	//支付宝用的ajax通知接收的方法

	public function checkByAjax()
	{
		//获取配置信息
		$alipay = Pay::alipay($this->config);
		

		try{
			$data = $alipay->verify(); // 是的，验签就这么简单！

			$info = json_encode($data);
			$info = $info.'------';
			file_put_contents(storage_path('test.txt'), $info."\r\n", FILE_APPEND);

			$app_id				= $data->app_id;
			$seller_id			= $data->seller_id;

			$return['data']	= $data;
			$return['code']	= 1;
			$return['msg']	= $alipay->success();

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
			
			
			// 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
			// 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
			// 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
			// 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
			// 4、验证app_id是否为该商户本身。
			// 5、其它业务逻辑情况

			Log::debug('Alipay notify', $data->all());

		} catch (Exception $e) {
			$return['data'] 	= '';
			$return['code']	= 0;
			$return['msg']	= $e->getMessage();
		}
		//返回验签结果
		return $return;
		// return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
	}


	

	/**
	*关闭订单接口
	*@param 	$trade_no 	订单号,就是属于支付宝的out_trade_no
	*/

	public function cancel($trade_no){
		
		$cancel =  Pay::alipay($this->config)->cancel($trade_no);

		return $cancel;
	}

	/**
	*查询订单接口
	*@param 	$trade_no 	订单号,就是属于支付宝的out_trade_no
	*/

	public function check($trade_no){
		
		$check =  Pay::alipay($this->config)->find($trade_no);

		return $check;
	}

}