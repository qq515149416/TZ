<?php


namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddressRequest extends FormRequest
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
					'user_id'			=> 'required|exists:tz_users,id',
					'address'		=> 'required',
				];
				break;
			case 'del':
				$return = [
					'address_id'		=> 'required|exists:tz_address,id',
				];
				break;
			case 'edit':
				$return = [
					'address_id'		=> 'required|exists:tz_address,id',
					'address'		=> 'required',
				];
				break;
			case 'show':
				$return = [
					'user_id'			=> 'required|exists:tz_users,id',
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
			'user_id.required'		=> '请选择客户',
			'user_id.exists'			=> '客户不存在',
			'address.required'		=> '请填写邮寄地址',	
			'address_id.exists'		=> '地址不存在',

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
