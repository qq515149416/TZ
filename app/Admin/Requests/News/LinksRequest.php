<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 
// +----------------------------------------------------------------------
// | Description: 友情链接的验证器
// +----------------------------------------------------------------------
// | @DateTime: 2019-04-25 10:19:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LinksRequest extends FormRequest
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
		
			case 'insert':
				$return = [
					'name'			=> 'required',	
					'url'			=> 'required|url',
					'order'			=> 'integer',	
				];
				break;
			case 'del':
				$return = [
					'del_id'			=> 'required',			
				];
				break;
			case 'edit':
				$return = [
					'edit_id'			=> 'required',			
				];
				break;
			case 'show':
				$return = [
							
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
			'name.required'		=> '请填写友情链接名称',
			'url.required'		=> '请填写友情链接地址',
			'order.integer'		=> '排序格式错误',
			'url.url'			=> 'url格式错误',
			'del_id.required'		=> '请提供需删除id',
			'edit_id.required'	=> '请提供需编辑id',
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
