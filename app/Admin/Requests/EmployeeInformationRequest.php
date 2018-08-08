<?php

namespace App\Admin\Requests;

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
        return [
            //
        ];
    }

    /**
     * 自定义字段的错误提示信息
     */
    public function messages()
    {
        
        return  [
            
            
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator) {
        exit(tz_ajax_echo([],$validator->errors()->first(),0));
    }
}
