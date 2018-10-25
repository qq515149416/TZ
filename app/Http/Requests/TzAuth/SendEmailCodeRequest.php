<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

//use Illuminate\Support\Facades\Validator;

class SendEmailCodeRequest extends FormRequest
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
//            'email'   => 'required|email|unique:tz_users,email',  //判断邮箱是否存在
            'email' => 'required|email',
            'captcha' => 'required|captcha',  //TODO 因测试原因暂时关闭   上线前需要关闭注释
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
            'email.required'   => '邮箱帐号必须填写',
            'email.email'      => '邮箱格式错误',
//            'email.unique'     => '邮箱已被注册过',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha'  => '验证码错误',

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
