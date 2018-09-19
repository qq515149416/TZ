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
Route::get('/verification_code', function () {
    return tz_ajax_echo(["src"=>captcha_src()],"获取成功",1);
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
	Route::get('login', 'TzAuth\TestController@login');//TODO 上线前要删除   用户登录模拟登录


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

    //重置密码组
    Route::group([
        'prefix' => 'resetPassword',
    ], function () {
        Route::post('sendEmailCode', 'TzAuth\ResetPasswordController@sendEmailCode');  //发送邮箱
        Route::post('resetPasswordByEmail', 'TzAuth\ResetPasswordController@resetPasswordByEmail');  //通过邮箱帐号重置密码

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
		//跳转到支付页面的方法
		Route::get('goToPay', 'Pay\AliPayController@goToPay');
		
		Route::get('delOrder', 'Pay\AliPayController@delOrder');
	});

	
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
	Route::get('test', 'Pay\AliPayController@test');

	//用户相关订单和业务
	Route::group([
		'prefix'     => 'customer',
	], function () {
		Route::group([
				'middleware' => 'CheckLogin',
		], function () {
			Route::get('businessList', 'Customer\BusinessController@getBusinessList');	
			Route::get('orderList', 'Customer\OrderController@getOrderList');	
			Route::get('delOrder', 'Customer\OrderController@delOrder');
			Route::get('payOrderByBalance', 'Customer\OrderController@payOrderByBalance');								
			Route::post('reneworders','Customer\BusinessController@renewOrders');
			Route::post('resourceorders','Customer\OrderController@resourceOrders');
			Route::post('renewresource','Customer\OrderController@renewResource');
			Route::post('end','Customer\OrderController@endTime');
		});
	});

});