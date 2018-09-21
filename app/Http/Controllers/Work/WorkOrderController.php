<?php

namespace App\Http\Controllers\Work;

use App\Http\Controllers\Controller;
use App\Http\Models\Work\WorkOrderModel;
use App\Http\Requests\Work\WorkOrderRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
/**
 * 工单的控制器
 */
class WorkOrderController extends Controller
{

	/**
	 * 查找工单的信息(各地机房人员)
	 * @return json           返回相关的数据和状态信息
	 */
	public function showWorkOrder(WorkOrderRequest $request){
		$par = $request->only(['work_order_status']);
		$status = (int)$par['work_order_status'];
		$user_id = Auth::id();

		$model = new WorkOrderModel();
		$return = $model->showWorkOrder($status,$user_id);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);  
	}

	/**
	 * 客户提交工单
	 * @return json 将相关的状态和信息提示返回
	 */
	public function insertWorkOrder(WorkOrderRequest $request){
		$data = $request->only(['mac_num','mac_ip','work_order_content','work_order_type']);
		$customer		= Auth::user();

		$data['customer_id']	= $customer->id;
		$data['customer_name']	= $customer->name;
		$data['clerk_id']		= $customer->salesman_id;

		$insertwork = new WorkOrderModel();
		$return = $insertwork->insertWorkOrder($data);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	
	/**
	 * 删除对应的工单信息
	 * @param  Request $request [description]
	 * @return json          相关的信息提示和状态返回
	 */
	public function deleteWorkOrder(WorkOrderRequest $request){
		if($request->isMethod('post')){
			$delete = $request->get('delete_id');
			$deleted = new WorkOrderModel();
			$result = $deleted->deleteWorkOrder($delete);
			return tz_ajax_echo($result,$result['msg'],$result['code']);
		} else {
			return tz_ajax_echo([],'无法对数据进行删除',0);
		}
	}


	
}
