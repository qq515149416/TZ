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

namespace App\Admin\Requests\Business;

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
			case 'recharge':
				$return = [
					'user_id'		=> 'required|exists:tz_users,id',
					'recharge_amount'	=> 'required|integer|min:1.00',
					'recharge_way'		=> 'required',		
				];
				break;
			case 'showAuditRechargeBig':
				$return = [
					'audit_status'		=> 'required|between:-1,1|integer',			
				];
				break;
			case 'showAuditRechargeSmall':
				$return = [
					'audit_status'		=> 'required|between:-1,1|integer',			
				];
				break;
			case 'auditRecharge':
				$return = [
					'audit_status'		=> 'required|between:-1,1|integer',	
					'trade_id'		=> 'required|integer|exists:tz_recharge_admin,id',		
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
			'user_id.required'		=> '请提供所需充值客户id',
			'user_id.exists'			=> '用户id不存在',
			'recharge_amount.required'	=> '请填写充值金额',
			'recharge_amount.integer'	=> '充值金额必须为整数',
			'recharge_amount.min'		=> '充值金额最少为1元',
			'recharge_way.required'	=> '请选择付款方式',
			'audit_status.required'		=> '请选择充值审核单状态',
			'audit_status.between'		=> '审核单状态请在-1、0 、1之间选择',
			'audit_status.integer'		=> '审核单状态请在-1、0 、1之间选择',
			'trade_id.required'		=> '请提供所需审核的充值审核单id',
			'trade_id.integer'		=> 'id为整数',
			'trade_id.exists'			=> '充值审核单不存在',
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
