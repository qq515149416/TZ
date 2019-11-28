<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


Route::group([
	'prefix' => 'v1', //高防类
	'middleware' => 'CheckApi'
], function () {
	/** 高防类api start **/
	Route::group([
		'prefix' => 'dip', //高防类
	], function () {

		Route::post('showDIPPackage', 'Customer\ApiOutController@showDIPPackage');      //可购买套餐展示
		Route::post('buyDIP', 'Customer\ApiOutController@buyDIP');          //购买高防套餐的接口
		Route::post('renewDIP', 'Customer\ApiOutController@renewDIP');          //购买高防套餐的接口
		Route::post('showDIP', 'Customer\ApiOutController@showDIP');      //展示已购高防套餐的接口
		Route::post('showDIPDetail', 'Customer\ApiOutController@showDIPDetail');      //展示已购高防套餐的接口
		Route::post('searchDIP', 'Customer\ApiOutController@searchDIP');      //展示已购高防套餐的接口
		Route::post('setDIPTarget', 'Customer\ApiOutController@setDIPTarget');      //绑定目标ip
		Route::post('showDIPFlow', 'Customer\ApiOutController@showDIPFlow');      //展示高防流量		
	});

	Route::group([
		'prefix' => 'overlay', //叠加包类
	], function () {

		Route::post('showOverlay', 'Customer\ApiOutController@showOverlay');          //展示可购买叠加包
		Route::post('buyOverlay', 'Customer\ApiOutController@buyOverlay');         	 //购买高防套餐的接口	
		Route::post('showBelong', 'Customer\ApiOutController@showBelong');	//展示已购叠加包
		Route::post('useOverlay', 'Customer\ApiOutController@useOverlay');	//使用叠加包
		
	});

	/** 高防类api end **/

	/** 通用api start **/
	Route::group([
		'prefix' => 'common', //高防类
	], function () {
		Route::post('showAllIp', 'Customer\ApiOutController@showAllIp');      //展示所有所属IP
		Route::post('setWhiteList', 'Customer\ApiOutController@setWhiteList');      //添加白名单申请
		Route::post('showWhiteList', 'Customer\ApiOutController@showWhiteList');      //查看白名单申请
	});
	/** 通用api end **/
});
