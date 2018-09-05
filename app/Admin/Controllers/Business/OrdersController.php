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
     * 业务员查看订单
     * @return json 返回相关的数据信息和状态及提示
     */
    public function showOrders(){
    	if($request->isMethod('post')){
    		$data = $request->only(['business_sn']);
    		$show = new OrdersModel();
    		$result = $show->showOrders($data);
    		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	} else {
    		return tz_ajax_echo([],'无法获取客户的订单信息',0);
    	}
    }
   
}
