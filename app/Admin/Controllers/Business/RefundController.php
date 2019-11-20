<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\RefundModel;
use Illuminate\Http\Request;

/**
 * 后台退款单控制器
 */
class RefundController extends Controller
{
    use ModelForm;

    /**
     * 后台业务员/管理人员通过订单查看退款详情
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showRefund(Request $request){
    	$order_num = $request->only(['refund_order']);
    	$refund = new RefundModel();
    	$refund_result = $refund->showRefund($order_num);
    	return tz_ajax_echo($refund_result['data'],$refund_result['msg'],$refund_result['code']);
    }

    /**
     * 财务根据订单查看退款单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function financeRefund(Request $request){
    	$order_num = $request->only(['refund_order']);
    	$refund = new RefundModel();
    	$refund_result = $refund->financeRefund($order_num);
    	return tz_ajax_echo($refund_result['data'],$refund_result['msg'],$refund_result['code']);
    }

    /**
     * 申请退款
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertRefund(Request $request){
    	$refund_order = $request->only(['refund_order','refund_reason']);
    	$refund = new RefundModel();
    	$refund_result = $refund->insertRefund($refund_order);
    	return tz_ajax_echo($refund_result,$refund['msg'],$refund['code']);
    }

    /**
     * 审核退款单
     * @param  Request $request refund_num退款单号 refund_status审核状态通过/不通过 refund_note不通过备注
     * @return [type]           [description]
     */
    public function checkRefund(Request $request){ 
        $check_param = $request->only(['refund_num','refund_status','refund_note']);
        $check = new RefundModel();
        $check_result = $check->checkRefund($check_param);
        return tz_ajax_echo($check_result,$check_result['msg'],$check_result['code']);
    }

    /**
     * 申请取消退款
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function cancelRefund(Request $request){
    	$cancel_order = $request->only(['cancel_refund']);
    	$cancel = new RefundModel();
    	$cancel_result = $cancel->cancelRefund($cancel_order);
    	return tz_ajax_echo($cancel_result,$cancel_result['msg'],$cancel_result['code']);
    }

    /**
     * 删除退款订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteRefund(Request $request){
    	$delete_refund = $request->only(['delete_refund']);
    	$delete = new RefundModel();
    	$delete_result = $delete->deleteRefund($delete_refund);
    	return tz_ajax_echo($delete_result,$delete_result['msg'],$delete_result['code']);
    }
}   
