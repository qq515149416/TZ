<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\OrdersModel;
use Illuminate\Http\Request;

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
     * 对资源进行续费
     * @param  Request $request [description]
     * @return json           续费的反馈信息和提示
     */
    public function renewResource(Request $request){
        $renew_data = $request->only(['business_number','order_sn','price','length','order_note','client_id','resource_type']);
        $renew = new OrdersModel();
        $renew_resource = $renew->renewResource($renew_data);
        return tz_ajax_echo($renew_resource,$renew_resource['msg'],$renew_resource['code']);
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
   
}
