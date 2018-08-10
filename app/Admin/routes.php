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
        'prefix' => 'contacts';
    ],function(Router $router){
        $router->get('contacts/list', 'Others\ContactsController@index');
        $router->post('contacts/insert', 'Others\ContactsController@insert');
        $router->get('contacts/alert', 'Others\ContactsController@edit');
        $router->post('contacts/alerting', 'Others\ContactsController@doEdit');
        $router->post('contacts/remove', 'Others\ContactsController@deleted');
    });
    
//ip
    Route::group([
        'prefix' => 'ips';
    ],function(Router $router){
        $router->get('index', 'Idc\IpsController@index');
        $router->post('insert', 'Idc\IpsController@insert');
        $router->get('alert', 'Idc\IpsController@edit');
        $router->post('alerting', 'Idc\IpsController@doEdit');
        $router->post('remove', 'Idc\IpsController@deleted');
        $router->get('machineroom', 'Idc\IpsController@machineroom');
    });
    

    $router->post('rules', 'Others\ContactsController@rulestest');
    $router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('vi', 'Others\ContactsController@vi');
    // 前端显示
    $router->get('/user_list', 'Show\UserController@index');
    $router->get('/user_link_list', 'Show\LinkUserController@index');
    $router->get('/machine_room/show', 'Show\TestController@index');
    $router->get('/resource/ip', 'Show\IpController@index');
//人事
    Route::group([
        'prefix' => 'hr';
    ],function(Router $router){
        $router->get('showaccount', 'Hr\AccountController@showAccount');
    });
    

    //机房管理
    Route::group([
        'prefix' => 'machine_room',
    ], function (Router $router) {
    $router->get('showByAjax', 'Idc\MachineRoomController@showByAjax');
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


});
