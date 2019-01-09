<?php
//前台,生成高防IP订单的控制器

namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\OrderModel;
use App\Http\Models\DefenseIp\PackageModel;
use App\Http\Requests\DefenseIp\OrderRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class OrderController extends Controller
{
	/**
	 *  显示可购买套餐
	 */
	public function showPackage(OrderRequest $request){
		$model = new PackageModel();

		$list = $model->showPackage();

		return tz_ajax_echo($list['data'],$list['msg'],$list['code']);
	}


	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息 
	 */
	public function buyNow(OrderRequest $request){
		$par = $request->only(['package_id','buy_time']);
		$model = new OrderModel();

		$package_id = $par['package_id'];
		$buy_time = $par['buy_time'];
		$makeOrder = $model->buyNow($package_id,$buy_time);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
	
	/**
	 *  续费 高防IP 接口  /  选取业务后,生成订单信息 
	 */
	public function renew(OrderRequest $request){
		$par = $request->only(['business_id','buy_time']);
		$model = new OrderModel();

		$business_id = $par['business_id'];
		$buy_time = $par['buy_time'];
		$makeOrder = $model->renew($business_id,$buy_time);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
}