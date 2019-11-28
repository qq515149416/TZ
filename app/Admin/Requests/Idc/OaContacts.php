<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 系统联系人表操作时的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-07-30 09:32:15
// +----------------------------------------------------------------------

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class OaContacts extends FormRequest
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
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contactname'=>'required|max:20',
            'qq'=>'required|regex:/^[1-9]\d{4,10}$/',
            'mobile'=>[
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|191|(147))\d{8}$/',
            ],
            'email'=>'required|email',
            'rank'=>'required|integer',
        ];
    }
// /^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/
    /**
     * 自定义字段的错误提示信息
     */
    public function messages()
    {
        
        return  [
            'contactname.required'=>'姓名必须填写',
            // 'contactname.min'=>'姓名至少要有姓氏',
            'contactname.max'=>'姓名最多只能20个字符',
            'qq.required'=>'联系人QQ号码必须填写',
            'qq.regex'=>'QQ号码的填写必须符合腾讯相关规则',
            'mobile.required'=>'联系人手机号码必须填写',
            'mobile.regex'=>'手机号码必须符合号码相关规则',
            'email.required'=>'联系人邮箱必须填写',
            'email.email'=>'邮箱必须符合相关规范',
            'rank.required'=>'权重必须填写且是整数数字',
            'rank.integer'=>'权重必须是有效整数数字'
            
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
     public function failedValidation(Validator $validator) {
        $msg = $validator->errors()->first();
        header('Content-type:application/json');
        header('Cache-control:no-cache');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
    }
}
