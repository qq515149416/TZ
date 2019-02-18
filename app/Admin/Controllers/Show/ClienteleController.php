<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class ClienteleController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('客户管理');
            $content->description('客户信息管理');
            $content->breadcrumb(
                ['text' => '客户管理', 'url' => '/crm/clientele']
            );
            $content->body(view('show/clientele'));
            Admin::script($this->script());
        });
    }
}
