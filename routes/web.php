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
    'middleware' => 'JudgeAgent'
], function () {
    Route::get('/', 'Show\IndexController@index'); //网站首页
    Route::get('/page/{directory}/{p}', 'Show\PageController@index');
    Route::get('/promotion/ddk', 'Show\DdkPromotionController@index');
    Route::get('/aboutus/{page}', 'Show\AboutUsController@index');
    Route::get('/promotion/consumer', 'Show\ConsumerPromotionController@index');
    Route::get('/zuyong/{page}/{room?}', 'Show\ServerRentController@index');
    Route::get('/solution/{page}', 'Show\SolutionController@index');
    Route::get('/tuoguan/{page}', 'Show\HostingController@index');
    Route::get('/article/{type}', 'Show\ArticleController@index');
    Route::get('/detail/{type}/{id}', 'Show\ArticleController@detail');
    Route::get('/15cdn/{page}', 'Show\CdnController@index');
    Route::get('/gaofangchuxiao', 'Show\GfPromotionController@index');
    Route::get('/protection/{page}', 'Show\ProtectionController@index');
    Route::get('/test', 'Show\TestController@index');
    Route::get('/15cdn/{page}', 'Show\CdnController@index');
    Route::get('/datacenter/{page}', 'Show\DataCenterController@index');
    Route::get('/datacenter/json/{page}', 'Show\DataCenterController@roomData');
    Route::get('/dist/highDefense.html', 'Show\ProtectionController@gaofang');
    Route::get('/cabinet-rent/{page}', 'Show\CabinetRentController@index');
    Route::get('/bandwidth-rent/{page}', 'Show\BandwidthRentController@index');
    Route::get('/activity', 'Show\LatestActivityController@index');
    Route::get('/yun/{page}', 'Show\YunController@index');
    Route::get('/help/search', 'Show\HelpCenterController@search');
    Route::get('/help/{page?}', 'Show\HelpCenterController@index');
    Route::get('/help/category/{id}', 'Show\HelpCenterController@category');
    Route::get('/help/detail/{id}', 'Show\HelpCenterController@detail');
    Route::get('/souvenir', 'Show\SouvenirController@index');
    Route::get('/overlayPackage', 'Show\OverlayPackageController@index');
    Route::get('/army_day', 'Show\ArmyDayController@index');
    Route::get('/mid_autumn', 'Show\MidAutumnController@index');
    Route::get('/double11', 'Show\Double11Controller@index');
    Route::get('/overseas/{page?}/{room?}', 'Show\OverseasController@index');
});
Route::get('/admin/{path?}', 'Show\AdminController@index')->where('path', '.+');
Route::get('/double11', 'Show\Double11Controller@index'); //双11活动页  *黄晓敏需求:不要跳转移动端

