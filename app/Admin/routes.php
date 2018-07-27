<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->get('test', 'Others\StaffController@test');
    $router->get('staff/maillist', 'Others\StaffController@index');
    $router->get('ctset', 'Others\ContactsController@test');
    $router->get('contacts/maillist', 'Others\ContactsController@test');
    $router->post('rules', 'Others\ContactsController@rulestest');
	$router->get('rules', 'Others\ContactsController@rulestest');
    $router->get('/user_list', 'UserController@index');

});
