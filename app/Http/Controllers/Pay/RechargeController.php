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
		$data['trade_no'] 		= 'tz_'.time().'_'.$user_id;		//本地订单号,需保证不重复
		$data['recharge_amount']	= $info['total_amount'];		//订单总金额，单位为元，精确到小数点后两位
		$data['subject']			= '充值余额';			//商品名称
		$data['user_id']			= $user_id;	
		$data['recharge_way']		= 1;
		$data['trade_status']		= 0;
		//$data['product_code']		=  'FAST_INSTANT_TRADE_PAY';	//销售产品码，与支付宝签约的产品码名称。 注：目前仅支持FAST_INSTANT_TRADE_PAY
		$makeOrder = $model->makeOrder($data);
							
		return $makeOrder;		
	}

	/**
	* 跳转支付页面方法
	*@param 	$trade_id 	充值订单号的id		
	*		$way 		支付途径:	web代表直接跳转	
	*						scan代表获取二维码
	*/
	public function goToPay(RechargeRequest $request)
	{
		$checkLogin = Auth::check();
		if($checkLogin == false){
			return tz_ajax_echo([],'请先登录',0);
		}
		$user_id = Auth::id();

		$info		= $request->only(['trade_id','way']);
		
		$trade_id 	= $info['trade_id'];
		$way 		= $info['way'];
		
		$model 	= new AliRecharge();
		$res 		= $model->makePay($trade_id,$user_id);

		if($res['code'] != 1){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}
		
		$info = json_decode(json_encode($res['data']),true);

		$Pay = new AliPayController();

		$order = [
			'out_trade_no' 		=> $info['trade_no'],		//本地订单号
			'total_amount' 		=> $info['recharge_amount'],	//金额
			'subject' 		=> '余额充值',			//商品名称
			'timeout_express'	=> '5m',	
			//该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。该参数在请求到支付宝时开始计时。			
			'product_code'		=> 'FAST_INSTANT_TRADE_PAY',	//销售产品码，与支付宝签约的产品码名称。 注：目前仅支持FAST_INSTANT_TRADE_PAY

			// 'auth_token'		=> 'XXXXXX',			//获取用户授权信息，可实现如免登功能。
		];
	
		//生成支付宝跳转及ajax链接
		$returnUrl	= env('APP_URL').'/home/recharge/payRechargeReturn';
		$notifyUrl 	= env('APP_URL').'/home/recharge/payRechargeNotify';
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

		$model 	= new AliRecharge();
		$order 		= $model->checkOrder($trade_id,3);
		if($order['code'] != 1){
			return tz_ajax_echo($order['data'],$order['msg'],$order['code']);
		}

		$order = json_decode(json_encode($order['data']),true);
		$trade_no = $order[0]['trade_no'];
		$check = $this->checkAndInsert($trade_no);
		if($check['code'] != 1 && $check['code'] != 0){
			return tz_ajax_echo('',$check['msg'].'订单状态异常,暂时无法删除',0);
		}

		$check_user_id = $order[0]['user_id'];
		if($user_id != $check_user_id){
			return tz_ajax_echo('','该订单不属于您,无法删除',0);
		}

		$return['data']	= '';
		
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



	//用户支付完成后的跳转处理页面
	public function rechargeReturn()
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
		$res = $this->checkAndInsert($trade_no);
		//跳转确认页面
		$domain_name = env('APP_URL');
		return redirect("{$domain_name}/auth/pay.html?order=".$trade_no);
	}


	//支付宝用的ajax通知接收的方法

	public function rechargeNotify()
	{
		//验签
		$PayController = new AliPayController();
		$res = $PayController->checkByAjax();
		//成功就更新数据库信息
		if($res['code'] == 1){
			$data = $res['data'];	
			$info['trade_no'] 		= $data->out_trade_no;
			//两个方法,一个是验证成功了之后直接更新数据库

			// $info['voucher']			= $data->trade_no;
			// $info['recharge_amount']	= $data->total_amount;
			// $info['timestamp']		= $data->timestamp;
			// $model = new AliRecharge();
			// $insert = $model->returnInsert($info);

			//另一个再调用一遍检查并更新接口,都可以一个消耗资源点,安全点,上面那个简单点

			$insert = $this->checkAndInsert($info['trade_no']);
			if($insert['code'] != 1){
				$res['msg'] = '储存失败';
			}
		}	
		return $res['msg'];					
	}


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
		
		$return = $this->checkAndInsert($trade_no);
		
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	protected function checkAndInsert($trade_no){

		$PayController = new AliPayController();
		$res = $PayController->check($trade_no);

		if($res->trade_status != 'TRADE_SUCCESS'&&$res->trade_status != 'TRADE_FINISHED'){
			return tz_ajax_echo('','用户尚未付款',0);
		}else{
			$return = [
				'data'	=> '',
				'code'	=> 1,
				'msg'	=> '用户已付款',
			];
		}	

		$model 	= new AliRecharge();

		$check 		= $model->checkOrder($trade_no,2);
		$check 		= json_decode(json_encode($check),true);
		$return['data']	= $check['data'];

		if($check['code'] == 0){
			return tz_ajax_echo('','用户已付款,本地查找不到订单,联系工作人员',2);
		}

		if($check['data'][0]['trade_status'] != 1){
			$info['trade_no'] 		= $trade_no;	//本地订单
			$info['voucher']			= $res->trade_no;
			$info['recharge_amount']	= $res->total_amount;
			$info['timestamp']		= $res->send_pay_date;

			//更新数据库信息
			$model = new AliRecharge();
			$update = $model->returnInsert($info);
			$return['msg'] = $return['msg'].','.$update['msg'];

			if($update['code'] != 1){		
				return tz_ajax_echo('',$return['msg'],3);
			}

			$check 		= $model->checkOrder($trade_no,2);
			$check 		= json_decode(json_encode($check),true);
			$return['data']	= $check['data'];
		}else{
			$return['msg'].= ',订单已完成';
		}
		return $return;
	}

}