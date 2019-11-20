<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Admin\Models\Business\AddressModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\AddressRequest;

/**
 * 后台订单控制器
 */
class AddressController extends Controller
{

	/**
	 * 为客户添加邮寄地址
	 * @param 
	 * @return json 返回添加结果
	 */
	public function insert(AddressRequest $request)
	{
		$par = $request->only(['user_id' , 'address']);
		
		$model = new AddressModel();

		$res = $model->insert($par['user_id'] , $par['address']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户删除邮寄地址
	 * @param 
	 * @return json 返回删除结果
	 */
	public function del(AddressRequest $request)
	{
		$par = $request->only(['address_id']);
		
		$model = new AddressModel();

		$res = $model->del($par['address_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 为客户编辑邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function edit(AddressRequest $request)
	{
		$par = $request->only(['address_id','address']);
		
		$model = new AddressModel();

		$res = $model->edit($par['address_id'],$par['address']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 * 展示指定客户的邮寄地址
	 * @param 
	 * @return json 返回编辑结果
	 */
	public function show(AddressRequest $request)
	{
		$par = $request->only(['user_id']);
		
		$model = new AddressModel();

		$res = $model->show($par['user_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
