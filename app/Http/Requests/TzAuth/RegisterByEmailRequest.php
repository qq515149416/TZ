<?php

namespace App\Http\Requests\TzAuth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterByEmailRequest extends FormRequest
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
            'email' => 'required|email|unique:tz_users,email',
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
            'email.require' => '邮箱帐号必须填写',
            'email.email'   => '邮箱格式错误',
            'email.unique'  => '此邮箱已被注册过',

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