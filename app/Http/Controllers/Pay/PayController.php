<?php

namespace App\Http\Controllers\Pay;

use App\Http\Models\Pay\Recharge;
use App\Http\Requests\Pay\PayRequest;
use App\Http\Requests\Pay\RechargeRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class PayController extends Controller
{
	protected $seller_id = '2088102176242173';
	protected $config = [
		'app_id' => '2016091800542971',
		'notify_url' => '',
		'return_url' => '',
		'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5U+SBLpzQbX72aDmeiUSDTouF2+THtikn28Oyul5fU8HmFPHbZKMYD+Fjmf8RUVBOHpad02FCvW+FlhOktq0JYEBU1tcgIb0af23mlaOcYdbSfIYXUKbg3T+vd2+0VV2apFDO0AsNqWhQL/2FEDBtMiTUfoEAnDxTCZWIdc4sGPsklLqDYv85Vv284LhrGep/hG7cMKdlqXz97godlno7dsBXdiHqVMjBAAryE+GdwEqktEVCJHfr33HtSrReTLztt1gzerpZhng9fGJDbCCuz8VWs/Nihzb1S8F5WzAXl7kyHQD/2gAptabF19vESnIN/vcbv/6YFELOj5MEO4wHwIDAQAB',
		// 加密方式： **RSA2**  
		'private_key' => 'MIIEogIBAAKCAQEAwsfcKs6Ngrx8/SYZDzkkk0LIDcB/XNPbOp2OYDKqvhwpAr2M/WWvuFXdRd62mb8iqepURtFyKxqlwbv/Ziez/54zJpJmdGveRJJG+uuDDdaTosn61VbHr/Tm94/KKO8qQUhfTpitUlttNN0fgCKTyoc4y2Y8F8XjDkNf02Chpm4j+oU4VfWlCx2pqXd2Ey44AoHNqRij2QVWWjrU7YfqlmDgVCwR6T/ce4y+aNFf4/fu4/XomRRL7fuqXPfFWpNeUo4cNnietNb7vAQ2Fdlqf+EexX36LTo1lIVh7HiGxS4j4qpsn0syWbKmNe7ikShqCVSQIWEN78AZHiFEs4EyqwIDAQABAoIBAAbIQshSzOaifY+rBfBbwwRFrQWdkFHBJr8RwWVkHkHkZSEtTH1+TvISO1Q1fxI3b5OPD0QwAtOxZ9gpHamG9GOQNKPBMUQYhXLJzSLrlHKk6BshAVTwYp+j3W79WMK4ITaIuJjaBB78A/91O6WQjqjcsIOUmb8SKufSPMH1eWt8FsEjB/eyqvtsGXGx/9SjBR3iR0/vlrYasa1fK61Hdd5YoJvqNC6j8mmfKTaaT/bXx4V60Jso4IY4YuYD7N1ouNozwQSb7CXERWVsdoJP9u7Fi5rJeQbzjJzs/9qKVPEiuh7jJFeErXoaUgrEw0KZ2a1hMPwko2U8yZv+rULRIAECgYEA5z4vVuJZmoxcmXISNZd3OE/DqPSlBh9tuDNg26GnJ2OHHyICk9JP85Xcr+0uiWD3QUaJJAwsxtbeNvN0LmHHMamA7vzT8MO44UN4M4LYclb0Y1sgFJtDaiyVY9AAOCzYiNeYba03q+Gieez2sYTUmzlThSJ7SH4JFyy60qjymqsCgYEA16JVTtwXlu/v27z0cx5Io5t6Btcgh1Ks9Pk12H0cUJHs8V+d7UecGoe6Dy67dFW1sxUypdC4cFNd8TxTBzqVLQFiEu8MebMlYIHC/KdeKlW+eIR/H6INuoZ+md8ylnOTY6sf/jLNouAw6fmtswbRa7rQ/O91apcpyYopDZUryAECgYBwLfGnM52GZQtTAUymJPmYHtHrd+tKohqHHp2hTrWZXSYiy0v2zDMvFwd9bRGDYb/xMbe7/hAG0hvxCn/VNGf+xp0e0xY6Gajp1uJMEvDP3zEltgJFHOFCc6hxSGmi1tag4/41Tq/QOWCpx3QRwD+nodLLpmOqUkI0tOVY5s7yiwKBgDhgGomJhSlTBZSfbBGEw1zy0w5ixABdHxbU6Lz2yKZP4HCinPliFW/iOESr5RpfJifxzNIJJY9IXHErYlGrgUDI8ckdcleG/KikhEPlxfqvfCKqEUpF5ez0KLk131XyVYBjRvQAeD6y+lbRjhYWHD5cEzNtr3b0mlo0otMIQvABAoGAV07K16VdyNpwiWAEAiBz/wdDwcBEqd7OvPcOQjZgxLiQAmFBquruvadwYf5NcseZlWnTrNVBkaEu4+J8g63Xltdzv+1JwGzj+2eG8ItgW6H3wT1VNRT6f5XfoMTPUasTdSiT7cKUq8o9/fNlRMvECFclRButC0CTNoUMRbf2CyU=',
		'log' => [ // optional
			'file' => './logs/alipay.log',
			'level' => 'debug'
			
		],
		'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
		'timeout_express'	=> '5m',
	];

	/**
	*生成支付宝付款订单的方法
	*@param $pay_for	用于确认付款用途,1为充值
	*@return 付款的链接
 	**/

	public function index(PayRequest $request)
	{
		//获取支付信息
		$info = $request->only(['pay_for', 'total_amount','subject']);       
		$user_id = 2;

		$order = [
			'out_trade_no' 	=> 'tz_'.time().'-'.$user_id,	//本地订单号
			'total_amount' 	=> $info['total_amount'],		//金额
			'subject' 	=> $info['subject'],		//用途
		];

		//根据支付信息生成支付宝的调回地址及异步通知地址
		//再顺便生成订单
		switch ($info['pay_for'])
		{
			case 1:
				 $this->config['return_url'] 	= 'http://tz.jungor.cn/home/payRechargeReturn';
				 $this->config['notify_url'] 	= 'http://tz.jungor.cn/home/payRechargeNotify';
				//$this->config['return_url'] 	= 'http://localhost/home/payRechargeReturn';
				//$this->config['notify_url'] 	= 'http://localhost/home/payRechargeNotify';

				$model = new Recharge();
				$data['trade_no'] 		= $order['out_trade_no'];
				$data['recharge_amount']	= $order['total_amount'];
				$data['user_id']			= $user_id;
				$data['recharge_way']		= '支付宝';
				$data['trade_status']		= 0;

				$makeOrder = $model->makeOrder($data);
				if($makeOrder['code'] == 0){
					return tz_ajax_echo([],'创建订单失败',0);
				}
				break;

			default:
				return tz_ajax_echo([],'请提供付款用途',0);
		}
		
		$alipay = Pay::alipay($this->config)->web($order);

		return $alipay;// laravel 框架中请直接 `return $alipay`
	}


	public function rechargeReturn()
	{
		
		//验签
		$data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

		$app_id				= $data->app_id;
		$seller_id			= $data->seller_id;
		if($seller_id != $this->seller_id){
			return tz_ajax_echo('','卖家id错误,请检查',0);
		}
		if($app_id != $this->config['app_id']){
			return tz_ajax_echo('','app_id错误,请检查',0);
		}

		//获取信息并根据订单号插入数据库
		$info['trade_no'] 		= $data->out_trade_no;	//本地订单
		$info['voucher']			= $data->trade_no;
		$info['recharge_amount']	= $data->total_amount;
		$info['timestamp']		= $data->timestamp;
	
		$model = new Recharge();
		$res = $model->returnInsert($info);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		// 订单号：$data->out_trade_no
		// 支付宝交易号：$data->trade_no
		// 订单总金额：$data->total_amount
	}

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

			$model = new Recharge();
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


	public function form(){
		return view('form');
	}
}