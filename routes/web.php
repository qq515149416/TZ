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


// Route::get('/gaofangip', function () {
//     \View::addExtension('html','php');
//     return view()->file(dirname(public_path()).'/resources/index/highDefense.html');
// });

Route::get('/socketurl', function () {
    return tz_ajax_echo(env("SOCKET_URL", "http://localhost:8120"), "获取成功", 1);
});

Route::get('/verification_code', function () {
    return tz_ajax_echo(["src" => captcha_src()], "获取成功", 1);  //获取图形验证码链接
});

Route::group([
    'middleware' => 'UserOperationLog'
], function () {
    Route::get('/', 'Show\IndexController@index'); //网站首页
    Route::get('/page/{directory}/{p}', 'Show\PageController@index');
    Route::get('/promotion/ddk', 'Show\DdkPromotionController@index');
    Route::get('/aboutus/{page}', 'Show\AboutUsController@index');
    Route::get('/promotion/consumer', 'Show\ConsumerPromotionController@index');
    Route::get('/zuyong/{page}/{room?}', 'Show\ServerRentController@index');
    Route::get('/fangan/{page}', 'Show\ProgramController@index');
    Route::get('/tuoguan', 'Show\HostingController@index');
    Route::get('/article/{type}', 'Show\ArticleController@index');
    Route::get('/detail/{type}/{id}', 'Show\ArticleController@detail');
    Route::get('/15cdn/{page}', 'Show\CdnController@index');
    Route::get('/gaofangchuxiao', 'Show\GfPromotionController@index');
    Route::get('/protection/{page}', 'Show\ProtectionController@index');
    Route::get('/test', 'Show\TestController@index');
    Route::get('/15cdn/{page}', 'Show\CdnController@index');
    Route::get('/datacenter', 'Show\DataCenterController@index');
    Route::get('/dist/highDefense.html', 'Show\ProtectionController@gaofang');
    Route::get('/cabinet-rent/{page}', 'Show\CabinetRentController@index');
});

/**
 * 测试组
 */
Route::group([
    'prefix' => 'test',
    'middleware' => 'UserOperationLog'
], function () {

    //测试 DefenseIp\TestController
    Route::get('testbind', 'TzAuth\RegisterController@bindSalesman');  //测试绑定业务员
    Route::post('jun', 'TzAuth\ResetPasswordController@alterPassword');   //测试修改密码
    Route::get('ipTest', 'DefenseIp\InfoController@test');    //检查状态
    Route::get('ipTest2', 'DefenseIp\SetController@test');    //高防IP测试
    Route::get('login', 'TzAuth\TestController@login');//TODO 上线前要删除   用户登录模拟登录
    Route::get('userInfo', 'User\InfoController@test');
    Route::get('redis', 'Test\RedisController@test2'); //测试Redis
    Route::get('mail', 'Test\MailController@handle'); //测试邮件
    Route::post('loginTest', 'TzAuth\LoginController@login'); //测试新登录
    Route::get('loginCheck', 'TzAuth\LoginController@loginCheck'); //检测登录状态
    Route::get('time', 'Test\TimeController@time'); //测试时间
    Route::get('user', 'Test\TimeController@time'); //测试时间
    Route::get('xun', 'Test\XunsearchController@test');//测试迅搜索
    Route::get('gf', 'DefenseIp\ApiController@addTest');    //检查状态
//    Route::get('info', 'Test\TestController@info');    //检查状态

});

//news接口路径
Route::group([
    'prefix' => 'news',
], function () {
    Route::get('getNews', 'News\NewsController@getNewsList');
    Route::get('getNewsDetails', 'News\NewsController@getNewsDetails');
});

Route::group([
    'prefix' => 'links',
], function () {
    Route::get('getLinks', 'News\LinksController@getLinks');
});


/**
 * 腾正Auth   (登录注册验证)
 */
Route::group([
    'prefix' => 'auth',
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
//    Route::post('loginByEmail', 'TzAuth\LoginController@loginByEmail');  //通过邮箱登录帐号
    Route::post('login', 'TzAuth\LoginController@login');  //通过帐号登录 (用户名或邮箱都可以)
    Route::get('getAllSalesman', 'TzAuth\RegisterController@getAllSalesman');  //获取所有业务员
    Route::get('loginCheck', 'TzAuth\LoginController@loginCheck');//判断用户是否登陆

});


/**
 * 用户后台组   (所有用户后台路由此组下)
 */
Route::group([
    'prefix' => 'home',
    'middleware' => 'UserOperationLog',
], function () {

    Route::group([
        'prefix' => 'userCenter',                           //用户中心
    ], function () {

        Route::get('resetNickName', 'Customer\UserCentorController@resetNickName');     //用户更改昵称
        Route::get('resetAcc', 'Customer\UserCentorController@resetAcc');                               //用户更改登录名

    });


    Route::group([
        'prefix' => 'recharge',                        //充值分组
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
            Route::get('getOrderById', 'Customer\OrderController@getOrderById');

            Route::post('renewresource', 'Customer\OrderController@renewResource');//续费
            Route::get('all_renew', 'Customer\OrderController@allRenew');//获取业务下续费的资源
            Route::get('show_renew_order', 'Customer\OrderController@showRenewOrder');//展示续费的订单
            Route::get('renew_pay', 'Customer\OrderController@payRenew');//续费订单支付

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

            /**
             * 退款相关
             */
            Route::post('show_refund', 'Customer\RefundController@showRefund');
            Route::post('insert_refund', 'Customer\RefundController@insertRefund');
            Route::post('cancel_refund', 'Customer\RefundController@cancelRefund');
            Route::post('delete_refund', 'Customer\RefundController@deleteRefund');

            //以下订单
            Route::post('payOrderByBalance', 'Customer\OrderController@payOrderByBalance');

            Route::get('flows', 'Customer\OrderController@flows');

            Route::get('get_sales', 'Customer\BusinessController@getSales');

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
            Route::post('getStatistics', 'DefenseIp\InfoController@getStatistics');  //获取流量数据
            Route::post('setTarget', 'DefenseIp\SetController@setTarget');  //配置目标IP

//            Route::get('showPackage', 'DefenseIp\OrderController@showPackage'); //前台显示套餐
            Route::get('buyDefenseIpNow', 'DefenseIp\OrderController@buyNow'); //购买套餐
            Route::get('renewDefenseIp', 'DefenseIp\OrderController@renew'); //续费套餐
        });

    });

    Route::get('defenseIp/showPackage', 'DefenseIp\OrderController@showPackage'); //前台显示套餐


});
