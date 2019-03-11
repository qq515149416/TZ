<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class DefenseBusinessReviewController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('高防业务审核管理');
            // $content->description('业务操作');
            $content->body(view('show/defenseBusinesReview'));
            Admin::script($this->script());
        });
    }
}
