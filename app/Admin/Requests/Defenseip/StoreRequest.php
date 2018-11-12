<?php

namespace App\Admin\Requests\Defenseip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
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
			case 'insert':
				$return = [
					'ip'			=> 'required|array',
					'protection_value'	=> 'required|integer',
					'site'			=> 'required',		
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
			'ip.required'			=> '请填写ip地址',
			'protection_value.required'	=> '请填写ip防护值',
			'site.required'			=> '请填写所属机房,1为西安',
			'ip.array'			=> 'ip请用数组格式传值',
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
