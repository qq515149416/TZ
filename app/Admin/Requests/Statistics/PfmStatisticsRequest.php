<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: IP地址表的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:09:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Statistics;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class PfmStatisticsRequest extends FormRequest
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
			case 'pfmBig':
				$return = [
					'begin'       	=> 'required|integer',
					'end'   		=> 'required|integer',
				];
				break;
		
			default:
				$return = [
					'begin'       	=> 'required|integer',
					'end'   		=> 'required|integer',
				];
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
