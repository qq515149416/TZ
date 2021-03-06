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
					'business_type'	=> 'required',
				];
				break;
			case 'getConsumption':
				$return = [
					'need'       	=> 'required|in:1,2,3',
				];
				break;
			case 'getConsumptionDetailed':
			case 'getConsumptionExcel':
				$return = [
					'month'       	=> 'required',
				];
				break;
			case 'getOrderByFlowId':
				$return = [
					'flow_id'       	=> 'required|exists:tz_orders_flow,id',
				];
				break;
			
			default:
				$return = [
					'begin'       	=> 'required|integer',
					'end'   		=> 'required|integer',
					'business_type'	=> 'required',
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
			'business_type.required'		=> '请选择业务类型',
			'need.required'			=> '请明确需求',
			'need.in'			=> '1 - 今日 ; 2 - 本月 ; 3 - 上月',
			'month.required'		=> '请提供查询月份',
			'flow_id.required'		=> '请提供流水id',
			'flow_id.exists'			=> '流水id不存在',
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
