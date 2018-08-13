<?php

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CabinetVerify extends FormRequest
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
            'machineroom_id' => 'required',
            'cabinet_id'     => 'required|unique:idc_cabinet,cabinet_id',
        ];
    }

    public function messages()
    {

        return [
            'machineroom_id.required' => '机房ID不能为空',
            'cabinet_id.required'     => '机柜编号不能为空',
            'cabinet_id.unique'       => '机柜编号已存在',
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator)
    {
        exit(tz_ajax_echo([], $validator->errors()->first(), 0));
    }

}