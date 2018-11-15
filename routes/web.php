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
    return redirect('http://www.tzidc.com/');
});
Route::get('/gaofangip', function () {
    \View::addExtension('html','php');
    return view()->file(dirname(public_path()).'/resources/index/highDefense.html');
});
Route::get('/verification_code', function () {
    return tz_ajax_echo(["src" => captcha_src()], "获取成功", 1);  //获取图形验证码链接
});

/**
 * 测试组
 */
Route::group([
    'prefix'     => 'test',
    'middleware' => 'UserOperationLog'
], function () {

    //测试 DefenseIp\TestController
    Route::get('testbind', 'TzAuth\RegisterController@bindSalesman');  //测试绑定业务员
    Route::post('jun', 'TzAuth\ResetPasswordController@alterPassword');   //测试修改密码
    Route::post('ipTest', 'DefenseIp\InfoController@checkStatus');    //检查状态
//    Route::post('ipTest', 'DefenseIp\SetController@setTarget');    //高防IP测试
    Route::get('login', 'TzAuth\TestController@login');//TODO 上线前要删除   用户登录模拟登录
    Route::get('userInfo', 'User\InfoController@test');
    Route::get('redis', 'Test\RedisController@test'); //测试Redis
    Route::post('mail', 'Test\MailController@handle'); //测试邮件

    Route::get('time', 'Test\TimeController@time'); //测试时间
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
        Route::post('alterPassword', 'TzAuth\ResetPasswordController@alterPassword');  //通过原密码修改密码
    });


    Route::post('test', 'TzAuth\RegisterController@test'); //测试
    Route::post('sendEmailCode', 'TzAuth\RegisterController@sendCodeToEmail');  //发送邮箱验证码
    Route::post('registerByEmail', 'TzAuth\RegisterController@registerByEmail');  //通过邮箱注册帐号
    Route::get('logout', 'TzAuth\LoginController@logout');  //用户退出登录
    Route::post('loginByEmail', 'TzAuth\LoginController@loginByEmail');  //通过邮箱登录帐号
    Route::get('getAllSalesman', 'TzAuth\RegisterController@getAllSalesman');  //获取所有业务员


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
        'prefix' => 'recharge',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            //生成订单接口
            Route::get('payIndex', 'Pay\RechargeController@index');
            //获取登录中用户的所有充值单信息
            Route::get('getOrderByUser', 'Pay\RechargeController@getOrderByUser');
            //跳转到支付页面的方法
            Route::get('goToPay', 'Pay\RechargeController@goToPay');

            Route::get('delOrder', 'Pay\RechargeController@delOrder');
        });


        //异步接收支付宝发出通知的接口,支付宝方用的
        Route::post('payRechargeNotify', 'Pay\RechargeController@AliRechargeNotify');
        //用户支付完成后跳转页面
        Route::get('payRechargeReturn', 'Pay\RechargeController@AliRechargeReturn');

        //获取指定充值单号所有信息
        Route::get('getOrder', 'Pay\RechargeController@getOrder');
        //查询指定充值单号支付情况
        Route::get('checkRechargeOrder', 'Pay\RechargeController@checkRechargeOrder');

        //退款页面
        //Route::get('refund', 'Pay\PayController@refund');


    });


    //用户相关订单和业务
    Route::group([
        'prefix' => 'customer',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            Route::get('businessList', 'Customer\BusinessController@getBusinessList');
            Route::get('orderList', 'Customer\OrderController@getOrderList');
            Route::get('delOrder', 'Customer\OrderController@delOrder');
            Route::get('payTradeByBalance', 'Customer\OrderController@payTradeByBalance');
            Route::post('renewresource', 'Customer\OrderController@renewResource');
            Route::get('show_white_list', 'Customer\WhiteListController@showWhiteList');
            Route::post('insert_white_list', 'Customer\WhiteListController@insertWhiteList');
            Route::post('check_ip', 'Customer\WhiteListController@checkIp');
            Route::post('check_domain_name', 'Customer\WhiteListController@checkDomainName');
            Route::post('cancel_white_list', 'Customer\WhiteListController@cancelWhiteList');
            Route::get('show_work_answer', 'Customer\WorkAnswerController@showWorkAnswer');
            Route::post('insert_work_answer', 'Customer\WorkAnswerController@insertWorkAnswer');
            Route::get('show_work_order', 'Customer\WorkOrderController@showWorkOrder');
            Route::post('insert_work_order', 'Customer\WorkOrderController@insertWorkOrder');
            Route::get('work_types', 'Customer\WorkOrderController@workTypes');
            Route::post('all_renew','Customer\WorkOrderController@allRenew');
            Route::get('tests','Customer\WorkOrderController@tests');
            /**
             * 退款相关
             */
            Route::post('show_refund', 'Customer\RefundController@showRefund');
            Route::post('insert_refund', 'Customer\RefundController@insertRefund');
            Route::post('cancel_refund', 'Customer\RefundController@cancelRefund');
            Route::post('delete_refund', 'Customer\RefundController@deleteRefund');

            //以下订单
            Route::post('makeTrade', 'Customer\OrderController@makeTrade');
            Route::get('showTrade', 'Customer\OrderController@showTrade');
            Route::get('showUnpaidTrade', 'Customer\OrderController@showUnpaidTrade');
            Route::get('showSelectTrade', 'Customer\OrderController@showSelectTrade');
            Route::get('payTradeByAli', 'Customer\OrderController@payTradeByAli');
            Route::get('aliReturn', 'Customer\OrderController@aliReturn');
            Route::get('aliNotify', 'Customer\OrderController@aliNotify');
            Route::get('checkTrade', 'Customer\OrderController@checkTrade');
            Route::get('delTrade', 'Customer\OrderController@delTrade');

        });
    });

    //用户故障工单路由
    Route::group([
        'prefix' => 'fault',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            Route::get('workOrderList', 'Work\WorkOrderController@showWorkOrder');
            Route::post('insert', 'Work\WorkOrderController@insertWorkOrder');
            Route::post('del', 'Work\WorkOrderController@deleteWorkOrder');
            Route::post('cancel', 'Work\WorkOrderController@cancelWorkOrder');
        });
    });

    /**
     * 用户信息
     */
    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            Route::get('getInfo', 'User\InfoController@getInfo');  //获取用户信息
        });

    });


    /**
     * 高防IP组
     */
    Route::group([
        'prefix' => 'defenseIp',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            Route::get('getInfo', 'DefenseIp\InfoController@showList');  //获取高防IP 列表
            Route::post('setTarget', 'DefenseIp\SetController@setTarget');  //配置目标IP

            Route::get('buyDefenseIpNow', 'DefenseIp\OrderController@buyNow'); //购买套餐
            Route::get('renewDefenseIp', 'DefenseIp\OrderController@renew'); //购买套餐
        });

    });




});
