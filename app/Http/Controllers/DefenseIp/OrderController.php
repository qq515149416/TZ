<?php


namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\OrderModel;
use App\Http\Requests\DefenseIp\OrderRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class OrderController extends Controller
{

	/**
	 *  新购 高防IP 接口  /  选取购买信息后,生成订单信息 
	 */
	public function buyNow(OrderRequest $request){
		$par = $request->only(['package_id','buy_time']);
		$model = new OrderModel();

		$package_id = $par['package_id'];
		$buy_time = $par['buy_time'];
		$makeOrder = $model->buyNow($package_id,$buy_time);
		dd($makeOrder);
	}
	
}