<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class StatisticalOverviewController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('统计概览');
            $content->description('统计展示');
            $content->body(view('show/statisticalOverview'));
            Admin::script($this->script());
        });
    }
}
