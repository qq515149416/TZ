<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 用户订单表验证规则
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrderRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * 规则.
	 *
	 * @return array
	 */
	public function rules()
	{
		$path_info = Request()->getPathInfo();
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$return = [];

		switch ($method) {
			case 'payOrderByBalance':
				$return = [
					'serial_number'		=> 'required',
				];
				break;
			case 'makeTrade':
				$return = [
					'order_id'		=> 'required|array',
					'coupon_id'		=> 'required',
				];
				break;
 			
			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'serial_number.required'	=> '请提供所需支付的支付流水号',
			'order_id.required'		=> '请提供所需支付订单id',
			'order_id.array'			=> '订单id必须为数组格式',
			'coupon_id.required'		=> '请提供优惠券id,0为不使用',
		];
	}

	/**
	 * 重新定义数据字段返回的提示信息
	 */
	public function failedValidation(Validator $validator) {
		$msg = $validator->errors()->first();
		header('Content-type:application/json');
		exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
	}
}
