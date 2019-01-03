<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
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
            'login_name' => 'required',  //登录帐号
            'password'   => 'required',  //登录密码
            //'captcha'  => 'required|captcha',  //验证码  TODO  上线前需要关闭 注释
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
            'login_name.required' => '登录帐号必须填写',
//            'email.email'     => '邮箱格式错误',
            'password.required'   => '密码不能为空',
            'captcha.required'    => '验证码不能为空',
            'captcha.captcha'     => '验证码错误',
        ];
    }

    /**
     * use Illuminate\Contracts\Validation\Validator;
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        header('Content-type:application/json');
        $msg = $validator->errors()->first();
        exit('{"code": 0,"data":[],"msg":"' . $msg . '"}');
    }


}
