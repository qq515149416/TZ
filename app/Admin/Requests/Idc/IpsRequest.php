<?php



namespace App\Admin\Requests\Idc;

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
            'ip_start' => 'required|ip',
            'ip_end' => 'sometimes|nullable|ip',
            'vlan' => 'required|integer',
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
