<?php

namespace App\Admin\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Admin\Models\Business\AddressModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\AddressRequest;

/**
 * 后台订单控制器
 */
class AddressController extends Controller
{

	/**
	 * 
	 * @param 
	 * @return json 返回订单的相关数据和状态信息和状态
	 */
	public function insert(Request $request)
	{
		$par = $request->only(['user_id' , 'address']);
		dd($par);
	}
}
