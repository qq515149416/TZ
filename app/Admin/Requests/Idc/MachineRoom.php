<?php

namespace App\Admin\Requests\Idc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class MachineRoom extends FormRequest
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
//            'title'=>'required|min:10|email',
            'machine_room_id'   => ['required',
                                    Rule::unique('idc_machineroom','machine_room_id')->ignore(Request()->id)->where(function($query){
                                        $query->whereNull('deleted_at');
                                    })
                                ],
            'machine_room_name' => ['required',
                                    Rule::unique('idc_machineroom','machine_room_name')->ignore(Request()->id)->where(function($query){
                                        $query->whereNull('deleted_at');
                                    })
                                ],

        ];
    }


    /**
     *  错误时返回的信息
     * @return array
     */
    public function messages()
    {
        return [
            'machine_room_id.required'   => '机房编号必须填写',
            'machine_room_id.unique'     => '机房编号重复',
            'machine_room_name.required' => '机房中文名必须填写',
            'machine_room_name.unique'   => '机房名重复',
        ];
    }

    /**
     * 验证不通过时的操作
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {

        $msg = $validator->errors()->first();
        header('Content-type:application/json');
        header('Cache-control:no-cache');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 

    }
}