//移动端接口路径
Route::group([
    'prefix' => 'wap',
    'middleware' => 'JudgeAgent'
], function () {
    Route::get('/', 'Show\wap\IndexController@index');
    Route::get('/menu', 'Show\wap\MenuController@index');
    Route::get('/server_hire', 'Show\wap\ServerHireController@index');
    Route::get('/server_hosting', 'Show\wap\ServerHostingController@index');
    Route::get('/cabinet', 'Show\wap\CabinetController@index');
    Route::get('/bandwidth', 'Show\wap\BandwidthController@index');
    Route::get('/high_security', 'Show\wap\HighSecurityController@index');
    Route::get('/high_proof_host', 'Show\wap\HighProofHostController@index');
    Route::get('/high_security_ip', 'Show\wap\HighSecurityIPController@index');
    Route::get('/cdn_speed_up', 'Show\wap\CdnSpeedUpController@index');
    Route::get('/c_shield', 'Show\wap\CshieldController@index');
    Route::get('/high_anti_cdn', 'Show\wap\HighAntiCDNController@index');
    Route::get('/flow_stack_packet', 'Show\wap\FlowStackPacketController@index');
    Route::get('/cloud_hosting', 'Show\wap\CloudHostingController@index');
    Route::get('/chess_solution', 'Show\wap\ChessSolutionController@index');
    Route::get('/deployment_solution', 'Show\wap\DeploymentSolutionController@index');
    Route::get('/education_solution', 'Show\wap\EducationSolutionController@index');
    Route::get('/financial_solution', 'Show\wap\FinancialSolutionController@index');
    Route::get('/game_solution', 'Show\wap\GameSolutionController@index');
    Route::get('/government_solution', 'Show\wap\GovernmentSolutionController@index');
    Route::get('/media_solution', 'Show\wap\MediaSolutionController@index');
    Route::get('/mobileapp_solution', 'Show\wap\MobileappSolutionController@index');
    Route::get('/company/{page}', 'Show\wap\CompanyIntroductionController@index');
    Route::get('/help_center_home/{page}', 'Show\wap\HelpCenterHomeController@index');
    Route::get('/help_center', 'Show\wap\HelpCenterController@index');
    Route::get('/search_results', 'Show\wap\SearchResultsController@index');
    Route::get('/login', 'Show\wap\LoginController@index');
    Route::get('/registered', 'Show\wap\RegisteredController@index');
    Route::get('/logging', 'Show\wap\LoggingController@index');
    Route::get('/login_register_menu', 'Show\wap\LoginRegisteredMenuController@index');
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

Route::group([
    'prefix' => 'promotion',
], function () {
    Route::get('getPro', 'News\PromotionController@getPro');
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


            /*** 微信支付的start ***/

            Route::get('rechargeByWechat', 'Pay\RechargeController@rechargeByWechat');//直接生成订单 + 获取二维码url接口

            Route::get('getWechatUrlOut', 'Pay\RechargeController@getWechatUrlOut');//根据充值单id获取二维码url接口

            /*** 微信支付的end ***/
        });

        Route::post('wechatNotify', 'Pay\WechatPayController@notify');//微信异步接收通知

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
            Route::post('cancelWhiteList', 'Customer\WhiteListController@cancelWhiteList');
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

            //高防提交白名单
            Route::post('insertWhiteListForDIP', 'Customer\WhiteListController@insertWhiteListForDIP');
            //用户查看自己所有使用中业务里包含的ip,供提交白名单用
             Route::get('getAllIP', 'Customer\WhiteListController@getAllIP');

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

    //用户购买和使用叠加包
    Route::group([
        'prefix' => 'overlay',
    ], function () {
        Route::group([
            'middleware' => 'CheckLogin',
        ], function () {
            Route::get('showOverlay', 'DefenseIp\OverlayController@showOverlay');
            Route::post('buyNowByCustomer', 'DefenseIp\OverlayController@buyNowByCustomer');
            Route::get('showBelong', 'DefenseIp\OverlayController@showBelong');
            Route::post('useOverlayToDIP', 'DefenseIp\OverlayController@useOverlayToDIP');
            Route::post('useOverlayToIDC', 'DefenseIp\OverlayController@useOverlayToIDC');
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

/**
 * api相关
 */
Route::group([
    'prefix' => 'api',
], function () {

    Route::group([
        'middleware' => 'CheckLogin',
    ], function () {
        /** 客户端api资格及秘钥展示 start **/
        Route::get('apiApply', 'Customer\ApiController@apiApply');      //申请api
        Route::get('show', 'Customer\ApiController@show');              //查看api申请状态
        Route::get('showKey', 'Customer\ApiController@showKey');   //查看api秘钥
        /** 客户端api资格及秘钥展示 end **/
        /** 客户端api用可购买套餐展示 start **/
        Route::get('showDIPPackage', 'Customer\ApiController@showDIPPackage');      //可购买的高防套餐展示
        Route::get('showOverlayPackage', 'Customer\ApiController@showOverlayPackage');      //可购买的叠加包套餐展示
        /** 客户端api用可购买套餐展示 end **/
    });
    /** 外部api start **/
    Route::group([
        'prefix' => 'ver1', //版本
    ], function () {
        /** 高防类api start **/
        Route::group([
                'prefix' => 'dip', //高防类
        ], function () {
                Route::post('buyDIP', 'Customer\ApiOutController@buyDIP');      //购买高防套餐的接口
        });
        /** 高防类api end **/
    });
    /** 外部api end **/




});
