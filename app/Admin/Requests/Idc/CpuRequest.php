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

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CpuRequest extends FormRequest
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
        $return = [
            'cpu_number'   => "required|unique:idc_cpu",
            'cpu_param'    => 'required',
        ];
        //检测表单中是否存在id,并靠此决定验证规则
        $info = $this->all();

        if(isset($info['id'])){
            $return['cpu_number'].=",cpu_number,{$info['id']}";
        }

        return $return;
    }

    public function messages()
    {
        
        return  [
            'cpu_number.required' 	=> 'cpu编号必须填写',
            'cpu_number.unique'       => '该编号已录入',
            'cpu_param.required' 	=> 'cpu参数必须填写',
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
