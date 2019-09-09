<?php


namespace App\Admin\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InvoiceRequest extends FormRequest
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
			case 'insert':
				$return = [
					'user_id'			=> 'required|exists:tz_users,id',
					'name'			=> 'required',
					'num'			=> 'required',
				];
				break;
			case 'del':
				$return = [
					'payable_id'		=> 'required|exists:tz_payable,id',
				];
				break;
			case 'edit':
				$return = [
					'payable_id'		=> 'required|exists:tz_payable,id',
				];
				break;
			case 'show':
				$return = [
					'user_id'			=> 'required|exists:tz_users,id',
				];
				break;
			case 'makeInvoice':
				$return = [
					'flow_id'			=> 'required|array',
					'type'			=> 'required|in:1,2',
					'address_id'		=> 'required|exists:tz_address,id',
					'payable_id'		=> 'required|exists:tz_payable,id',
				];
				break;
			case 'deleteInvoice':
				$return = [
					'invoice_id'		=> 'required|exists:tz_invoice,id',
				];
			case 'getFlow':
				$return = [
					'customer_id'		=> 'required|exists:tz_users,id',
				];

			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{
		
		return  [
			'user_id.required'		=> '请选择客户',
			'user_id.exists'			=> '客户不存在',
			'name.required'			=> '请填写名称',
			'num.required'			=> '请填写纳税人识别号',
			'payable_id.required'		=> '请选择抬头',
			'payable_id.exists'		=> '抬头不存在',
			'flow_id.required'		=> '请选择需开票订单',
			'flow_id.array'			=> '订单请以数组形式传',
			'address_id.required'		=> '请选择邮寄地址',
			'address_id.exists'		=> '邮寄地址不存在',
			'type.required'			=> '请选择发票种类',
			'type.in'				=> '发票种类:1 - 增值税普通发票 ; 2 - 增值税专用发票',
			'invoice_id.required'		=> '请选择发票申请',
			'invoice_id.exists'		=> '发票申请不存在',
			'customer_id.required'		=> '请选择客户',
			'customer_id.exists'		=> '客户不存在',
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
