<?php


namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OrderRequest extends FormRequest
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

			//以下这个是新版的方法,子梁测试请打开注释,注释掉下面同名那小段代码
			// case 'payOrderByBalance':
			// 	$return = [
			// 		'order_id'		=> 'required',
			// 		// 'coupon_id'		=> 'required',
			// 	];
			// 	break;

			case 'payOrderByBalance':
				$return = [
					'business_sn'		=> 'required',
					'coupon_id'		=> 'required',
				];
				break;

			case 'getOrderById':
				$return = [
					'order_id'		=> 'required|exists:tz_orders,id',
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
			'business_sn.required'		=> '请提供所需支付的业务编号',
			'coupon_id.required'		=> '请提供优惠券id,0为不使用',
			'order_id.required'		=> '请提供订单id',
			'order_id.exists'			=> '无此订单id',
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
