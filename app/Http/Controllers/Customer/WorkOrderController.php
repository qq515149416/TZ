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
		$param = $request->only(['work_order_status']);
		$model = new WorkOrderModel();
		$return = $model->showWorkOrder($param);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);  
	}

	/**
	 * 客户提交工单
	 * @return json 将相关的状态和信息提示返回
	 */
    public function insertWorkOrder(Request $request){
    	
    		$data = $request->only(['business_num','work_order_content','work_order_type']);
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
		$customer_id	= Auth::id();
		$delete 		= $request->get('delete_id');
		$deleted 	= new WorkOrderModel();
		$result 		= $deleted->deleteWorkOrder($delete,$customer_id);

		return tz_ajax_echo('',$result['msg'],$result['code']);
	}

	/**
	 * 取消工单接口
	 * @param  Request $request [description]
	 * @return json          相关的信息提示和状态返回
	 */
	public function cancelWorkOrder(WorkOrderRequest $request){
		$customer_id	= Auth::id();
		$id 		= $request->get('cancel_id');
		$model 	= new WorkOrderModel();
		$result 		= $model->cancelWorkOrder($id,$customer_id);

		return tz_ajax_echo('',$result['msg'],$result['code']);
	}

	
}
