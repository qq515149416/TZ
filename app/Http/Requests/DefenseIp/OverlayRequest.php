<?php

namespace App\Http\Requests\DefenseIp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OverlayRequest extends FormRequest
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
			case 'showOverlay':
				$return = [
					'site'				=> 'required', 
					'sell_status'			=> 'required|in:0,1,*',
				];
				break;
			
			case 'showBelong':
				$return = [
					'status'				=> 'required',
				];
				break;
			case 'useOverlayToDIP':
				$return = [
					'belong_id'			=> 'required', 
					'business_number'		=> 'required',
				];
				break;
			case 'buyNowByCustomer':
				$return = [
					'overlay_id'			=> 'required|exists:tz_overlay,id', 
					'buy_num'			=> 'required|integer|min:1',
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
			
			'overlay_id.required'			=> '请填写叠加包的id',
			'overlay_id.exists'			=> '叠加包不存在',
			'buy_num.required'			=> '请填写购买数量',
			'buy_num.integer'			=> '购买数量需整数',
			'buy_num.min'				=> '购买数量最少一个',
			
			'status.required'				=> '请选择查询的状态',
			'business_number.required'		=> '请选择使用叠加包的业务',	
			'belong_id.required'			=> '请选择使用的叠加包id',
			'sell_status.required'			=> '请填写需要查询的上下架状态',
			'sell_status.in'				=> '*-所有 ; 0-下架中 ; 1-上架中',
			'site.required'				=> '请填写叠加包机房',
			'site.exists'				=> '机房不存在',
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
