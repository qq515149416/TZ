<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends script
{
    public function clienteleInfo(Request $request)
    {
        // if($request->has('id')) {
        //     $param = $request->all();
        //     return tz_ajax_echo(DB::table('tz_users')->where(['id'=>$param["id"]])->first(),"获取成功",1);
        // }
        return tz_ajax_echo(session("url_param_json"),"获取成功",1);
    }
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {
            // global $request;
            $content->header('业务订单管理');
            $content->description('业务订单操作');
            // dump(session("url_param"));
            $content->breadcrumb(
                ['text' => '客户管理', 'url' => '/show/crm/clientele'],
                ['text' => '业务管理','url' => '/show/business'.session("url_param")],
                ['text' => '业务订单管理']
            );
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
