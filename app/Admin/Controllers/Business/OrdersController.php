<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\OrdersModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\OrdersRequest;
use Illuminate\Support\Facades\Validator;

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
		$data = $request->only(['business_sn','resource_type','id']);
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
	 * @param  Request $request --business_sn-要绑定的业务号,--customer_id-客户id,--resource_type-资源类型,--price-单价,--duration--时长,--resource_id--资源id
	 * @return [type]           [description]
	 */
	public function insertResource(Request $request){
		$insert_data = $request->only(['business_sn','customer_id','resource_type','price','duration','resource_id']);

		/**
         * 检验添加资源时时长是否填写
         * @var [type]
         */
        $rules = ['duration' => 'required|integer','price'=>'required|numeric'];
        $messages = ['duration.required'=> '租用时长必须填写','duration.integer'=>'时长填写必须是整数数字','price.required'=>'资源单价必须填写','price.numeric'=>'资源单价必须是数字'];
        $validator = Validator::make($insert_data,$rules,$messages);
        if($validator->messages()->first()){
            return tz_ajax_echo('',$validator->messages()->first(),0);
        }

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
		$renew_data = $request->only(['orders','length','order_note','business_number','cabinet_machine']);

		/**
         * 检验续费时时时长是否填写
         * @var [type]
         */
        $rules = ['length' => 'required|integer'];
        $messages = ['length.required'=> '租用时长必须填写','length.integer'=>'时长填写必须是整数数字'];
        $validator = Validator::make($renew_data,$rules,$messages);
        if($validator->messages()->first()){
            return tz_ajax_echo('',$validator->messages()->first(),0);
        }

		$renew = new OrdersModel();
		$renew_resource = $renew->renewResource($renew_data);
		return tz_ajax_echo($renew_resource['data'],$renew_resource['msg'],$renew_resource['code']);
	}       
                                                                                     
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
		$get = $request->only(['order_id','resource_type','machineroom','ip_company','parent_business']);
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
		$change = $request->only(['order_id','resource_type','resource_id','change_reason','parent_business']);

		/**
         * 检验更换理由是否填写
         * @var [type]
         */
        $rules = ['change_reason'=>'required'];
        $messages = ['change_reason.required'=>'更换理由必须填写'];
        $validator = Validator::make($change,$rules,$messages);
        if($validator->messages()->first()){
            return tz_ajax_echo('',$validator->messages()->first(),0);
        }

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
		$check = $request->only(['change_id','change_status','check_note','parent_business']);
		$chenck_resource = new OrdersModel();
		$check_result = $chenck_resource->checkChange($check);
		return tz_ajax_echo($check_result['data'],$check_result['msg'],$check_result['code']);
	}

	/**
	 * 获取更换资源记录
	 * @return [type] [description]
	 */
	public function getChange(Request $request){
		$data = $request->only(['order_id','parent_business']);
		$get_change = new OrdersModel();
		$get_result = $get_change->getChange($data);
		return tz_ajax_echo($get_result['data'],$get_result['msg'],$get_result['code']);
	}
	
	/**
	 * 修改订单的价格/到期时间
	 * @param  Request $request --id订单id,--price单价,--end_time到期时间
	 * @return [type]           [description]
	 */
	public function updateOrders(Request $request){
		$data = $request->only(['id','price','end_time','monthly']);
		$update = new OrdersModel();
		$result = $update->updateOrders($data);
		return tz_ajax_echo($result,$result['msg'],$result['code']);
	}


	/**
	 * 根据订单号获取指定订单资源详情
	 * @param  Request $request 
	 * @return 
	 */
	public function showOrderDetail(OrdersRequest $request){
		$par = $request->only(['order_sn']);
		
		$update = new OrdersModel();
		$res = $update->showOrderDetail($par['order_sn']);
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
