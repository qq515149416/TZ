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
     * 查找工单的信息(管理人员/网维人员/网管人员)
     * @return json           返回相关的数据和状态信息
     */
    public function showWorkOrder(Request $request){
    	
    		$where = $request->only(['work_order_status']);
    		$showworkorder = new WorkOrderModel();
    		$return = $showworkorder->showWorkOrder($where);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    		
    }

    /**
     * 查找工单的信息(业务员)
     * @return json           返回相关的数据和状态信息
     */
    public function clerkWorkOrder(Request $request){
        
            $where = $request->only(['work_order_status']);
            $showworkorder = new WorkOrderModel();
            $return = $showworkorder->showWorkOrder($where);
            return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
         
    }

    /**
     * 查找工单的信息(各地机房人员)
     * @return json           返回相关的数据和状态信息
     */
    public function areaWorkOrder(Request $request){
       
            $where = $request->only(['work_order_status']);
            $showworkorder = new WorkOrderModel();
            $return = $showworkorder->showWorkOrder($where);
            return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
         
    }

    /**
     * 内部提交工单
     * @return json 将相关的状态和信息提示返回
     */
    public function insertWorkOrder(Request $request){
    	
    		$data = $request->only(['customer_id','customer_name','mac_num','mac_ip','work_order_content','work_order_type']);
    		$insertwork = new WorkOrderModel();
    		$return = $insertwork->insertWorkOrder($data);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	
    }

    /**
     * 修改工单的状态或者处理部门
     * @param  Request $request 
     * @return json           返回相关的状态和提示信息
     */
    public function editWorkOrder(Request $request){
    	
    		$editdata = $request->only(['id','work_order_status','process_department','summary']);
    		$editworkorder = new WorkOrderModel();
    		$return = $editworkorder->editWorkOrder($editdata);
    		return tz_ajax_echo($return,$return['msg'],$return['code']);
    	
    }

    /**
     * 删除对应的工单信息
     * @param  Request $request [description]
     * @return json          相关的信息提示和状态返回
     */
    public function deleteWorkOrder(Request $request){
        
            $delete = $request->get('delete_id');
            $deleted = new WorkOrderModel();
            $result = $deleted->deleteWorkOrder($delete);
            return tz_ajax_echo($result,$result['msg'],$result['code']);
        
    }


    
}
