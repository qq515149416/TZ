<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;

<<<<<<< HEAD
=======

>>>>>>> 26d2e3d12349d40a2756d59f04204e9b7b00e150
class MachineProcessingController extends script
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('机器处理');
            // $content->description('机器资源管理');
            $content->body(view('show/machineProcessing'));
            Admin::script($this->script());
        });
    }
}
