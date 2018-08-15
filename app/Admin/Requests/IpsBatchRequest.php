<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class IpsBatchRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ip_part' => 'required|ip',
            'vlan' => 'required|integer',
            'origin' => 'required|integer',
            'finish' => 'required|integer',
        ];
    }


     public function messages()
    {
        
        return  [
            'ip.required' => 'IP地址段必须填写',
            'ip.ip' => 'IP地址段填写必须符合IP地址规范',
            'vlan.required' => 'IP所属局域网必须填写',
            'vlan.integer' => 'IP所属局域网填写必须是整数',
            'origin.required' => 'IP地址起始必须填写',
            'origin.integer' => 'IP地址起始必须是数字',
            'finish.required' => 'IP地址结束必须填写',
            'finish.integer' => 'IP地址结束必须是数字',
        ];
    }

    /**
     * 重新定义数据字段返回的提示信息
     */
    public function failedValidation(Validator $validator) {
        $msg = $validator->errors()->first();
        header('Content-type:application/json');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
    }
}
