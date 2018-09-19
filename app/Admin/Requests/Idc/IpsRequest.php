<?php



namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

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
        $path_info = Request()->getPathInfo();
        $array_path = explode('/',$path_info);
        $count_path = count($array_path);

        if($array_path[$count_path-1] == 'insert'){
            return [    
                'ip_start' => 'required|ip|unique:idc_ips,ip',
                'ip_end' => 'sometimes|nullable|ip|unique:idc_ips,ip',
                'vlan' => 'required|integer',
                'ip_company' => 'required|integer|min:0|max:2',
                'ip_status' => 'required|integer|min:0|max:3',
                'ip_lock' => 'required|integer|min:0|max:1',
                'ip_comproom' => 'required|integer',
            ];
        } elseif($array_path[$count_path-1] == 'alerting'){
            $id = (int)Request('id');
            return [
                'id' => 'required|integer',    
                'ip_start' => 'sometimes|ip|unique:idc_ips,ip'.$id,
                'vlan' => 'sometimes|integer',
                'ip_company' => 'sometimes|integer|min:0|max:2',
                'ip_status' => 'sometimes|integer|min:0|max:3',
                'ip_lock' => 'sometimes|integer|min:0|max:1',
                'ip_comproom' => 'sometimes|integer',
            ];
        }
        
    }

    public function messages()
    {
        
        return  [
            'ip_start.required' => 'IP地址必须填写',
            'ip_start.ip' => 'IP地址的填写必须符合IP规范(例:192.168.1.1)',
            'ip_start.unique' => 'IP地址必须唯一'
            'ip_end.ip' => 'IP地址的填写必须符合IP规范(例:192.168.1.251)',
            'vlan.required' => 'IP所属局域网必须填写',
            'vlan.integer' => 'IP所属局域网填写必须是整数',
            'ip_company.required' => 'IP所属运营商必须选择',
            'ip_company.integer' => 'IP所属运营商的编号必须是0~2的正整数',
            'ip_company.min' => 'IP所属运营商的编号必须是0~2的正整数'
            'ip_company.max' => 'IP所属运营商的编号必须是0~2的正整数',
            'ip_status.required' => 'IP使用状态必须选择',
            'ip_status.integer' => 'IP使用状态必须为正整数0~3的正整数',
            'ip_status.min' => 'IP使用状态必须为0~3的正整数',
            'ip_status.max' => 'IP使用状态必须为0~3的正整数',
            'ip_lock.required' => 'IP锁定状态必须选择',
            'ip_lock.integer' => 'IP锁定状态必须为0~1的正整数',
            'ip_lock.min' => 'IP锁定状态必须为0~1的正整数',
            'ip_lock.max' => 'IP锁定状态必须为0~1的正整数',
            'ip_comproom.required' => 'IP所属机房必须选择',
            'ip_comproom.integer' => 'IP所属机房必须是正整数的编号',
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
