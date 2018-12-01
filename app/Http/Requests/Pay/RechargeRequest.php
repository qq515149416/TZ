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

namespace App\Http\Requests\Pay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RechargeRequest extends FormRequest
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
			case 'goToPay':
				$return = [
					'trade_id'		=> 'required',
					'way'			=> 'required',
				];
				break;
 			case 'getOrder':
				$return = [
					'trade_no'		=> 'required',
				];
				break;
			case 'checkRechargeOrder':
				$return = [
					'trade_no'		=> 'required',
				];
				break;
			case 'delOrder':
				$return = [
					'del_trade_id'		=> 'required',
				];
				break;
			// case 'payIndex':
			// 	$return = [
			// 		'total_amount'		=> 'required|integer|min:1.00',
			// 	];
			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'trade_id.required'	=> '请提供所需支付充值订单号',
			'way.required'		=> '请选择支付途径',
			'trade_no.required'	=> '请提供所需查询充值单号',
			'del_trade_id.required'	=> '请提供所需删除充值单号',
			'total_amount.required'=> '请填写充值金额',
			'total_amount.integer'	=> '充值金额必须为整数',
			'total_amount.min'	=> '充值金额最少为1元',
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
