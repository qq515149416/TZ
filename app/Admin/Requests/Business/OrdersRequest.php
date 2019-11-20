<?php


namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrdersRequest extends FormRequest
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
			case 'payOrderByAdmin':
				$return = [
					'order_id'		=> 'required',
					// 'coupon_id'		=> 'required',
				];
				break;
			case 'showOrderDetail':
				$return = [
					'order_sn'		=> 'required|exists:tz_orders,order_sn',

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
			'business_number.required'	=> '请选择业务',
			'coupon_id.required'		=> '请选择优惠券',
			'order_id.required'		=> '请选择需支付的订单',	
			'order_sn.required'		=> '请提供订单编号',	
			'order_sn.exists'			=> '订单编号不存在',	
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
