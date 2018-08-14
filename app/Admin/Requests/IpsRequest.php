<?php

// +----------------------------------------------------------------------
// | Author: 街"角．回 忆 <2773495294@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: IP地址表的验证规则和提示信息
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:09:24
// +----------------------------------------------------------------------

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class IpsRequest extends FormRequest
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
            
            'ip' => 'required|ip|unique:idc_ips,ip',
            'vlan' => 'required|integer',
        ];
    }

    public function messages()
    {
        
        return  [
            'ip.required' => 'IP地址必须填写',
            'ip.ip' => 'IP地址填写必须符合IP地址规范',
            'ip.unique'=>'IP地址唯一',
            'vlan.required' => 'IP所属局域网必须填写',
            'vlan.integer' => 'IP所属局域网填写必须是整数',
        ];
    }
// HTTP/1.0 200 OK Cache-Control: no-cache, private Content-Type: application/json Date: Tue, 14 Aug 2018 03:24:49 GMT 
    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator) {
        $msg = $validator->errors()->first();
        header('Content-type:application/json');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
        // tz_ajax_echo([],$validator->errors()->first(),0);
        // exit();
        // exit;;
    }
}
