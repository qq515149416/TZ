<?php

namespace App\Admin\Requests\Hr;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class EmployeeInformationRequest extends FormRequest
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
	 * Get the validation rules that apply to the request.
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
			case 'insert_employee':
				$return = [
					'admin_users_id'   	=> "required",
					'department'		=> 'required|integer',
					'work_number'		=> 'required',
					'job'			=> 'required|integer',
					'phone'			=> [
		                'required',
		                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
            		],
					'QQ'			=> 'required',
					'wechat'			=> 'required',
					'email'			=> 'required|email',
				];
				break;
			// case 'edit_employee':
			// 	$return = [
			// 		'white_status' => 'required|integer|min:0|max:4',
			// 	];
			// 	break;
			// case 'insert':
			// 	$return = [
			// 		'white_ip' => 'required|ip',
			// 		'domain_name' => [
			// 			'required',
			// 			'regex:#^(?!www|http)\w+(.\w+)+\w*$#',
			// 		],
			// 		'record_number' => 'required',
			// 		];
			// 	break;
			// case 'check':
			// 	$return = [
			// 		'white_status' => 'required|integer|min:1|max:3',
			// 		'id' => 'required|exists:tz_white_list,id',
			// 	];
			// 	break;
			// default:
	
			// 	break;
		}
 
		return $return;		
	}

	/**
	 * 自定义字段的错误提示信息
	 */
	public function messages()
	{
		
		return  [
				'admin_users_id.required' 	=> '工作人员id必须填写',
	            'department.required' 		=> '部门必须选择',	
	            'department.integer' 		=> '部门id必须是有效整数数字',	
	            'work_number.required' 		=> '工号必须填写',	
	            'job.required' 			=> '职位必须选择',
	            'job.integer' 			=> '职位id必须是有效整数数字',
	            'phone.required'			=> '手机号码电话必须填写',
	            'phone.regex'       =>'手机号码必须符合号码相关规则',
	            'QQ.required'			=> 'QQ必须填写',
	            'wechat.required'		=> '微信号必须填写',
	            'email.required'			=> '邮箱号必须填写',
	            'email.email'			=> '邮箱号格式错误',

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
