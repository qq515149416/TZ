<?php

namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TzUserRequest extends FormRequest
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
		$return = [];
		if(Request()->name != null){
			$return = [
				'name' => 'sometimes|unique:tz_users,name,'.Request()->uid.',id',	
			];
		}
		if(Request()->nickname != null){
			$return = [
				'name' => 'sometimes|unique:tz_users,nickname,'.Request()->uid.',id',	
			];
		}
		return $return;
		
	}

	public function messages()
	{
		
		return  [
			'name.unique'		=> '用户名已存在',
			'nickname.unique'   => '昵称已存在',
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
