<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class WorkTypeController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('工单类型');
            $content->description('工单类型操作');
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
