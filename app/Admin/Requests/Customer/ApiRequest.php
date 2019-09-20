<?php


namespace App\Admin\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiRequest extends FormRequest
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
			case 'show':
				$return = [
					'state'		=> 'required|in:0,1,2',
				];
				break;
			case 'examine':
				$return = [
					'examine_res'	=> 'required|in:0,1',
					'apply_id'	=> 'required|exists:tz_api,id'
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
			'state.required'		=> '请选择需查询的状态',
			'state.in'		=> '状态不存在: 0-不通过 ; 1-通过 ; 2-审核中',
			'examine_res.required'	=> '请选择审核结果',
			'examine_res.in'		=> '审核结果只有: 0-不通过 ; 1-通过',
			'apply_id.required'	=> '请选择申请单',
			'apply_id.exists'		=> '申请单不存在',
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
