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
					'links_order'		=> 'integer',	
					'sort'			=> 'required|in:0,1',
					'image'			=> 'required_if:sort,1',
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
			'name.required'		=> '请填写链接名称',
			'url.required'		=> '请填写链接地址',
			'links_order.integer'	=> '排序格式错误',
			'url.url'			=> 'url格式错误',
			'del_id.required'		=> '请提供需删除id',
			'edit_id.required'	=> '请提供需编辑id',
			'sort.in'			=> '请选择链接种类 0-友情链接 ; 1-轮播图',
			'sort.required'		=> '请选择链接种类 0-友情链接 ; 1-轮播图',
			'image.required_if'	=> '轮播图必须上传图片',
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
