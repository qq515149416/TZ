<?php


namespace App\Admin\Controllers\DefenseIp;

use App\Admin\Models\DefenseIp\OrderModel;
use App\Admin\Requests\DefenseIp\OrderRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;


class OrderController extends Controller
{
	
	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息 
	 */
	public function buyNowByAdmin(OrderRequest $request){
		$par = $request->only(['package_id','buy_time','customer_id']);
		$admin_user_id = Admin::user()->id;

		$model = new OrderModel();

		$package_id 	= $par['package_id'];
		$buy_time 	= $par['buy_time'];
		$customer_id 	= $par['customer_id'];
		$makeOrder 	= $model->buyNow($package_id,$buy_time,$customer_id);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
	
	/**
	 *  续费 高防IP 接口  /  选取业务后,生成订单信息 
	 */
	public function renewByAdmin(OrderRequest $request){
		$par = $request->only(['business_id','buy_time','customer_id']);
		$admin_user_id = Admin::user()->id;

		$model = new OrderModel();

		$business_id = $par['business_id'];
		$buy_time = $par['buy_time'];
		$makeOrder = $model->renew($business_id,$buy_time);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
}