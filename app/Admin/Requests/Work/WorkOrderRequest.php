<?php

namespace App\Admin\Requests\Work;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * 工单的验证
 */
class WorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
        ];
    }

    public function messages()
    {
        
        return  [
            'ip_start.required' => 'IP地址必须填写',
            'ip_start.ip' => 'IP地址的填写必须符合IP规范(例:192.168.1.1)',
            'ip_end.ip' => 'IP地址的填写必须符合IP规范(例:192.168.1.251)',
            'vlan.required' => 'IP所属局域网必须填写',
            'vlan.integer' => 'IP所属局域网填写必须是整数',
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
