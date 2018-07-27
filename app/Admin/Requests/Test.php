<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'tittle'=>'require',
        ];
    }


    public function message()
    {
        return [
            'title.required' => 'A title is required',
            // 'body.required'  => 'A message is required',
        ];
    }
}
