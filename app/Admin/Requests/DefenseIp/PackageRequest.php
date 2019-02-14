<?php

namespace App\Admin\Requests\DefenseIp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PackageRequest extends FormRequest
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
					'name'			=> 'unique:tz_defenseip_package',
					'site'			=> 'required|integer|exists:idc_machineroom,id',
					'protection_value'	=> 'required|integer',
					'price'			=> 'required|numeric',
					'sell_status'		=> 'required|integer|min:0|max:1',
				];
				break;
			case 'del':
				$return = [
					'del_id'			=> 'required|exists:tz_defenseip_package,id',	
				];
				break;
			
			case 'edit':
				if(!isset($par['edit_id'])){
					return ['edit_id'	 => 'required'];
				}
				$return = [
					'edit_id'			=> 'required|exists:tz_defenseip_package,id',
					'name'			=> 'required|unique:tz_defenseip_package,name,'.$par['edit_id'],
					'price'			=> 'required|numeric',
					// 'description'		=> 'required',
					'sell_status'		=> 'required|integer|min:0|max:1',
				];
				break;
			case 'show':
				
				$return = [
					'site'			=> 'required',	
				];
				break;
			case 'showById':
				
				$return = [
					'id'			=> 'required|exists:tz_defenseip_package,id',	
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
			'site.required'			=> '请选择地区',
			'site.integer'			=> '地区格式错误',
			'site.exists'			=> '无此机房',
			'protection_value.required'	=> '请填写防护值',
			'price.required'			=> '请填写价格',
			'price.numeric'			=> '价格格式错误',
			'del_id.required'		=> '请提供需删除的套餐的id',
			'del_id.exists'			=> '需删除的id不存在',
			'edit_id.required'		=> '请提供需编辑的套餐的id',
			'edit_id.exists'			=> '需编辑的id不存在',
			'name.unique'			=> '该套餐名已存在',
			'name.required'		=> '请填写套餐名',
			'description.required'		=> '请填写套餐描述',
			'id.required'			=> '请提供套餐的id',
			'id.exists'			=> '套餐id不存在',
			'sell_status.required'		=> '请选择是否上架',
			'sell_status.integer'		=> '0-下架;1-上架',
			'sell_status.min'			=> '0-下架;1-上架',
			'sell_status.max'		=> '0-下架;1-上架',
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
