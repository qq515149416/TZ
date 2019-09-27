<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\ApiOut;
use Illuminate\Http\Request;

class ApiOutController extends Controller
{

	/**
	* 客户渠道购买套餐 api
	* @return 
	*/
	public function buyDIP(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'packageId' , 'buyTime']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['packageId']) || !isset($par['buyTime']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->buyDIP($par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['packageId'] , $par['buyTime'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 客户渠道续费套餐 api
	* @return 
	*/
	public function renewDIP(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'businessNumber' , 'renewTime']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['businessNumber']) || !isset($par['renewTime']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->renewDIP($par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['businessNumber'] , $par['renewTime'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	
	/**
	* 客户展示自己已购买的高防套餐 api
	* @return 
	*/
	public function showDIP(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' ]);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showDIP($par['apiKey'] , $par['timestamp'] , $par['hash']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 客户搜索自己已购买的高防套餐 api
	* @return 
	*/
	public function searchDIP(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'ip']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['ip']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->searchDIP($par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['ip']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

}
