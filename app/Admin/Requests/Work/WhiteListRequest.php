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

namespace App\Admin\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WhiteListRequest extends FormRequest
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
			case 'checkIP':
				$return = [
					'ip' 			=> 'required|ip',
				];
				break;
			case 'show':
				$return = [
					'white_status' => 'required|integer|min:0|max:4',
				];
				break;
			case 'insert':
				$return = [
					'white_ip' => 'required|ip',
					'domain_name' => [
						'required',
						'regex:#^(?!www|http)\w+(.\w+)+\w*$#',
					],
					// 'record_number' => 'required',
					];
				break;
			case 'check':
				$return = [
					'white_status' => 'required|integer|min:1|max:3',
					'id' => 'required|exists:tz_white_list,id',
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
			'ip.required' 			=> 'IP地址必须填写',
			'ip.ip' 				=> 'IP地址必须符合IP规范(如:192.168.1.1)',
			'white_status.required' 		=> '白名单状态必须选择',
			'white_status.integer' 		=> '白名单状态 : 1-通过,2-不通过,3-拉黑',
			'white_status.min' 		=> '白名单状态 : 1-通过,2-不通过,3-拉黑',
			'white_status.max' 		=> '白名单状态 : 1-通过,2-不通过,3-拉黑',
			'white_ip.required'		=> 'IP地址必须填写',
			'white_ip.ip'			=> 'IP地址必须符合IP规范(如:192.168.1.1)',
			'domain_name.required'	=> '域名必须填写',
			'domain_name.regex'		=> '域名格式错误,勿填 : http:// ; https ; www ; / ;',
			'record_number.required'	=> '备案编号必须填写',
			'binding_machine.required'	=> '机器编号必须填写',
			'customer_id.required'		=> '客户id必须填写',
			'customer_id.integer' 		=> '客户id必须为正整数',
			'customer_id.exists' 		=> '客户id不存在',
			'customer_name.required'	=> '客户姓名必须填写',
			'id.required'			=> '请提供所需审核的编号',
			'id.exists' 			=> '审核单id不存在',
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
