<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Http\Models\Pay\WechatPay;
use Illuminate\Http\Request;

use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;


class WechatPayController extends Controller
{
	protected $config = [
			'appid' 		=> '', 		// APP APPID
			'app_id' 		=> '', 		// 公众号 APPID
			'miniapp_id' 	=> '', 		// 小程序 APPID
			'mch_id' 	=> '',		//商户号
			'key' 		=> '',		//秘钥
			'notify_url' 	=> '',
			'cert_client' 	=> '', 		// optional，退款等情况时用到
			'cert_key' 	=> '',		// optional，退款等情况时用到
			'log' 		=> [ // optional
					'file' 			=> './logs/wechat.log',
					'level' 			=> 'info', // 建议生产环境等级调整为 info，开发环境为 debug
					'type' 			=> 'single', // optional, 可选 daily.
					'max_file' 		=> 30, // optional, 当 type 为 daily 时有效，默认 30 天
			],
			'http' 		=> [ // optional
					'timeout' 		=> 5.0,
					'connect_timeout' 	=> 5.0,
					// 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
			],
			//'mode' 		=> 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
	];

	/**
	*从env获取敏感配置信息
	*@param 	
 	**/
 	
 	public function __construct()
 	{					
 		$this->config['appid'] 		= config('wechat_pay.app_id');
 		$this->config['app_id'] 		= config('wechat_pay.app_id');
 		$this->config['miniapp_id'] 	= config('wechat_pay.app_id');
 		$this->config['mch_id'] 		= config('wechat_pay.mch_id');
 		$this->config['key'] 		= config('wechat_pay.key');
 		$this->config['cert_client'] 	= config('wechat_pay.cert_client');
 		$this->config['cert_key'] 		= config('wechat_pay.cert_key');
 	
 	}

 	//充值单获取微信支付的二维码url方法
 	public function getWechatUrl($flow_id)
 	{

		$this->config['notify_url'] = config('wechat_pay.tz_url').'/home/recharge/wechatNotify';
 		//获取订单信息
 		$model = new WechatPay();
 		$get_flow = $model->getFlow($flow_id);

 		if ($get_flow['code'] != 1) {	//失败就返回失败信息
 			return $get_flow;
 		}
 		$flow = $get_flow['data'];
 		//因为单位是分,所以要乘以100
 		$total_fee = bcmul($flow['recharge_amount'],100,0);
		$order = [
			'out_trade_no' 		=> $flow['trade_no'],
			'total_fee' 		=> $total_fee, // **单位：分**
			'body' 			=> '余额充值',
			//'product_id'		=> 1,		//代表的是商品id,
			//'openid' 		=> 'onkVf1FjWS5SBIixxxxxxx',
		];
	
		$pay = Pay::wechat($this->config)->scan($order);
		if ($pay['return_code'] == 'SUCCESS') {
			return [
				'data'	=> $pay['code_url'],
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> $pay,
				'msg'	=> '获取失败',
				'code'	=> 0,
			];
		}
 	}

 	// 验证微信付款状态的方法	充值用的
 	// 主要验证  appid,商户id,金额,订单状态对不对,不对的直接退款
 	// @return  code:	0-未付款	1-付过款并且信息没问题,尚未发货 	2-付过款了并且信息没问题,已经发货了 	3-付过款,信息有问题,尚未发货,需要工作人员处理
 	//			4-付款状态异常,需重新下单
 	//	     data: 	$check -微信返回的支付结果

 	// 微信查询接口返回格式:
 	// [
 	// "return_code" => "SUCCESS"
	//  "return_msg" => "OK"
	//  "appid" => "wxed53de9cb1665943"
	//  "mch_id" => "1546530481"
	//  "nonce_str" => "9DdlmvKYrtXZMW4E"
	//  "sign" => "46F8E957CDB5565B8AFCE8CEFF478FB7"
	//  "result_code" => "SUCCESS"
	//  "openid" => "ovSvawqFVMtuocDxPtdDRry1Y67c"
	//  "is_subscribe" => "N"
	//  "trade_type" => "NATIVE"
	//  "bank_type" => "CFT"
	//  "total_fee" => "1"
	//  "fee_type" => "CNY"
	//  "transaction_id" => "4200000344201907249423820487"
	//  "out_trade_no" => "tz_1563936855_bd49"
	//  "attach" => []
	//  "time_end" => "20190724163842"
	//  "trade_state" => "SUCCESS"
	//  "cash_fee" => "1"
	//  "trade_state_desc" => "支付成功"
	// ]

