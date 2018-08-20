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

namespace App\Admin\Requests\Memory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
			'memory_number'	=> "required|unique:idc_memory",
			'memory_param'	=> 'required',
			'room_id'                 	=> 'required',
		];
		$info = $this->all();

		if(isset($info['id'])){
			$return['memory_number'].=",memory_number,{$info['id']}";
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'memory_number.required'    	=> '硬盘编号必须填写',
			'memory_number.unique'	=> '该编号硬盘已录入',
			'memory_param.required'	=> '硬盘参数必须填写',
			'room_id.required'		=> '请选择所属机房',
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
