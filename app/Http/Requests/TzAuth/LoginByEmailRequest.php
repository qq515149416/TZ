<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginByEmailRequest extends FormRequest
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
            'password' => 'required',
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
            'email.require'   => '邮箱帐号必须填写',
            'email.email'     => '邮箱格式错误',
            'password'        => '密码不能为空',
            'captcha.require' => '验证码不能为空',
            'captcha.captcha' => '验证码错误',
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
