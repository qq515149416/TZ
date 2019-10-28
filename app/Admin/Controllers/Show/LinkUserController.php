<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class LinkUserController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('联系人信息');
            $content->description('员工的联系信息');
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
