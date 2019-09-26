<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\ApiOut;
use Illuminate\Http\Request;

class ApiOutController extends Controller
{

	/**
	* 展示登录中用户的api_key和secret
	* @return 
	*/
	public function buyDIP(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'package_id' , 'buy_time']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['package_id']) || !isset($par['buy_time']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->buyDIP($par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['package_id'] , $par['buy_time'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
