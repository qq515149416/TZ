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

			case 'buyNowByAdmin':
				$return = [
					'package_id'		=> 'required|exists:tz_defenseip_package,id',
					'buy_time'		=> 'required|integer|min:1',
					'customer_id'		=> 'required|exists:tz_users,id'
				];
				break;
			case 'renewByAdmin':
				$return = [
					'business_id'		=> 'required|exists:tz_defenseip_business,id',
					'buy_time'		=> 'required|integer|min:1',
				];
			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'business_id.required'			=> '请选择申请下架的业务id',
			'business_id.exists'			=> '不存在此业务id',
			'status.required'			=> '请选择审核结果',
			'package_id.required'			=> '请选择套餐',
			'package_id.exists'			=> '套餐不存在',
			'buy_time.required'			=> '请选择购买时长',
			'buy_time.integer'			=> '购买时长为整数',
			'buy_time.min'				=> '购买时长最少一个月',
			'business_id.required'			=> '请选择续费业务',
			'business_id.exists'			=> '业务不存在',
			'customer_id.required'			=> '请提供客户id',
			'customer_id.exists'			=> '客户id不存在',
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
