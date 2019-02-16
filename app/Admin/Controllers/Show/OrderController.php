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

class OrderController extends script
{
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {
            // global $request;
            $content->header('业务订单管理');
            $content->description('业务订单操作');
            // $content->breadcrumb(
            //     ['text' => '客户管理', 'url' => '/show/crm/clientele'],
            //     ['text' => '业务管理','url' => '/show/business?'.$request->session()->get("url_param")],
            //     ['text' => '业务订单管理']
            // );
            $content->body(view('show/order'));
            Admin::script($this->script());
        });
    }
}
