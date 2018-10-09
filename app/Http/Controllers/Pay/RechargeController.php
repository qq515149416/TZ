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
	*@param 	
			$total_amount	订单金额
			
			$trade_no 	本地订单号

	*@return 创建订单的id
 	**/
 	
 	

	public function index(RechargeRequest $request)
	{
		//获取支付信息
		$info = $request->only(['total_amount']);   
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
			'subject' 	=> '充值余额',			//商品名称
		];
		
		//再顺便生成订单

		$model = new AliRecharge();
		//我们的trade_no对于支付宝来说就是 out_trade_no
		$data['trade_no'] 		= $order['out_trade_no'];
		$data['recharge_amount']	= $order['total_amount'];
		$data['user_id']			= $user_id;
		$data['recharge_way']		= '支付宝';
		$data['trade_status']		= 0;

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

		//实际获取
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

		if($res['code'] == 0||$res['code'] == 3){
			return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
		}
		
		$info = json_decode(json_encode($res['data']),true);

		$Pay = new AliPayController();

		if($res['code'] == 2){

			$cancel = $Pay->cancel($info['trade_no']);

			if($cancel->code == '10000'){
				$del = $model->delOrder($trade_id);
				if($del == true){
					$res['msg'].=',删除订单成功,若已付款则会原路退还';
				}else{
					$res['msg'].=',删除订单失败,若已付款则会原路退还';
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
		$alipay = $Pay->goToPay($order,$way);
		
		//跳转到支付宝链接或返回结果
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
		$PayController = new AliPayController();

		$return = $PayController->checkByReturn(); // 是的，验签就这么简单！

		if($return['code'] == 0){
			return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
		}
		$data = $return['data'];
		$info['trade_no'] 		= $data->out_trade_no;	//本地订单
		$info['voucher']			= $data->trade_no;
		$info['recharge_amount']	= $data->total_amount;
		$info['timestamp']		= $data->timestamp;

		$model = new AliRecharge();
		$res = $model->returnInsert($info);

		$domain_name = env('APP_URL');
		return redirect("{$domain_name}/auth/pay.html?order=".$info['trade_no']);
	}


	//支付宝用的ajax通知接收的方法

	public function rechargeNotify(Request $request)
	{
		$PayController = new AliPayController();
		$res = $PayController->checkByAjax();
		if($res['code'] == 1){
			$data = $res['data'];	
			$info['trade_no'] 		= $data->out_trade_no;
			$info['voucher']			= $data->trade_no;
			$info['recharge_amount']	= $data->total_amount;
			$info['timestamp']		= $data->timestamp;
			$model = new AliRecharge();
			$insert = $model->returnInsert($info);
			if($insert['code'] == 0){
				$res['msg'] = '储存失败';
			}
		}	
		return $res['msg'];					
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