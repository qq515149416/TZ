<?php


namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrdersReviewRequest extends FormRequest
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
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$return = [];

		switch ($method) {
			case 'ordersReview':
				$return = [
					'flow_id'			=> 'required|exists:tz_orders_flow,id',
					'reason'			=> 'required',
				];
				break;
			
			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'flow_id.required'		=> '请选择需复核的流水',	
			'flow_id.exists'			=> '流水id不存在',	
			'reason.required'		=> '请填写复核原因',	
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
