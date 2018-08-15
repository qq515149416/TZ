<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 硬盘资源库的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:43:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Harddisk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class HarddiskRequest extends FormRequest
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
        //检测表单中是否存在id,并靠此决定验证规则
        $return = [
            'harddisk_number'   => "required|unique:idc_harddisk",
            'harddisk_param'    => 'required',
        ];
        $info = $this->all();

        if(isset($info['id'])){
            $return['harddisk_number'].=",harddisk_number,{$info['id']}";
        }

        return $return;
    }

    public function messages()
    {
        
        return  [
            'harddisk_number.required' 	=> '硬盘编号必须填写',
            'harddisk_number.unique'            => '该编号硬盘已录入',
            'harddisk_param.required' 	=> '硬盘参数必须填写',
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator) {
        exit(tz_ajax_echo([],$validator->errors()->first(),0));
    }
}
