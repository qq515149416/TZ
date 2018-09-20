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
        $array_path = explode('/',$path_info);
        $count_path = count($array_path);

        if($array_path[$count_path-1] == 'checkIP'){
            return [
            	'ip' => 'required|ip',
            ];
        } elseif($array_path[$count_path-1] == 'show'){
            return [
                'white_status' => 'required|integer|min:0|max:4',
            ];
        } elseif($array_path[$count_path-1] == 'insert'){
			return [
                'white_ip' => 'required|ip',
                'domain_name' => [
                    'required',
                    'regex:',
                ],
                'record_number' => 'required',
                'binding_machine' => 'required',
                'customer_id' => 'required|integer',
                'customer_name' => 'required',
			];
        } elseif($array_path[$count_path-1] == 'check'){
        	return [
                'white_status' => 'required|integer|min:0|max:4',
                'id' => 'required|integer',
            ];
        }

	}

	public function messages()
	{
		
		return  [
			'ip.required' 			=> 'IP地址必须填写',
			'ip.ip' 				=> 'IP地址必须符合IP规范(如:192.168.1.1)',
			'white_status.required' => '白名单状态必须选择',
			'white_status.integer' => '白名单状态必须为0~4的正整数',
			'white_status.min' => '白名单状态必须为0~4的正整数',
			'white_status.max' => '白名单状态必须为0~4的正整数',
			'white_ip.required'		=> 'IP地址必须填写',
			'white_ip.ip'			=> 'IP地址必须符合IP规范(如:192.168.1.1)',
			'domain_name.required'		=> '域名必须填写',
			'record_number.required'	=> '备案编号必须填写',
			'binding_machine.required'	=> '机器编号必须填写',
			'customer_id.required'		=> '客户编号必须填写',
			'customer_id.integer' => '客户编号必须为正整数',
			'customer_name.required'	=> '客户姓名必须填写',
			'id.required'			=> '请提供所需审核的编号',
			'id.integer' => '审核所需的编号必须为正整数',
			
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
