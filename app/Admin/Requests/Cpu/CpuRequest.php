<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: IP地址表的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:09:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class NewsRequest extends FormRequest
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
        return [

	'cpu_number'	=> 'required',
	'cpu_param'	=> 'required',
        ];
    }

    public function messages()
    {
        
        return  [
            'cpu_number.required' 	=> 'cpu编号必须填写',
            'cpu_param.required' 	=> 'cpu参数必须填写',
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator) {
        exit(tz_ajax_echo([],$validator->errors()->first(),0));
    }
}
