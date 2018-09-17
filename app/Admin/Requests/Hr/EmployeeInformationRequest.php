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
		 $return = [
			'admin_users_id'   	=> "required|unique:oa_staff",
			'department'		=> 'required',
			'work_number'		=> 'required|unique:oa_staff',
			'job'			=> 'required',
			'phone'			=> 'required',
			'QQ'			=> 'required',
			'wechat'			=> 'required',
			'email'			=> 'required|email',
			
		];
		//检测表单中是否存在id,并靠此决定验证规则
		$info = $this->all();

		if(isset($info['id'])){
			$return['admin_users_id'].=",admin_users_id,{$info['id']}";
			$return['work_number'].=",work_number,{$info['id']}";
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
		            'admin_users_id.unique'       	=> '该id相关信息已录入',
		            'department.required' 		=> '部门必须填写',	
		            'work_number.required' 		=> '工号必须填写',
		            'work_number.unique' 		=> '工号已存在',	
		            'job.required' 			=> '岗位必须填写',
		            'phone.required'			=> '联系电话必须填写',
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
