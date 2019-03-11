<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 统计充值情况用控制器的验证器,无卵用
// +----------------------------------------------------------------------
// | @DateTime: 2018-09-18 11:00:56
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RechargeStatisticsRequest extends FormRequest
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
			case 'list':
				$return = [
					'begin'=> 'required|integer',
					'end'		=> 'required|integer',
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
			'begin.required'			=> '请选择开始时间',
			'begin.integer'				=> '请传时间戳',
			'end.required'				=> '请选择结束时间',
			'end.integer'				=> '请传时间戳',
		
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
