<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

//use Illuminate\Support\Facades\Validator;

class ResetPasswordByEmail extends FormRequest
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
            'email'    => 'required|email',
            'password' => 'required|min:8|max:20|string|confirmed',
            'captcha'  => 'required|captcha',
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
            'email.required'                 => '邮箱帐号必须填写',
            'email.email'                    => '邮箱格式错误',
            'password.required'              => '密码不能为空',
            'password.min'                   => '密码在8到20位之间',
            'password.max'                   => '密码在8到20位之间',
            'password.confirmed'             => '密码两次输入不一致',
            'password_confirmation.required' => '密码二次输入不能为空',
            'captcha.required'               => '验证码不能为空',
            'captcha.captcha'                => '验证码错误',

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
        exit('{"code": 0,"data":[],"msg":"' . $msg . '"}');
    }


}
