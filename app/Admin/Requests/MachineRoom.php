<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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
            'room_id'   => 'required|unique:idc_machineroom,machine_room_id',
            'room_name' => 'required|unique:idc_machineroom,machine_room_name',

        ];
    }


    /**
     *  错误时返回的信息
     * @return array
     */
    public function messages()
    {
        return [
            'room_id.required'   => '机房编号必须填写',
            'room_id.unique'     => '机房编号重复',
            'room_name.required' => '机房中文名必须填写',
            'room_name.unique'   => '机房名重复',
        ];
    }

    /**
     * 验证不通过时的操作
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
//        exit(json_encode(array(
//            'code' => 0,
//            'message' => $validator->getMessageBag(),
//             'data' => $validator->getMessageBag()->toArray()
//        )));
        exit(dump($validator->errors()->first()));
//        exit(tz_ajax_echo([],$validator->errors()->first(),0));

    }
}
