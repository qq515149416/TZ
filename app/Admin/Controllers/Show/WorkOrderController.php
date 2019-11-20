<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\Show\tool\script;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends script
{
    public function getPwdDepart() {
        return tz_ajax_echo(DB::table('oa_staff')
        ->join('tz_department','oa_staff.department','=','tz_department.id')
        ->where('oa_staff.admin_users_id',Admin::user()->id)
        ->select('tz_department.id','tz_department.depart_number','tz_department.depart_name','tz_department.sign')
        ->first(),"获取成功",1);
    }
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('工单列表');
            $content->description('工单操作');
            $content->body(view('show/app'));
            // Admin::script($this->script());
        });
    }
}
