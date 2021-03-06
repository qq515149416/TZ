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
					'recharge_amount'	=> 'required|numeric|min:1.00',
					'recharge_way'		=> 'required',	
					'tax'			=> 'required',
					'time'			=> 'required|date|after:1971-01-01 00:00:00|before:2037-12-31 23:59:59',	
				];
				break;
			case 'showAuditRechargeBig':
				$return = [
					'audit_status'		=> 'required',			
				];
				break;
			case 'showAuditRechargeSmall':
				$return = [
					'audit_status'		=> 'required',			
				];
				break;
			case 'auditRecharge':
				$return = [
					'audit_status'		=> 'required|between:-1,1|integer',	
					'recharge_amount'	=> 'required|min:1.00',
					'recharge_way'		=> 'required',	
					'trade_id'		=> 'required|integer|exists:tz_recharge_admin,id',	
					'time'			=> 'date|after:1971-01-01 00:00:00|before:2037-12-31 23:59:59',	
				];
				break;
			case 'editAuditRecharge':
				$return = [
					'recharge_amount'	=> 'required|min:1.00',
					'recharge_way'		=> 'required',		
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
			'recharge_amount.numeric'	=> '充值金额格式错误',
			'recharge_way.required'	=> '请选择付款方式',
			'audit_status.required'		=> '请选择充值审核单状态',
			'audit_status.between'		=> '审核单状态请在-1、0 、1之间选择',
			'audit_status.integer'		=> '审核单状态请在-1、0 、1之间选择',
			'trade_id.required'		=> '请提供所需审核的充值审核单id',
			'trade_id.integer'		=> 'id为整数',
			'trade_id.exists'			=> '充值审核单不存在',
			'time.required'			=> '请填写到账时间',
			'time.date'			=> '到账日期格式错误',
			'time.after'   =>'日期不在1971-01-01到2037-12-31范围内',
			'time.before'   =>'日期不在1971-01-01到2037-12-31范围内',
			'tax.required'			=> '请填写税额',

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
