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
					'status'			=> 'required|in:0,1'
				];
				break;
			
			case 'showReview':
				$return = [
					'flow_id'			=> 'required|exists:tz_orders_flow,id',
				
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
			'flow_id.required'		=> '请选择流水id',	
			'flow_id.exists'			=> '流水id不存在',	
			'reason.required'		=> '请填写复核原因',	
			'status.required'			=> '请填写复核结果',
			'status.in'			=> '复核结果为:0->尚未处理 , 1->已处理完毕'		
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
