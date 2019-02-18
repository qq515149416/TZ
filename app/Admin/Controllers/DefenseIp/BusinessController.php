<?php


namespace App\Admin\Controllers\DefenseIp;

use App\Admin\Models\DefenseIp\BusinessModel;
use App\Admin\Requests\DefenseIp\BusinessRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BusinessController extends Controller
{
	
	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成审核中业务信息
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
	 *  审核 高防IP 接口  /  选取审核中业务后,转为试用业务
	 */
	public function upExamineDefenseIp(BusinessRequest $request){
		$par = $request->only(['business_id','res']);
		$model = new BusinessModel();

		$business_id = $par['business_id'];
		$res = $par['res'];
		$makeOrder = $model->upExamineDefenseIp($business_id,$res);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	 *  获取待审核 高防IP 接口 
	 */
	public function showUpExamineDefenseIp(BusinessRequest $request){

		$model = new BusinessModel();

		$makeOrder = $model->showUpExamineDefenseIp();
		
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

	
	public function test(){
		
	}
}