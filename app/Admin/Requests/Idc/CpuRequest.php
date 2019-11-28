<?php



namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CpuRequest extends FormRequest
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
        $return = [
            'cpu_number'   =>  ['required',
                                    Rule::unique('idc_cpu','cpu_number')->ignore(Request()->id)->where(function($query){
                                        $query->whereNull('deleted_at');
                                    })
                                ],
            'cpu_param'    => 'required',
        ];
       
        return $return;
    }

    public function messages()
    {
        
        return  [
            'cpu_number.required' 	=> 'cpu编号必须填写',
            'cpu_number.unique'       => '该编号已录入',
            'cpu_param.required' 	=> 'cpu参数必须填写',
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
