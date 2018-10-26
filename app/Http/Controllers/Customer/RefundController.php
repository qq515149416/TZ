<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Customer\RefundModel;
use Illuminate\Support\Facades\Auth;

/**
 * 前台退款相关接口
 */
class RefundController extends Controller
{
    //
    /**
     * 客户通过订单查看退款详情
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
