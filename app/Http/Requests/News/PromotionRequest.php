<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 
// +----------------------------------------------------------------------
// | Description: 促销活动的验证器
// +----------------------------------------------------------------------
// | @DateTime: 2019-04-25 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PromotionRequest extends FormRequest
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
		//获取路由
		$path_info = Request()->getPathInfo();
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$return = [];

		//根据路由选择验证规则
		switch ($method) {
		
			case 'getPro':
				$return = [
				
					'need'		=> 'required',	

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
			'need.required'		=> '请填写需求',
			
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
