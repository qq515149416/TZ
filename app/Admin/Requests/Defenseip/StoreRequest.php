<?php

namespace App\Admin\Requests\Defenseip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreRequest extends FormRequest
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
					'ip'			=> 'required|array',
					'protection_value'	=> 'required|integer',
					'site'			=> 'required',		
				];
				break;
			case 'del':
				$return = [
					'del_id'			=> 'required|integer|exists:tz_defenseip_store,id',
				];
				break;
			case 'edit':
				$return = [
					'edit_id'			=> 'required|integer|exists:tz_defenseip_store,id',
					'ip'			=> 'required|ip|unique:tz_defenseip_store,ip,'.$par['edit_id'],
					'site'			=> 'required|integer',
					'protection_value'	=> 'required|integer',
				];
				break;
			case 'show':
				$return = [
					'status'			=> 'required',
					'site'			=> 'required'
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
			'ip.required'			=> '请填写ip地址',
			'ip.unique'			=> 'ip地址已存在',
			'protection_value.required'	=> '请填写ip防护值',
			'protection_value.integer'	=> '防护值需为整数,单位为G', 
			'site.required'			=> '请填写所属机房,1为西安',
			'ip.array'			=> 'ip请用数组格式传值',
			'del_id.required'		=> '请提供需删除的ip的id',
			'edit_id.required'		=> '请提供需编辑的ip的id',
			'edit_id.integer'			=> 'id格式错误',
			'ip.required'			=> 'ip必须填写',
			'ip.ip'				=> 'ip格式错误',
			'edit_id.exists'			=> '需编辑的id不存在',
			'del_id.exists'			=> '需删除的id不存在',
			'status.required'		=> '请提供所需查询的使用状态',
			'site.required'			=> '请提供所需查询的地区',
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
