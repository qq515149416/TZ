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

namespace App\Http\Requests\DefenseIp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrderRequest extends FormRequest
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
			case 'buyDefenseIpNow':
				$return = [
					'package_id'		=> 'required|exists:tz_defenseip_package,id',
					'buy_time'		=> 'required|integer|min:1',
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
			'package_id.required'	=> '请选择套餐',
			'package_id.exists'	=> '套餐不存在',
			'buy_time.required'	=> '请选择购买时长',
			'buy_time.integer'	=> '购买时长为整数',
			'buy_time.min'		=> '购买时长最少一个月',
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
