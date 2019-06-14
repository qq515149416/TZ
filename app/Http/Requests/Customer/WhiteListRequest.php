<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

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
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{   
		$path_info = Request()->getPathInfo();
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$return = [];
		$par = $this->only(['edit_id']);
		
		switch ($method) {
			case 'show_white_list':
				$return = [
					'white_status'			=> 'required|integer',
				];
				break;

			case 'insert_white_list':
				$return = [
					'white_ip'			=> 'required|ip',
					'domain_name'			=> 'required',
					'record_number'		=> 'required',
					'binding_machine'		=> 'required',
				];
				break;
			case 'check_domain_name':
				$return = [
					'domain_name'			=> 'required',
				];
				break;
			case 'check_ip':
				$return = [
					'white_ip'			=> 'required|ip',
				];
				break;
			case 'cancel_white_list':
				$return = [
					'cancel_id'			=> 'required|exists:tz_white_list,id',
				];
				break;
			case 'insertWhiteListForDIP':
				$return = [
					'b_num'				=> 'required|exists:tz_defenseip_business,business_number',
					'domain_name'			=> 'required',
					'record_number'		=> 'required',
					
				];
				break;
			default:

				break;
		}

		return $return;
		
	}

	public function messages()
	{
			return [
				'white_ip.required' 		=> 'IP地址必须填写',
				'white_ip.ip' 			=> 'IP地址的填写必须符合IP规范(例如:192.168.1.1)',
				'domain_name.required'		=> '需要绑定的域名必须填写',
				// 'domain_name.regex' => '所填写的域名必须符合域名规范(如:baidu.com)',
				'record_number.required' 	=> '域名的备案编号必须填写',
				'binding_machine.required' 	=> 'IP所属机器编号必须存在',
				'b_num.required'		=> '请填写业务编号',
				'b_num.exists'			=> '业务号不存在或已过期',
				'cancel_id.required'		=> '请填写需取消的申请id',
				'cancel_id.exists'			=> '该申请不存在',
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
