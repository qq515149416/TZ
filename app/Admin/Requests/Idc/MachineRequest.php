<?php

namespace App\Http\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'machine_num' => 'require',
            'cpu' => 'require',
            'memory' => 'require',
            'harddisk' => 'require',
            'cabinet' => 'require|integer',
            'ip_id' => 'require|integer',
            'machineroom' => 'require|integer',
            'bandwidth' => 'require|integer',
            'protect' => 'require|integer',
            'loginname' => 'require',
            'loginpass' => 'require',
            'machine_type' => 'require',
            'used_status' => 'require|integer',
            'machine_status' => 'require|integer',
            'business_type' => 'require|integer',
        ];
    }

    public function messages()
    {
        
        return  [
            'machine_num.require' => '机器编号必须填写',
            'cpu.require' => 'CPU信息必须填写',
            'memory.require' => '内存信息必须填写',
            'harddisk.require' => '硬盘信息必须填写',
            'cabinet.require' => '机柜信息必须选择',
            'cabinet.integer' => '机柜信息选择的必须时正整数',
            'ip_id.require' => 'IP信息必须选择',
            'ip_id.integer' => 'IP信息选择的必须是正整数',
            'machineroom.require' => '机房信息必须选择',
            'machineroom.integer' => '机房信息选择的必须是正整数',
            'bandwidth.require' => '带宽资源必须填写',
            'bandwidth.integer' => '带宽资源填写必须是正整数',
            'protect.require' => '防护资源必须填写',
            'protect.integer' => '防护资源的填写必须是正整数',
            'loginname.require' => '机器登陆的账户必须填写',
            'loginpass.require' => '机器的登录密码必须填写',
            'machine_type.require' => '机器的类型信息必须填写',
            'used_status.require' => '机器的使用信息必须选择',
            'used_status.integer' => '机器的使用信息选择的必须是正整数',
            'machine_status.require' => '机器的上下架信息必须选择',
            'machine_status.integer' => '机器的上下架信息选择必须是正整数',
            'business_type.require' => '机器的业务类型必须选择',
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
