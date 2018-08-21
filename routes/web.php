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

//测试组
Route::group([
    'prefix' => 'test',
],function () {
//    $route->get('jun', 'Test\TestController@test');
    Route::get('jun', 'Test\TestController@test');
});