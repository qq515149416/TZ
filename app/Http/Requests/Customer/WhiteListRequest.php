<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class WhiteListRequest extends FormRequest
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

        if($array_path[$count_path-1] == 'show_white_list'){
            return [
                'white_status' => 'required|integer',
            ];
        } elseif($array_path[$count_path-1] == 'insert_white_list'){
            return [
                'white_ip' => 'required|ip',
                'domain_name' => [
                    'required',
                    // 'regex:',
                ],
                'record_number' => 'required',
                'binding_machine' => 'required',
            ];
        } elseif($array_path[$count_path-1] == 'check_domain_name'){
            return [
                'domain_name' => 'required',
            ];
        } elseif($array_path[$count_path-1] == 'check_ip'){
            return [
                'white_ip' => 'required|ip',
            ];
        }

        
    }

    public function messages()
    {
            return [
                'white_ip.required' => 'IP地址必须填写',
                'white_ip.ip' => 'IP地址的填写必须符合IP规范(例如:192.168.1.1)',
                'domain_name.required' => '需要绑定的域名必须填写',
                // 'domain_name.regex' => '所填写的域名必须符合域名规范(如:baidu.com)',
                'record_number' => '域名的备案编号必须填写',
                'binding_machine' => 'IP所属机器编号必须存在',
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
