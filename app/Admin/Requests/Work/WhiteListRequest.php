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
		$return = [
			'method'	=> 'required',
		];
		$info = $this->all();
		if(isset($info['method'])){
			$method = $info['method'];
		}else{
			$method = '';
		}
		
		if($method == 'checkIP'){
			$return = [
				'ip'		=> 'required|ip',
			];
		}
		if($method == 'insertWhiteList'){
			$return = [
				'white_ip'		=> 'required|ip',
				'domain_name'		=> 'required',
				'record_number'	=> 'required',
				'binding_machine'	=> 'required',
				'customer_id'		=> 'required',
				'customer_name'	=> 'required',
			];
		}
		if($method == 'checkWhiteList'){
			$return = [
				'white_status'		=> 'required',
				'id'			=> 'required',
			];
		}
		if($method == 'deleteWhiteList'){
			$return = [
				'delete_id'		=> 'required',
			];
		}
		if($method == 'showWhiteList'){
			$return = [
				'white_status'		=> 'required',
			];
		}
		return $return;
	}

	public function messages()
	{
		
		return  [
			'method.required'		=> '请填写所需方法',
			'ip.required' 			=> 'ip地址必须填写',
			'ip.ip' 				=> 'ip地址格式错误',
			'white_ip.required'		=> 'ip地址必须填写',
			'white_ip.ip'			=> 'ip地址格式错误',
			'domain_name.required'		=> '域名必须填写',
			'record_number.required'	=> '备案编号必须填写',
			'binding_machine.required'	=> '机器编号必须填写',
			'customer_id.required'		=> '客户id必须填写',
			'customer_name.required'	=> '客户姓名必须填写',
			'white_status.required'		=> '审核状态必须填写',
			'id.required'			=> '请提供所需审核的id',
			'delete_id.required'		=> '请提供所需删除的id',
			'white_status.required'		=> '请提供所需查询的审核单状态',
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
