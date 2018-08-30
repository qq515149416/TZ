<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * 测试组
 */
Route::group([
    'prefix'     => 'test',
    'middleware' => 'UserOperationLog'
], function () {
    //测试
    Route::post('jun', 'TzAuth\RegisterController@test');
    Route::get('jun2', 'TzAuth\RegisterController@test2');
    Route::get('jun3', 'TzAuth\RegisterController@sendCodeToEmail');
    Route::get('login', 'TzAuth\TestController@login');
});

//news接口路径
Route::group([
    'prefix' => 'news',
], function () {
    //测试
    Route::get('getNews', 'News\NewsController@getNewsList');
    Route::get('getNewsDetails', 'News\NewsController@getNewsDetails');
});

/**
 * 腾正Auth   (登录注册验证)
 */
Route::group([
    'prefix'     => 'auth',
    'middleware' => 'UserOperationLog',
], function () {
    Route::group(['middleware' => 'CheckLogin'], function () {

    });
    Route::post('test', 'TzAuth\RegisterController@test'); //测试
    Route::post('sendEmailCode', 'TzAuth\RegisterController@sendCodeToEmail');  //发送邮箱验证码
    Route::post('registerByEmail', 'TzAuth\RegisterController@registerByEmail');  //通过邮箱注册帐号
    Route::get('logout', 'TzAuth\LoginController@logout');  //用户退出登录
    Route::post('loginByEmail', 'TzAuth\LoginController@loginByEmail');  //通过邮箱登录帐号
});


/**
 * 用户后台组   (所有用户后台路由此组下)
 */
Route::group([
    'prefix'     => 'home',
    'middleware' => 'UserOperationLog',
], function () {
//支付接口
    
    Route::group([
	    'middleware' => 'CheckLogin',
	], function () {
		//生成订单接口
		Route::get('payIndex', 'Pay\AliPayController@index');
		//获取指定用户的所有充值单信息
    		Route::get('getOrderByUser', 'Pay\AliPayController@getOrderByUser');
	});
    
    //跳转到支付页面的方法
    Route::get('goToPay', 'Pay\AliPayController@goToPay');
    //异步接收支付宝发出通知的接口,支付宝方用的
    Route::post('payRechargeNotify', 'Pay\AliPayController@rechargeNotify');
    //用户支付完成后跳转页面
    Route::get('payRechargeReturn', 'Pay\AliPayController@rechargeReturn');

    
    //获取指定充值单号所有信息
    Route::get('getOrder', 'Pay\AliPayController@getOrder');
    //单独获取指定充值单号支付情况
    Route::get('checkRechargeOrder', 'Pay\AliPayController@checkRechargeOrder');

    //退款页面
    //Route::get('refund', 'Pay\PayController@refund');
    
    //调试用
    Route::get('payForm', 'Pay\AliPayController@form');


    //用户idc路由
    Route::group([
	    'prefix'     => 'idc',
	], function () {
		Route::group([
	    		// 'middleware' => 'CheckLogin',
		], function () {
			Route::get('businessList', 'Idc\BusinessController@getBusinessList');		
		});
	});

});