 	public function checkOrder($trade_no)
 	{
 		$check = Pay::wechat($this->config)->find($trade_no);
 		//-	交易标识 	-//
 		//-	trade_state 	-//
		// SUCCESS—支付成功
		// REFUND—转入退款
		// NOTPAY—未支付
		// CLOSED—已关闭
		// REVOKED—已撤销（付款码支付）
		// USERPAYING--用户支付中（付款码支付）
		// PAYERROR--支付失败(其他原因，如银行返回失败)
		// 支付状态机请见下单API页面
		//-	trade_state 	-//
 		if ( $check['return_code'] == 'SUCCESS' && $check['trade_state'] == 'SUCCESS' && $check['result_code'] == 'SUCCESS') {	
 		//trade_state == SUCCESS代表客户付过款了	
 			if ($check['appid'] != $this->config['appid']) {	//appid不对的话,取消订单,需要工作人员处理
 				return [
 					'data'	=> $check,
 					'msg'	=> 'appid错误',
 					'code'	=> 3,
 				];
 			}
 			if ($check['mch_id'] != $this->config['mch_id']) {	//mch_id不对的话,取消订单,需要工作人员处理
 				return [
 					'data'	=> $check,
 					'msg'	=> 'mch_id错误',
 					'code'	=> 3,
 				];
 			}

 			//获取订单信息
 			$flow = WechatPay::where('trade_no',$trade_no)->first();
 			if (!$flow) {
 				return [
					'data'	=> $check,
					'msg'	=> '订单信息获取失败',
					'code'	=> 3,
				];
 			}
 			$flow = $flow->toArray();
 			//微信的金额的单位是分,所以这里要除以100
 			$recharge_amount = bcdiv($check['total_fee'],100,2);
 			
 			if ($flow['recharge_amount']  != $recharge_amount) {	//付款金额不对的话,需要工作人员处理
 				return [
 					'data'	=> $check,
 					'msg'	=> '付款金额有误',
 					'code'	=> 3,
 				];
 			}

 			if ($flow['trade_status'] != 0 ) {			//订单已经付过款的话
 				if ($flow['recharge_way'] != 2) {		//订单不是微信支付的,需要工作人员处理
 					return [
	 					'data'	=> $check,
	 					'msg'	=> '此订单已由别的支付方式支付完毕',
	 					'code'	=> 3,
	 				];
 				}else{					//订单已支付并且支付来源一致,证明是已经交易成功的
 					return [
 						'data'	=> $check,
	 					'msg'	=> '此订单已付款并完成结算',
	 					'code'	=> 2,
 					];
 				}
 			}
 			//都没问题的话,返回付款成功
 			return [
				'data'	=> $check,
				'msg'	=> '付款成功',
				'code'	=> 1,
			];
 		}else{		//不是SUCCESS的话代表没付款

 			if ($check['trade_state'] == 'REFUND') {
 				return [
					'data'	=> $check,
					'msg'	=> '已退款',
					'code'	=> 4,
				];
 			}else{
 				if ($check['trade_state'] == 'NOTPAY' || $check['trade_state'] == 'USERPAYING') {
 					return [
						'data'	=> $check,
						'msg'	=> '尚未付款',
						'code'	=> 0,
					];
 				}else{
 					return [
						'data'	=> $check,
						'msg'	=> '付款状态异常,请重新下单',
						'code'	=> 4,
					];
 				}	
 			}		
 		}	
 	}

 	/***确认付款成功后的数据处理方法    充值用的
 	*@param $par ,指的是此类里的checkOrder方法返回的结果,也就是说是微信的查询方法返回的结果
 	*
 	*
 	*/
 	public function rechargePaySuccess($check)
 	{
 		$model = new WechatPay();
 		$res = $model::rechargePaySuccess($check);
 		return $res;
 	}

 	//获取本机外网ip方法
 	protected function getLocalIP() {
		   $ch = curl_init('http://tool.huixiang360.com/zhanzhang/ipaddress.php');

		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		    $a  = curl_exec($ch);

		    preg_match('/\[(.*)\]/', $a, $ip);

		    return '您现在的IP是: ' . $ip[1] . "\n";

	}

	//样板
	public function index()
	{
		$config_biz = [
			'out_trade_no' 		=> '',          	// 订单号
			'total_fee' 		=> '',             	// 订单金额，**单位：分**
			'body' 			=> '',                  // 订单描述
			'spbill_create_ip' 	=> '',       	// 调用 API 服务器的 IP
			'product_id' 		=> '',           	// 订单商品 ID
		];
		// $config_biz = [
		// 	'out_trade_no' => 'e2',
		// 	'total_fee' => '0.01',
		// 	'body' => 'test body',
		// 	'spbill_create_ip' => '14.213.156.207',
		// 	'openid' => 'onkVf1FjWS5SBIihS-123456_abc',
		// ];

		$pay = new Pay($this->config);

		return $pay->driver('wechat')->gateway('mp')->pay($config_biz);
	}

	//样板
	public function test()
	{
		$order = [
			'out_trade_no' => time(),
			'total_fee' => '1', // **单位：分**
			'body' => 'test body - 测试',
			'openid' => 'onkVf1FjWS5SBIixxxxxxx',
		];

		$pay = Pay::wechat($this->config)->mp($order);
	}

	



	public function notify(Request $request)
	{
		$pay = Pay::wechat($this->config);

		try{
			$data = $pay->verify(); // 是的，验签就这么简单！
			Log::debug('Wechat notify', $data->all());
		} catch (\Exception $e) {
			// $e->getMessage();
		}

		$check_res = $this->checkOrder($data->out_trade_no);
		if ($check_res['code'] == 1) {

			$insert_res = $this->rechargePaySuccess($check_res['data']);
			if ($insert_res['code'] == 1) {
				return $pay->success();// laravel 框架中请直接 `return $pay->success()`
			}
		}
		if ($check_res['code'] == 2) {	//付过款了并且信息没问题,已经发货了
			return $pay->success();
		}
	}

	/**
	*退款接口(会退款)
	*@param 	$check 	就是checkOrder那个方法得来的
	*/

	protected function cancel($check){

		$order = [
			'out_refund_no'	=> $check['out_trade_no'].'refund',
			'total_fee'	=> $check['total_fee'],
			'refund_fee'	=> $check['total_fee'],
			'transaction_id'	=> $check['transaction_id'],
			'out_trade_no'	=> $check['out_trade_no'],
		];
		$cancel =  Pay::wechat($this->config)->refund($order);

		return $cancel;
	}
	
}