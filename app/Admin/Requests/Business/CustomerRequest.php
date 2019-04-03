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

class CustomerRequest extends FormRequest
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
				$return = [
					'email'		=> 'required',
				];
		// 		break;
			
		// 	default:
	
		// 		break;
		// }

		return $return;
	}

	public function messages()
	{
		
		return  [
			'email.required'		=> '需绑定客户的信息必须填写(如:用户名/昵称/邮箱等信息)',
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