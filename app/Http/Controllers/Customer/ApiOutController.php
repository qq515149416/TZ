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
	* 客户展示自己已购买的高防套餐 api 详情
	* @return 
	*/
	public function showDIPDetail(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'businessNumber' ]);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['businessNumber']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showDIPDetail( $par['apiKey'] , $par['timestamp'] , $par['hash'] ,$par['businessNumber']);

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

	

	/**
	* 查看可购买的高防ip套餐
	* @return 
	*/
	public function showDIPPackage(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showDIPPackage( $par['apiKey'] , $par['timestamp'] , $par['hash'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 绑定目标ip
	* @return 
	*/
	public function setDIPTarget(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'businessNumber' , 'targetIp' ]);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['businessNumber']) || !isset($par['targetIp']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->setDIPTarget( $par['apiKey'] , $par['timestamp'] , $par['hash'] ,$par['businessNumber'] ,$par['targetIp'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取高防流量图
	* @return 
	*/
	public function showDIPFlow(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'startTime' , 'endTime' , 'ip']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['startTime']) || !isset($par['endTime']) || !isset($par['ip']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showDIPFlow( $par['apiKey'] , $par['timestamp'] , $par['hash'] ,$par['startTime'] ,$par['endTime'] ,$par['ip'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 提交白名单申请
	* @return 
	*/
	public function setWhiteList(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'ip' , 'domainName' , 'recordNumber' , 'submitNote']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['ip']) || !isset($par['domainName']) || !isset($par['recordNumber']) || !isset($par['submitNote'])) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();

		$res = $model->setWhiteList( $par['apiKey'] , $par['timestamp'] , $par['hash'] ,$par['ip'] ,$par['domainName'] , $par['recordNumber'] , $par['submitNote'] );
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取所有业务的使用中ip
	* @return 
	*/
	public function showAllIp(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showAllIp( $par['apiKey'] , $par['timestamp'] , $par['hash'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取所有白名单申请
	* @return 
	*/
	public function showWhiteList(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showWhiteList( $par['apiKey'] , $par['timestamp'] , $par['hash'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 展示可购买叠加包
	* @return 
	*/
	public function showOverlay(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$model = new ApiOut();
		$res = $model->showOverlay( $par['apiKey'] , $par['timestamp'] , $par['hash'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	

	/**
	* 购买叠加包
	* @return 
	*/
	public function buyOverlay(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'overlayId' , 'num']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['overlayId']) || !isset($par['num']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}
	
		$model = new ApiOut();
		$res = $model->buyOverlay( $par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['overlayId'] , $par['num']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 展示已购叠加包
	* @return 
	*/
	public function showBelong(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}
	
		$model = new ApiOut();
		$res = $model->showBelong( $par['apiKey'] , $par['timestamp'] , $par['hash'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	
	/**
	* 使用叠加包
	* @return 
	*/
	public function useOverlay(Request $request)
	{
		$par = $request->only(['apiKey' , 'timestamp' , 'hash' , 'belongId' , 'target' , 'isIgnore' , 'type']);

		if (!isset($par['apiKey']) || !isset($par['timestamp']) || !isset($par['hash']) || !isset($par['belongId']) || !isset($par['target']) || !isset($par['isIgnore']) || !isset($par['type']) ) {
			return tz_ajax_echo([],'非法参数',3);
		}
	
		$model = new ApiOut();
		$res = $model->useOverlay( $par['apiKey'] , $par['timestamp'] , $par['hash'] , $par['belongId'] , $par['target'] , $par['isIgnore'] , $par['type'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
