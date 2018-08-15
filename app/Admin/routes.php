<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');


    //Jun   个人测试用
    $router->post('jun/test', 'Idc\MachineRoomController@store');
    // 测试使用
    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    $router->get('ctset', 'Others\ContactsController@test');
    $router->get('test', 'Others\StaffController@test');
    $router->get('contacts/maillist', 'Others\ContactsController@test');
    $router->get('ip/test', 'Idc\IpsController@test');
    $router->get('account/test','Hr\AccountController@test');

    // 显示通讯录
    $router->get('staff/staff_list', 'Others\StaffController@index');

    // 联系人表
    Route::group([
        'prefix' => 'contacts',
    ],function(Router $router){
        $router->get('list', 'Others\ContactsController@index');
        $router->post('insert', 'Others\ContactsController@insert');
        $router->get('alert', 'Others\ContactsController@edit');
        $router->post('alerting', 'Others\ContactsController@doEdit');
        $router->post('remove', 'Others\ContactsController@deleted');
    });
    
//ip
    Route::group([
        'prefix' => 'ips',
    ],function(Router $router){
        $router->get('index', 'Idc\IpsController@index');
        $router->post('insert', 'Idc\IpsController@insert');
        $router->get('alert', 'Idc\IpsController@edit');
        $router->post('alerting', 'Idc\IpsController@doEdit');
        $router->post('remove', 'Idc\IpsController@deleted');
        $router->get('machineroom', 'Idc\IpsController@machineroom');
        $router->post('insertmore','Idc\IpsController@batch');
    });
    

    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    // 前端显示
    $router->get('/user_list', 'Show\UserController@index');
    $router->get('/user_link_list', 'Show\LinkUserController@index');
    $router->get('/machine_room/show', 'Show\TestController@index');
    $router->get('/resource/ip', 'Show\IpController@index');
    $router->get('/resource/machine_room', 'Show\MachineRoomController@index');
    $router->get('/resource/cabinet', 'Show\CabinetController@index');
    $router->get('/article', 'Show\NewController@index');
//人事
    Route::group([
        'prefix' => 'hr',
    ],function(Router $router){
        $router->get('showaccount', 'Hr\AccountController@showAccount');
    });
    

    //机房管理
    Route::group([
        'prefix' => 'machine_room',
    ], function (Router $router) {
    $router->get('showByAjax', 'Idc\MachineRoomController@showByAjax');
    $router->get('show_select_list_by_ajax', 'Idc\MachineRoomController@showSelectListByAjax');
    $router->post('storeByAjax', 'Idc\MachineRoomController@storeByAjax');
    $router->post('destroyByAjax', 'Idc\MachineRoomController@destroyByAjax');
    $router->post('updateByAjax', 'Idc\MachineRoomController@updateByAjax');
    });

    //机柜管理   分组增删改查
    Route::group([
        'prefix' => 'cabinet',
    ], function (Router $router) {
        $router->get('showByAjax', 'Idc\CabinetController@showByAjax');
        $router->post('storeByAjax', 'Idc\CabinetController@storeByAjax');
        $router->post('destroyByAjax', 'Idc\CabinetController@destroyByAjax');
        $router->post('updateByAjax', 'Idc\CabinetController@updateByAjax');

    });

    //消息管理
    Route::group([
        'prefix' => 'news',
    ],function (Router $router) {
        $router->get('news_list', 'News\NewsController@index');
        $router->post('insert', 'News\NewsController@insert');
        $router->post('edit', 'News\NewsController@edit');
        $router->post('deleted', 'News\NewsController@deleted');
        $router->get('get_news_type', 'News\NewsController@get_news_type');
    });

    //消息管理
    Route::group([
        'prefix' => 'cpu',
    ],function (Router $router) {
        $router->get('cpu_list', 'Cpu\CpuController@index');
        $router->post('insert', 'Cpu\CpuController@insert');
        $router->post('deleted', 'Cpu\CpuController@deleted');
        $router->post('edit', 'Cpu\CpuController@edit');
    });
});

