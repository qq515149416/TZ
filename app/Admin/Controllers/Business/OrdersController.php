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
		// $data = $request->only(['order_status','customer_id']);
		$finance = new OrdersModel();
		// dd($data);
		// $par = [];
		// foreach ($data as $k => $v) {
		// 	$par['tz_orders.'.$k] = $v;
		// }
		$data = $request->only(['begin','end']);
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
		$insert_data = $request->only(['business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','duration','resource_id']);
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
		$renew_order = $request->only(['session_key']);
		$get_redis = new OrdersModel(); 
		$redis = $get_redis->getRenewRedis($renew_order['session_key']);
		if(!empty($redis)){
			$return['data'] = $redis;
			$return['code'] = 1;
			$return['msg']  = '获取续费信息成功';
		} else {
			$return['data'] = $redis;
			$return['code'] = 0;
			$return['msg']  = '无此续费信息,请确认无误!';
		}
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
	}

	/**
	 * 支付续费的订单
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function renewPay(Request $request){
		$pay = $request->only(['session_key']);
		$renew_pay = new OrdersModel();
		$pay_result = $renew_pay->renewPay($pay);
		return tz_ajax_echo($pay_result['data'],$pay_result['msg'],$pay_result['code']);
	}


	/**
	* 业务员替客户对业务进行付款
	* @return json 返回相关的信息
	*/

	public function payOrderByAdmin(OrdersRequest $request){

		$par = $request->only(['order_id','coupon_id']);
		$order_id = $par['order_id'];
		// $coupon_id = $par['coupon_id'];
		// dd($order_id);
		if(!is_array($order_id)){
			return tz_ajax_echo([],'订单id格式错误',0);
		}
		$model = new OrdersModel();
		$pay = $model->payOrderByBalance($order_id,0);
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

	/**
	 * 旧数据的转换
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	// public function tranOrders(Request $request){
	// 	$tran = $request->only(['business_sn']);
	// 	$do_tran = new OrdersModel();
	// 	$do_result = $do_tran->tranOrders($tran);
	// 	return tz_ajax_echo($do_result['data'],$do_result['msg'],$do_result['code']);
	// }

	/**
	 * 信安代为录入相关的资源
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function securityInsertOrders(Request $request){
		$insert = $request->only(['customer_id','sales_id','business_id','resource_id','resource_type','price','duration','order_note']);
		$security_insert = new OrdersModel();
		$insert_result = $security_insert->securityInsertOrders($insert);
		return tz_ajax_echo($insert_result['data'],$insert_result['msg'],$insert_result['code']);
	}

	/**
	 * 根据条件获取符合条件的资源
	 * @return [type] [description]
	 */
	public function getResource(Request $request){
		$get = $request->only(['order_id','resource_type','machineroom','ip_company']);
		$get_resource = new OrdersModel();
		$get_result = $get_resource->getResource($get);
		return tz_ajax_echo($get_result['data'],$get_result['msg'],$get_result['code']);
	}

	/**
	 * 更换资源
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function changeResource(Request $request){
		$change = $request->only(['order_id','resource_type','resource_id','change_reason']);
		$change_resource = new OrdersModel();
		$change_result = $change_resource->changeResource($change);
		return tz_ajax_echo($change_result['data'],$change_result['msg'],$change_result['code']);
	}

	/**
	 * 审核更换资源
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function checkChange(Request $request){
		$check = $request->only(['change_id','change_status','check_note']);
		$chenck_resource = new OrdersModel();
		$check_result = $chenck_resource->checkChange($check);
		return tz_ajax_echo($check_result['data'],$check_result['msg'],$check_result['code']);
	}

	/**
	 * 获取更换资源记录
	 * @return [type] [description]
	 */
	public function getChange(Request $request){
		$data = $request->only(['order_id']);
		$get_change = new OrdersModel();
		$get_result = $get_change->getChange($data);
		return tz_ajax_echo($get_result['data'],$get_result['msg'],$get_result['code']);
	}

	/**
	 * 获取相关的可更换的订单
	 * @param  Request $request --business_sn业务号,--resource_type资源类型
	 * @return [type]           [description]
	 */
	public function getOrders(Request $request){
		$get_orders = $request->only(['business_sn','resource_type']);
		$get = new OrdersModel();
		$get_result = $get->getOrders($get_orders);
		return tz_ajax_echo($get_result['data'],$get_result['msg'],$get_result['code']);
	}

}
