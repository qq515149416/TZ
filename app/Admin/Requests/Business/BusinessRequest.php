<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 支付控制器用验证规则
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BusinessRequest extends FormRequest
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
		// $path_info = Request()->getPathInfo();
		// $arr = explode('/',$path_info);
		// $method = $arr[count($arr)-1];
		// $return = [];

		// switch ($method) {
		// 	case 'recharge':
		// 		$return = [
		// 			'user_id'		=> 'required',
		// 			'recharge_amount'	=> 'required|integer|min:1.00',
		// 			'recharge_way'		=> 'required',		
		// 		];
		// 		break;
			
		// 	default:
	
		// 		break;
		// }
		$return = [
				'length' => 'required|integer',

		];

		return $return;
	}

	public function messages()
	{
		
		return  [
			'length.required'		=> '租用时长必须填写',
			// 'recharge_amount.required'	=> '请填写充值金额',
			'length.integer'	=> '时长填写必须是整数数字',
			// 'recharge_amount.min'		=> '充值金额最少为1元',
			// 'recharge_way.required'	=> '请选择付款方式',
		];
	}

	/**
	 * 重新定义数据字段返回的提示信息
	 */
	public function failedValidation(Validator $validator) {
		$msg = $validator->errors()->first();
		header('Content-type:application/json');
        header('Cache-control:no-cache');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
	}
}
