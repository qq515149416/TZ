<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class Test extends FormRequest
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
            'title'=>'required|min:10|email',
            'hah' => 'required',
        ];
    }


    public function messages()
    {
        // $mes = 'test';
        return  [
            'title.required' => '标题必须',
            'title.min' => '1',
            'title.email' => 'email',
            'hah.required' =>'test', 
            // 'body.required'  => 'A message is required',
        ];
    }

    public function failedValidation(Validator $validator ) {
        exit(json_encode(array(
            'code' => 0,
            'message' => $validator->getMessageBag()->toArray(),
            // 'data' => $validator->getMessageBag()->toArray()
        )));
    }
}
