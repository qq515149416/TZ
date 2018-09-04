<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\OrdersModel;
// 选择机房时使用
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Requests\Business\BusinessRequest;
use Illuminate\Http\Request;

/**
 * 后台订单控制器后台
 */
class OrdersController extends Controller
{
    use ModelForm;

    /**
     * 在下订单前先选择机房，根据机房去查找对应机房的机器/机柜(App\Admin\Models\Idc\MachineModel@machineroom)
     * @return json 返回机房相关的数据和状态信息
     */
    public function machineroom(){
    	$machineroom = new MachineModel();
    	$return = $machineroom->machineroom();
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 在下订单前根据选择的机房，查找对应机房的机器/机柜(App\Admin\Models\Idc\MachineModel@selectMachine)
     * @param  Request $request [description]
     * @return json           返回对应机房的信息或者数据
     */
    public function selectMachine(Request $request){
    	if($request->isMethod('post')){
    		$where = $request->only(['machineroom','business_type']);
    		$machine = new MachineModel();
    		$return = $machine->selectMachine($where);
    		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取机器',0);
    	}
    }

    /**
     * 进行订单的创建
     * @param  Request $request [description]
     * @return json           返回订单创建的提示信息
     */
    public function insertOrders(Request $request){
    	if($request->isMethod('post')){
    		$insertdata = $request->only(['customer_id','customer_name','business_id','business_name','machine_sn','price','duration','order_note','after_resource','resource_type']);
    		$insert = new OrdersModel();
    		$result = $insert->insertOrders($insertdata);
    		return tz_ajax_echo($result['data'],$$result['msg'],$$result['code']);
    	} else {
    		return tz_ajax_echo([],'订单无法创建',0);
    	}
    }

    /**
     * 后台手动生成业务编号，针对后付费客户群体
     * @param  Request $request [description]
     * @return json           返回生成业务编号的提示信息
     */
    public function generateBusiness(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->only(['order_sn','duration','machine_sn','id','price','resource','customer_id','customer_name','business_id','business_name']);
    		$generate = new OrdersModel();
    		$result = $generate->generateBusiness($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法生成业务编号',0);
    	}
    }

    /**
     * 财务查看订单接口
     * @return json 返回订单的相关数据和状态信息和状态
     */
    public function financeOrders(){
    	if($request->isMethod('post')){
    		$data = $request->only(['order_status']);
    		$finance = new OrdersModel();
    		$result = $finance->financeOrders($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取订单信息',0);
    	}
    }

    /**
     * 管理人员查看订单接口
     * @return json 返回订单的相关数据和状态信息和状态
     */
    public function adminOrders(){
    	if($request->isMethod('post')){
    		$data = $request->only(['order_status']);
    		$admin = new OrdersModel();
    		$result = $admin->adminOrders($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取订单信息',0);
    	}
    }

    /**
     * 业务员查看订单
     * @return json 返回相关的数据信息和状态及提示
     */
    public function clerkOrders(){
    	if($request->isMethod('post')){
    		$data = $request->only(['customer_id']);
    		$clerk = new OrdersModel();
    		$result = $clerk->clerkOrders($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取客户的订单信息',0);
    	}
    }
   
}
