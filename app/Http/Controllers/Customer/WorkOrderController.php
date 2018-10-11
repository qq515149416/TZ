<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Customer\WorkOrderModel;
// use App\Http\Requests\Customer\WhiteListRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{	
	/**
	 * 显示工单
	 * @return json 返回相关的工单数据
	 */
    public function showWorkOrder(Request $request){
    	$status = $request->only(['work_order_status']);
    	$show = new WorkOrderModel();
    	$show_work_order = $show->showWorkOrder($status);
    	return tz_ajax_echo($show_work_order['data'],$show_work_order['msg'],$show_work_order['code']);
    }

    /**
     * 提交工单
     * @param  Request $request [description]
     * @return json           将相关的状态和信息提示返回
     */
    public function insertWorkOrder(Request $request){
    	$insert_data = $request->only(['business_num','work_order_content','work_order_type']);
    	$insert = new WorkOrderModel();
    	$insert_result = $insert->insertWorkOrder($inser_data);
    	return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
    }
}
