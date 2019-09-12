<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 内存资源库的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:43:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class MemoryRequest extends FormRequest
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
		//检测表单中是否存在id,并靠此决定验证规则
		$return = [
			'memory_number'	=> ['required',
                                    Rule::unique('idc_memory','memory_number')->ignore(Request()->id)->where(function($query){
                                        $query->whereNull('deleted_at');
                                    })
                                ],
			'memory_param'	=> 'required',
			'room_id'                 	=> 'required',
		];

		return $return;
	}

	public function messages()
	{
		
		return  [
			'memory_number.required'    	=> '内存编号必须填写',
			'memory_number.unique'	=> '该编号内存已录入',
			'memory_param.required'	=> '内存参数必须填写',
			'room_id.required'		=> '请选择所属机房',
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
