<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class UserController extends Controller
{
    public function index()
    {   
        return Admin::content(function (Content $content) {
            $content->header('用户列表');
            $content->description('用户的信息');
            $content->body(view('show/index'));
        });
    }
}
