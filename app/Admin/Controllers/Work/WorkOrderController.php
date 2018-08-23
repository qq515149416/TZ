<?php

namespace App\Admin\Controllers\Work;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Work\WorkOrderModel;
use App\Admin\Requests\Work\WorkOrderRequest;
use Illuminate\Http\Request;

/**
 * 工单的控制器
 */
class WorkOrderController extends Controller
{
    use ModelForm;

    /**
     * 查找工单的信息
     * @return json           返回相关的数据和状态信息
     */
    public function showWorkOrder(Request $request){
    	if($request->isMethod('get')){
    		$where = $request->only(['work_status']);
    		$showworkorder = new WorkOrderModel();
    		$return = $showworkorder->showWorkOrder($where);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'获取工单信息失败！！',0);
    	}	
    }

    /**
     * 内部提交工单
     * @return json 将相关的状态和信息提示返回
     */
    public function insertWorkOrder(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->only(['customer_id','customer_name','machine_num','content']);
    		$insertwork = new WorkOrderModel();
    		$return = $insertwork->insertWorkOrder($data);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'工单提交失败!!',0);
    	}
    }

    /**
     * 修改工单的状态或者处理部门
     * @param  Request $request 
     * @return json           返回相关的状态和提示信息
     */
    public function editWorkOrder(Request $request){
    	if($request->isMethod('post')){
    		$editdata = $request->only(['id','work_status','work_department','summary']);
    		$editworkorder = new WorkOrderModel();
    		$return = $editworkorder->editWorkOrder($editdata);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'工单状态修改失败!!',0);
    	}
    }


    
}
