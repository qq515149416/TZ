<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 用户业务表验证规则
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Http\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WorkOrderRequest extends FormRequest
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

		switch ($method) {
			case 'insert':
				$return = [
					'mac_num'		=> 'required',
					'mac_ip'		=> 'required|ip',
					'work_order_content'	=> 'required',	
					'work_order_type'	=> 'required',
				];
				break;

			case 'del':
				$return = [
					'delete_id'		=> 'required',
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
			'mac_num.required'		=> '机器编号必须填写',
			'mac_ip.required'		=> '关联IP必须填写',
			'mac_ip.ip'			=> 'IP格式有误',
			'work_order_content.required'	=> '工单内容必须填写',
			'work_order_type.required'	=> '工单类型必须填写',
			'delete_id.required'		=> '请提供需要删除的工单id',
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
