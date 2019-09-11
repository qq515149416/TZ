<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

class InvoiceController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('发票库');
            $content->description('发票管理');
            $content->body(view('show/invoice'));
            Admin::script($this->script());
        });
    }
}