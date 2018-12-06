<?php


namespace App\Admin\Controllers\DefenseIp;

use App\Admin\Models\DefenseIp\BusinessModel;
use App\Admin\Requests\DefenseIp\BusinessRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BusinessController extends Controller
{
	
	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息 
	 */
	public function buyNowByAdmin(BusinessRequest $request){
		$par = $request->only(['package_id','customer_id']);

		$model = new BusinessModel();

		$package_id 	= $par['package_id'];
		$customer_id 	= $par['customer_id'];
		$makeOrder 	= $model->buyNow($package_id,$customer_id);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
	
	/**
	 *  续费 高防IP 接口  /  选取业务后,生成订单信息 
	 */
	public function renewByAdmin(BusinessRequest $request){
		$par = $request->only(['business_id','buy_time']);
		$model = new BusinessModel();

		$business_id = $par['business_id'];
		$buy_time = $par['buy_time'];
		$makeOrder = $model->renew($business_id,$buy_time);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}
}