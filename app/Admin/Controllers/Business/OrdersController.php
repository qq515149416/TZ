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
    public function financeOrders(){
		$data = $request->only(['order_status']);
		$finance = new OrdersModel();
		$result = $finance->financeOrders($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    } 

    /**
     * 业务员和管理人员通过业务查看订单
     * @return json 返回相关的数据信息和状态及提示
     */
    public function clerkOrders(){
    	$data = $request->only(['business_sn']);
		$show = new OrdersModel();
		$result = $show->clerkOrders($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 增加资源时调用
     * @return json 返回相关的数据信息和状态提示
     */
    public function resource(Request $request){
        $resource_data = $request->only(['resource_type','machineroom']);
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
        $insert_data = $request->only(['business_sn','customer_id','customer_name','resource_type','machine_sn','resource','price','duration','end_time']);
        $insert = new OrdersModel();
        $return = $insert->insertResource($insert_data);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']); 
    }

    /**
     * 当填完使用时长后进行到期时间计算比较，不符合不给予通过
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function endTime(Request $request){
        $time = $request->only('duration','endding_time');
        $end_time = new OrdersModel();
        $return = $end_time->endTime($time);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 进行主机及机柜续费操作
     * @param  Request $request [description]
     * @return json           返回相关的状态提示及信息
     */
    public function renewOrders(Request $request){
        $data = $request->only(['business_number','money','length','order_note']);
        $renew = new OrdersModel();
        $result = $renew->renewOrders($data);
        return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 对资源进行续费
     * @param  Request $request [description]
     * @return json           续费的反馈信息和提示
     */
    public function renewResource(Request $request){
        $renew_data = $request->only(['customer_id','customer_name','business_sn','business_id','business_name','resource_type','machine_sn','resource','price','duration','end_time','order_note']);
        $renew = new OrdersModel();
        $renew_resource = $renew->renewResource($renew_data);
        return tz_ajax_echo($renew_resource,$renew_resource['msg'],$renew_resource['code']);
    }


    /**
     * 获取对应业务的增加资源的订单
     * @param  Request $request [description]
     * @return json           返回对应的信息和状态提示及信息
     */
    public function resourceOrders(Request $request){
        $data = $request->only(['business_sn','resource_type']);
        $resource = new OrdersModel();
        $resource_orders = $resource->resourceOrders($data);
        return tz_ajax_echo($resource_orders['data'],$resource_orders['msg'],$resource_orders['code']);
    }
   
}
