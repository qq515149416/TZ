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

namespace App\Admin\Requests\News;

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
		
			case 'insert':
				$return = [
				
					'order'			=> 'integer',	
					'img'			=> 'required',
					 'link'			=> 'required|url',		
					 'title'			=> 'required',
					 'top'			=> 'integer|min:0|max:1',
					 'digest'			=> 'required',
					 'end_at'		=> 'required|date',
				];
				break;
			case 'del':
				$return = [
					'del_id'			=> 'required|exists:tz_promotion,id',			
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
			'img.required'		=> '请填写图片地址',
			'link.required'		=> '请填写跳转链接地址',
			'order.integer'		=> '排序格式错误',
			'link.url'			=> '链接格式错误',
			'title.required'		=> '请填写活动标题',
			'digest.required'		=> '请填写活动摘要',
			'end_at.required'	=> '请填写活动结束时间',
			'end_at.date'		=> '活动结束时间格式错误',
			'top.integer'		=> '置顶状态:0-不置顶 ; 1-置顶',
			'top.min'		=> '置顶状态:0-不置顶 ; 1-置顶',
			'top.max'		=> '置顶状态:0-不置顶 ; 1-置顶',
			'del_id.required'		=> '请提供需删除id',
			'del_id.exists'		=> '请提供准确id',
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
