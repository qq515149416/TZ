<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;


class HomeController extends script
{
    public function index()
    {   
        return Admin::content(function (Content $content) {

            $content->header('首页');
//            $content->description('Description...');

//            $content->row(Dashboard::title());

            $content->body(view('show/home'));
            Admin::script($this->script());

//            $content->body(view('welcome'));

        });
    }
}
