<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: IP地址表的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:09:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class UploadRequest extends FormRequest
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
			case 'putImages':
				$return = [
					
				];
				break;
			
			default:
				
				break;
		}

		return $return;
		return [

			'title'		=> 'required|max:50',
			'content'	=> 'required|min:30',
			'digest'		=> 'required',
			'list_order'	=> 'numeric',
		];
	}

	public function messages()
	{
		
		return  [
			'title.required' 		=> '标题必须填写',
			'title.max' 		=> '标题长度不得超过50字符',
			'content.required' 	=> '内容必须填写',
			'content.min' 		=> '内容长度必须大于30字符',
			'digest.required' 	=> '摘要必须填写',
			'list_order.numeric'	=> '排序必须为数字',
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
