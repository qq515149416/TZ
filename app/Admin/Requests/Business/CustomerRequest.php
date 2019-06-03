<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 支付控制器用验证规则
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-27 10:19:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CustomerRequest extends FormRequest
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
		 	case 'insert_clerk':
				$return = [
					'email'		=> 'required',
				];
		 		break;
			
		 	case 'register':
				$return = [
					'name'		=> 'required|unique:tz_users,name',
					'nickname'  => 'required|unique:tz_users,nickname',
					'password'              => 'required|min:8|max:20|string|confirmed',
            		'password_confirmation' => 'required', 
				];
		 		break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'email.required'		=> '需绑定客户的信息必须填写(如:用户名/昵称/邮箱等信息)',
			'name.required'    => '用户名必须填写',
			'nickname.required' => '昵称必须填写',
			'name.unique' => '用户名已存在',
			'nickname.unique' => '昵称已存在',
			'password.required' => '账户密码必须填写',
			'password.min' => '密码位数在8位-20位之间',
			'password.max' => '密码位数在8位-20位之间',
			'password.string' => '密码必须是有效的字符',
			'password.confirmed' => '两次密码不一致',
			'password_confirmation.required' => '密码第二次输入不能为空'
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
