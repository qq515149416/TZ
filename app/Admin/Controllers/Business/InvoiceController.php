<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Admin\Models\Business\InvoiceModel;
use App\Admin\Models\Business\PayableModel;

use Illuminate\Http\Request;
use App\Admin\Requests\Business\InvoiceRequest;

/**
 * 后台订单控制器
 */
class InvoiceController extends Controller
{

	/**
	 * 为客户添加发票抬头
	 * @param 
	 * @return json 返回添加结果
	 */
	public function insertPayable(InvoiceRequest $request)
	{
		$par = $request->only(['user_id' ,'name' ,'num'  , 'address','tel' ,'bank' , 'bank_acc']);
		
		$model = new PayableModel();

		$res = $model->insertPayable($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户删除邮寄地址
	 * @param 
	 * @return json 返回删除结果
	 */
	public function delPayable(InvoiceRequest $request)
	{
		$par = $request->only(['payable_id']);
		
		$model = new PayableModel();

		$res = $model->delPayable($par['payable_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户编辑邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function editPayable(InvoiceRequest $request)
	{
		$par = $request->only(['payable_id' ,'name' ,'num'  , 'address','tel' ,'bank' , 'bank_acc']);
		
		$model = new PayableModel();

		$res = $model->editPayable($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 展示指定客户的邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function showPayable(InvoiceRequest $request)
	{
		$par = $request->only(['user_id']);
		
		$model = new PayableModel();

		$res = $model->showPayable($par['user_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 生成发票单
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function makeInvoice(InvoiceRequest $request)
	{
		$par = $request->only(['flow_id','type' , 'address_id' , 'payable_id']);
		
		$model = new InvoiceModel();

		$res = $model->makeInvoice($par['flow_id'] , $par['type'] , $par['address_id'] , $par['payable_id']  );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

}
