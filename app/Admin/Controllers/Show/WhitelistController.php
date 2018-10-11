<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class WhitelistController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('白名单');
            $content->description('白名单操作');
            $content->body(view('show/whitelist'));
            Admin::script($this->script());
        });
    }
}