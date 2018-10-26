<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class WorkOrderTypeController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('工单列表');
            $content->description('工单操作');
            $content->body(view('show/workOrder'));
            Admin::script($this->script());
        });
    }
}