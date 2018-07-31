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

    // 显示通讯录
    $router->get('staff/maillist', 'Others\StaffController@index');
    
  // 联系人表
    $router->get('contacts/list','Others\ContactsController@index');
    $router->post('contacts/insert','Others\ContactsController@create');
    $router->get('contacts/alert','Others\ContactsController@edit');
    $router->post('contacts/alerting','Others\ContactsController@doEdit');
    $router->post('contacts/remove','Others\ContactsController@deleted');

    $router->post('rules', 'Others\ContactsController@rulestest');
	$router->get('rules', 'Others\ContactsController@rulestest');
	$router->get('vi', 'Others\ContactsController@vi');
    $router->get('/user_list', 'Show\UserController@index');


});
