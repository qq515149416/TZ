<?php

namespace App\Admin\Requests\DefenseIp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BusinessRequest extends FormRequest
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
		$par = $this->only(['edit_id']);
		
		switch ($method) {
			
			case 'subExamine':
				$return = [
					'business_id'		=> 'required|exists:tz_defenseip_business,id',	
				];
				break;
			case 'goExamine':
				$return = [
					'business_id'		=> 'required|exists:tz_defenseip_business,id',	
					'status'			=> 'required',
				];
				break;
			case 'showBusinessByPackage':
				$return = [
					'package_id'		=> 'required',
				];
				break;
			case 'showBusinessByCustomer':
				$return = [
					'customer_id'		=> 'required|exists:tz_users,id',
				];
				break;
			case 'upExamineDefenseIp':
				$return = [
					'business_id'		=> 'required|exists:tz_defenseip_business,id',	
					'res'			=> 'required|integer|min:0|max:1',
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
			'business_id.required'			=> '请选择业务id',
			'business_id.exists'			=> '不存在此业务id',
			'status.required'			=> '请选择审核结果',
			'package_id.required'			=> '请提供套餐id',
			'customer_id.required'			=> '请提供用户id',
			'customer_id.exists'			=> '用户id不存在',
			'res.required'				=> '请提供审核结果',
			'res.integer'				=> '审核结果只能为:0-不通过;1-通过',
			'res.min'				=> '审核结果只能为:0-不通过;1-通过',
			'res.max'				=> '审核结果只能为:0-不通过;1-通过',
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
