<?php

namespace App\Admin\Requests\Waf;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WafRequest extends FormRequest
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
			
			case 'insert':
				$return = [
	
					'name'				=> 'required', 
					'description'			=> 'required', 
					'https_switch'			=> 'required|in:0,1', 
					'web_switch'			=> 'required|in:0,1', 
					'cc_switch'			=> 'required|in:0,1', 
					'price'				=> 'required|numeric', 
					'domain_num'			=> 'required|integer', 
					'sell_status'			=> 'in:0,1', 
				];
				break;
			case 'del':
				$return = [
					'del_id'				=> 'required|exists:tz_waf_package,id', 
			
				];
				break;
			case 'edit':
				$return = [
					'edit_id'				=> 'required|exists:tz_waf_package,id', 
					'sell_status'			=> 'in:0,1', 
			
				];
				break;
			case 'show':
				$return = [
					'sell_status'			=> 'required|in:0,1,*',
				];
				break;
			case 'showBelong':
				$return = [
					'user_id'			=> 'required', 
					'status'				=> 'required',
				];
				break;
			case 'useOverlayToDIP':
				$return = [
					'belong_id'			=> 'required', 
					'business_number'		=> 'required',
				];
				break;
			case 'buyNowByAdmin':
				$return = [
					'overlay_id'			=> 'required|exists:tz_overlay,id', 
					'buy_num'			=> 'required|integer|min:1',
					'price'				=> 'numeric',
					'user_id'				=> 'required|exists:tz_users,id',
				];
				break;
			case 'showBelongBySite':
				$return = [
					'site'				=> 'required|exists:idc_machineroom,id', 
					'status'				=> 'in:0,1,2'
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
			'name.required'				=> '请填写套餐名称',
			'description.required'			=> '请填写套餐描述',
			'https_switch.required'			=> '请选择可否配置https',
			'https_switch.in'				=> '选项不存在',
			'web_switch.required'			=> '请选择可否开启web防护',
			'web_switch.in'				=> '选项不存在',
			'cc_switch.required'			=> '请选择可否开启cc防护',
			'cc_switch.in'				=> '选项不存在',
			'price.required'				=> '请填写价格',
			'price.numeric'				=> '价格格式错误',
			'domain_num.required'			=> '请填写可添加域名数量',
			'domain_num.integer'			=> '域名数量格式错误',
			'edit_id.required'			=> '请选择更新的套餐',
			'edit_id.exists'				=> '套餐不存在',
			'del_id.required'				=> '请选择删除的套餐',
			'del_id.exists'				=> '套餐不存在',
			'sell_status.required'			=> '请选择查看套餐状态',
			
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
