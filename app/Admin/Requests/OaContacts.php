<?php

// +----------------------------------------------------------------------
// | Author: 蔡明东 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 系统联系人表操作时的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-07-30 09:32:15
// +----------------------------------------------------------------------

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class OaContracts extends FormRequest
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
            
        ];
    }

    /**
     * 自定义字段的错误提示信息
     */
    public function messages()
    {
        
        return  [
            
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator ) {
        exit(tz_ajax_echo($data=[],$info=$validator->getMessageBag()->toArray(),0));
    }
}
