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

Route::get('/test', function (Request $request) {
	return '6666';
});

Route::group([
	'prefix' => 'v1', //高防类
], function () {
	/** 高防类api start **/
	Route::group([
		'prefix' => 'dip', //高防类
	], function () {

		Route::post('buyDIP', 'Customer\ApiOutController@buyDIP');          //购买高防套餐的接口
		Route::post('renewDIP', 'Customer\ApiOutController@renewDIP');          //购买高防套餐的接口
		Route::post('showDIP', 'Customer\ApiOutController@showDIP');      //展示已购高防套餐的接口
		Route::post('searchDIP', 'Customer\ApiOutController@searchDIP');      //展示已购高防套餐的接口
	});
	/** 高防类api end **/
});
