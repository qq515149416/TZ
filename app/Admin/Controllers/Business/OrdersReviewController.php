<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Admin\Models\Business\OrdersReviewModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\OrdersReviewRequest;

/**
 * 后台订单控制器
 */
class OrdersReviewController extends Controller
{

	/**
	 * 财务人员对消费流水提出复核
	 * @return json 返回订单的相关数据和状态信息和状态
	 */
	public function ordersReview(OrdersReviewRequest $request){
		$par = $request->only(['flow_id','reason']);
	
		$model = new OrdersReviewModel();

		$result = $model->ordersReview($par);
						
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
	}


}
