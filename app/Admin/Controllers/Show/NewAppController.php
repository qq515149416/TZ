<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class NewAppController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('新版测试');
            $content->description('新版OA系统测试管理');
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
