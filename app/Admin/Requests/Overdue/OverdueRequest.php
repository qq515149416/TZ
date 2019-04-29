<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 白名单的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-13 14:09:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Overdue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OverdueRequest extends FormRequest
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
			case 'showOverdueResDet':
				$return = [
					'resource_type' 		=> 'required',
				];
				break;
			case 'showOverdueResDetX':
				$return = [
					'resource_type' 		=> 'required',
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
			'resource_type.required' 			=> '必须提供查询类型',
			
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
