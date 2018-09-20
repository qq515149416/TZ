<?php

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class MachineRequest extends FormRequest
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
        $path_info = Request()->getPathInfo();
        $array_path = explode('/',$path_info);
        $count_path = count($array_path);

        if($array_path[$count_path-1] == 'insertmachine'){
            return [
                'machine_num' => 'required|unique:idc_machine,machine_num',
                'cpu' => 'required',
                'memory' => 'required',
                'harddisk' => 'required',
                'cabinet' => 'required|integer',
                'ip_id' => 'required|integer',
                'machineroom' => 'required|integer',
                'bandwidth' => 'required|integer',
                'protect' => 'required|integer',
                'loginname' => 'required',
                'loginpass' => 'required',
                'machine_type' => 'required',
                'used_status' => 'required|integer',
                'machine_status' => 'required|integer',
                'business_type' => 'required|integer',
            ];

        } elseif($array_path[$count_path-1] == 'editmachine'){
            $id = Request('id');
            'machine_num' => 'sometimes|unique:idc_machine,machine_num'.$id,
            'cpu' => 'sometimes',
            'memory' => 'sometimes',
            'harddisk' => 'sometimes',
            'cabinet' => 'sometimes|integer',
            'ip_id' => 'sometimes|integer',
            'machineroom' => 'sometimes|integer',
            'bandwidth' => 'sometimes|integer',
            'protect' => 'sometimes|integer',
            'loginname' => 'sometimes',
            'loginpass' => 'sometimes',
            'machine_type' => 'sometimes',
            'used_status' => 'sometimes|integer',
            'machine_status' => 'sometimes|integer',
            'business_type' => 'sometimes|integer',
        } 
        
    }

    public function messages()
    {
        
        return  [
            'machine_num.required' => '机器编号必须填写',
            'machine_num.unique' => '机器编号必须唯一',
            'cpu.required' => 'CPU信息必须填写',
            'memory.required' => '内存信息必须填写',
            'harddisk.required' => '硬盘信息必须填写',
            'cabinet.required' => '机柜信息必须选择',
            'cabinet.integer' => '机柜信息选择的必须时正整数',
            'ip_id.required' => 'IP信息必须选择',
            'ip_id.integer' => 'IP信息选择的必须是正整数',
            'machineroom.required' => '机房信息必须选择',
            'machineroom.integer' => '机房信息选择的必须是正整数',
            'bandwidth.required' => '带宽资源必须填写',
            'bandwidth.integer' => '带宽资源填写必须是正整数',
            'protect.required' => '防护资源必须填写',
            'protect.integer' => '防护资源的填写必须是正整数',
            'loginname.required' => '机器登陆的账户必须填写',
            'loginpass.required' => '机器的登录密码必须填写',
            'machine_type.required' => '机器的类型信息必须填写',
            'used_status.required' => '机器的使用信息必须选择',
            'used_status.integer' => '机器的使用信息选择的必须是正整数',
            'machine_status.required' => '机器的上下架信息必须选择',
            'machine_status.integer' => '机器的上下架信息选择必须是正整数',
            'business_type.required' => '机器的业务类型必须选择',
            'business_type.integer' => '机器的业务类型选择的必须是正整数',
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
