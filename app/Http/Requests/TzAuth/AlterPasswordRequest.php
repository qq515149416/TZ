<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

//use Illuminate\Support\Facades\Validator;

class AlterPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        return false;
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
            'old_password'          => 'required|min:8|max:20|string',
            'password'              => 'required|min:8|max:20|string|confirmed',
            'password_confirmation' => 'required',   //
        ];
    }

    /**
     * 验证错误返回的信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required'          => '原密码不能为空',
            'password.required'              => '新密码不能为空',
            'password.min'                   => '新密码在8到20位之间',
            'password.max'                   => '新密码在8到20位之间',
            'password_confirmation.required' => '新密码二次输入不能为空',
            'password.confirmed'             => '新密码两次输入不一致',
        ];
    }

    /**
     * use Illuminate\Contracts\Validation\Validator;
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $msg = $validator->errors()->first();
        header('Content-type:application/json');
        header('Cache-control:no-cache');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}');
    }


}
