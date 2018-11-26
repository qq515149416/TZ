<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\OrdersModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\OrdersRequest;

/**
 * 后台订单控制器
 */
class OrdersController extends Controller
{
    use ModelForm;

    /**
     * 财务和管理人员查看订单接口
     * @return json 返回订单的相关数据和状态信息和状态
     */
    public function financeOrders(Request $request){
		$data = $request->only(['order_status']);
		$finance = new OrdersModel();
		$result = $finance->financeOrders($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 业务员和管理人员通过业务查看订单
     * @return json 返回相关的数据信息和状态及提示
     */
    public function clerkOrders(Request $request){
    	$data = $request->only(['business_sn','resource_type']);
		$show = new OrdersModel();
		$result = $show->clerkOrders($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 增加资源时调用
     * @return json 返回相关的数据信息和状态提示
     */
    public function resource(Request $request){
        $resource_data = $request->only(['resource_type','machineroom','company']);
        $resource = new OrdersModel();
        $return = $resource->resource($resource_data);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 进行资源添加生成订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insertResource(Request $request){
        $insert_data = $request->only(['business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','duration']);
        $insert = new OrdersModel();
        $return = $insert->insertResource($insert_data);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 订单后台删除
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteOrders(Request $request){
        $delete_id = $request->only(['delete_id']);
        $delete = new OrdersModel();
        $return = $delete->deleteOrders($delete_id);
        return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 获取该业务下的其他资源订单数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function allRenew(Request $request){
        $business = $request->only(['business_sn']);
        $order = new OrdersModel();
        $all_result = $order->allRenew($business);
        return tz_ajax_echo($all_result['data'],$all_result['msg'],$all_result['code']);
    }

    /**
     * 进行续费操作
     * @param  Request $request [description]
     * @return json           续费的反馈信息和提示
     */
    public function renewResource(Request $request){
        $renew_data = $request->only(['orders','length','order_note','business_number']);
        $renew = new OrdersModel();
        $renew_resource = $renew->renewResource($renew_data);
        return tz_ajax_echo($renew_resource['data'],$renew_resource['msg'],$renew_resource['code']);
    }

    // /**
    //  * 展示之前续费新生成的订单
    //  * @param  Request $request renew_order -- 续费产生的订单id组合
    //  * @return [type]           [description]
    //  */
    // public function showRenewOrder(Request $request){
    //     $renew_order = $request->only(['renew_order']);//获取续费的订单id
    //     $show_renew = new Order();
    //     $show_renew_result = $show_renew->showRenewOrder($renew_order['renew_order']);
    //     return tz_ajax_echo($show_renew_result['data'],$show_renew_result['msg'],$show_renew_result['code']);
    // }

    /**
     * 展示之前续费新生成的订单
     * @param  Request $request renew_order -- 续费产生的订单id组合
     * @return [type]           [description]
     */
    public function showRenewOrder(Request $request){
        $renew_order = $request->only(['business_sn']);//获取续费的订单id
        $show_renew = new OrdersModel();
        //$renew = isset($renew_order['renew_order'])?$renew_order['renew_order']:$renew_order;
        $show_renew_result = $show_renew->showRenewOrder($renew_order);
        return tz_ajax_echo($show_renew_result['data'],$show_renew_result['msg'],$show_renew_result['code']);
    }


    /**
    * 业务员替客户对业务进行付款
    * @return json 返回相关的信息
    */

    public function payOrderByAdmin(OrdersRequest $request){
        $par = $request->only(['business_number','coupon_id']);
        $business_number = $par['business_number'];
        $coupon_id = $par['coupon_id'];

        $model = new OrdersModel();
        $pay = $model->payOrderByBalance($business_number,$coupon_id);
        return tz_ajax_echo($pay['data'],$pay['msg'],$pay['code']);
    }

    /**
     * 对某个资源进行申请下架接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function applyRemoveResource(Request $request){
        $remove_resource = $request->only(['order_sn','remove_reason']);
        $remove = new OrdersModel();
        $remove_result = $remove->applyRemoveResource($remove_resource);
        return tz_ajax_echo($remove_result,$remove_result['msg'],$remove_result['code']);
    }

    /**
     * 获取资源下架历史记录
     * @return [type] [description]
     */
    public function resourceRemoveHistory(){
        $history = new OrdersModel();
        $history_result = $history->resourceRemoveHistory();
        return tz_ajax_echo($history_result['data'],$history_result['msg'],$history_result['code']);
    }

    /**
     * 修改资源下架的状态
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function editRemoveResource(Request $request){
        $edit = $request->only(['remove_reason','order_sn','remove_status','machineroom']);
        $do_edit = new OrdersModel();
        $edit_result = $do_edit->editRemoveResource($edit);
        return tz_ajax_echo($edit_result,$edit_result['msg'],$edit_result['code']);
    }

}
