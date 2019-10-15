<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\ApiOut;
use Illuminate\Http\Request;

class ApiOutController extends Controller
{
	//三个必传的: 1.$apiKey ; 2.$hash ; 3.timestamp ; 在中间件那里,这个控制器里只需要判断本方法需要的参数和参数个数
	protected $par;

	public function __construct(Request $request)
	{
		$this->par = $request->all();
	}

	/**
	* 客户渠道购买套餐 api
	* @return 
	*/
	public function buyDIP(Request $request)
	{
		if (!isset($this->par['packageId']) || !isset($this->par['buyTime']) || count($this->par) != 5 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');
		$model = new ApiOut();
		$res = $model->buyDIP($check_sign , $this->par['packageId'] , $this->par['buyTime'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 客户渠道续费套餐 api
	* @return 
	*/
	public function renewDIP(Request $request)
	{
		if (!isset($this->par['businessNumber']) || !isset($this->par['renewTime']) || count($this->par) != 5 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');
		$model = new ApiOut();
		$res = $model->renewDIP($check_sign , $this->par['businessNumber'] , $this->par['renewTime'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	
	/**
	* 客户展示自己已购买的高防套餐 api
	* @return 
	*/
	public function showDIP(Request $request)
	{
		if (count($this->par) != 3 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');
		$model = new ApiOut();
		$res = $model->showDIP($check_sign);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 客户展示自己已购买的高防套餐 api 详情
	* @return 
	*/
	public function showDIPDetail(Request $request)
	{
		if (!isset($this->par['businessNumber']) || count($this->par) != 4) {
			return tz_ajax_echo([],'非法参数',3);
		}

		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showDIPDetail( $check_sign ,$this->par['businessNumber']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 客户搜索自己已购买的高防套餐 api
	* @return 
	*/
	public function searchDIP(Request $request)
	{
		if ( !isset($this->par['ip']) || count($this->par) != 4 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->searchDIP($check_sign , $this->par['ip']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	

	/**
	* 查看可购买的高防ip套餐
	* @return 
	*/
	public function showDIPPackage(Request $request)
	{
		if ( count($this->par) != 3 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showDIPPackage( $check_sign);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 绑定目标ip
	* @return 
	*/
	public function setDIPTarget(Request $request)
	{
		if (!isset($this->par['businessNumber']) || !isset($this->par['targetIp']) || count($this->par) != 5 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->setDIPTarget( $check_sign ,$this->par['businessNumber'] ,$this->par['targetIp'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取高防流量图
	* @return 
	*/
	public function showDIPFlow(Request $request)
	{

		if (!isset($this->par['startTime']) || !isset($this->par['endTime']) || !isset($this->par['ip']) || count($this->par) != 6 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showDIPFlow( $check_sign ,$this->par['startTime'] ,$this->par['endTime'] ,$this->par['ip'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 提交白名单申请
	* @return 
	*/
	public function setWhiteList(Request $request)
	{
		if (!isset($this->par['ip']) || !isset($this->par['domainName']) || !isset($this->par['recordNumber']) || !isset($this->par['submitNote'])  || count($this->par) != 7  ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->setWhiteList( $check_sign,$this->par['ip'] ,$this->par['domainName'] , $this->par['recordNumber'] , $this->par['submitNote'] );
		
		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取所有业务的使用中ip
	* @return 
	*/
	public function showAllIp(Request $request)
	{
		if ( count($this->par) != 3 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showAllIp( $check_sign);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 获取所有白名单申请
	* @return 
	*/
	public function showWhiteList(Request $request)
	{
		if ( count($this->par) != 3 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showWhiteList( $check_sign );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 展示可购买叠加包
	* @return 
	*/
	public function showOverlay(Request $request)
	{
		if ( count($this->par) != 3 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showOverlay( $check_sign );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	

	/**
	* 购买叠加包
	* @return 
	*/
	public function buyOverlay(Request $request)
	{

		if (!isset($this->par['overlayId']) || !isset($this->par['num']) || count($this->par) != 5 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->buyOverlay( $check_sign , $this->par['overlayId'] , $this->par['num']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	* 展示已购叠加包
	* @return 
	*/
	public function showBelong(Request $request)
	{
		if (count($this->par) != 3) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->showBelong( $check_sign );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	
	/**
	* 使用叠加包
	* @return 
	*/
	public function useOverlay(Request $request)
	{
		if (!isset($this->par['belongId']) || !isset($this->par['target']) || !isset($this->par['isIgnore']) || !isset($this->par['type']) || count($this->par) != 7 ) {
			return tz_ajax_echo([],'非法参数',3);
		}
		$check_sign = $request->get('check_sign');//中间件产生的参数
		$model = new ApiOut();
		$res = $model->useOverlay( $check_sign, $this->par['belongId'] , $this->par['target'] , $this->par['isIgnore'] , $this->par['type'] );

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
}
