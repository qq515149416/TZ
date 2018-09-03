<?php



namespace App\Admin\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CustomerRequest extends FormRequest
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
    
        ];
        //检测表单中是否存在id,并靠此决定验证规则
        // $info = $this->all();

        // if(isset($info['id'])){
        //     $return['cpu_number'].=",cpu_number,{$info['id']}";
        // }

        return $return;
    }

    public function messages()
    {
        
        return  [

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
