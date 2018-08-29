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
    'prefix' => 'test',
    'middleware'=>'UserOperationLog'
],function () {
    //测试
    Route::post('jun', 'TzAuth\RegisterController@test');
    Route::get('jun2', 'TzAuth\RegisterController@test2');
    Route::get('jun3', 'TzAuth\RegisterController@sendCodeToEmail');
});

//news接口路径
Route::group([
    'prefix' => 'news',
],function () {
    //测试
    Route::get('getNews', 'News\NewsController@getNewsList');
    Route::get('getNewsDetails', 'News\NewsController@getNewsDetails');
});

/**
 * 腾正Auth   (登录注册验证)
 */
Route::group([
    'prefix' => 'auth',
    'middleware'=>'UserOperationLog',
],function () {
    Route::group(['middleware' => 'CheckLogin'], function () {
        Route::post('test', 'TzAuth\RegisterController@test'); //测试
    });

    Route::post('sendEmailCode', 'TzAuth\RegisterController@sendCodeToEmail');  //发送邮箱验证码
    Route::post('registerByEmail', 'TzAuth\RegisterController@registerByEmail');  //通过邮箱注册帐号
    Route::get('logout','TzAuth\LoginController@logout');  //用户登录
});


/**
 * 用户后台组   (所有用户后台路由此组下)
 */
Route::group([
    'prefix' => 'home',
    'middleware'=>'UserOperationLog',
],function () {
//支付接口

    Route::get('payIndex', 'Pay\PayController@index');
    Route::post('payRechargeNotify', 'Pay\PayController@rechargeNotify');
    Route::get('payRechargeReturn', 'Pay\PayController@rechargeReturn');
    Route::get('payForm', 'Pay\PayController@form');

});