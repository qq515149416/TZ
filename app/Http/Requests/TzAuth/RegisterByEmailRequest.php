<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterByEmailRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
//        return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
			'email'                 => 'required|email|unique:tz_users,email',
			'password'              => 'required|min:8|max:20|string|confirmed',
			'password_confirmation' => 'required',   //
			'msg_phone'		=> 'required',
			'msg_qq'		=> 'required',
		];
	}

	/**
	 * 验证错误返回的信息
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'email.required'                  => '邮箱帐号必须填写',
			'email.email'                    => '邮箱格式错误',
			'email.unique'                   => '此邮箱已被注册过',
			'password.required'              => '密码不能为空',
			'password.min'                   => '密码在8到20位之间',
			'password.max'                   => '密码在8到20位之间',
			'password.confirmed'             => '密码两次输入不一致',
			'password_confirmation.required' => '密码二次输入不能为空',
			'msg_phone.required'            => '联系电话必须填写',
			'msg_qq.required'            	=> '联系QQ必须填写',
		];
	}

	/**
	 * use Illuminate\Contracts\Validation\Validator;
	 * @param Validator $validator
	 */
	public function failedValidation(Validator $validator)
	{
		$msg = $validator->errors()->first();
		header('Content-type:application/json');
		header('Cache-control:no-cache');
		exit('{"code": 0,"data":[],"msg":"'.$msg.'"}');
	}


}
