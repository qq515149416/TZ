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

class WorkOrderTypeController extends script
{
    public function index()
    {	
    	$department = DB::table('oa_staff')
        					->join('tz_department','oa_staff.department','=','tz_department.id')
        					->where('oa_staff.admin_users_id',Admin::user()->id)
        					->select('tz_department.id','tz_department.depart_number','tz_department.depart_name','tz_department.sign')
            				->first();
       	// Admin::user()->depart_id = $department->id;
       	// Admin::user()->depart_number = $department->depart_number;
       	// Admin::user()->depart_name = $department->depart_name;
       	// Admin::user()->sign = $department->sign;
            				session(['depart'=>$department]);
        return Admin::content(function (Content $content) {
            $content->header('工单列表');
            $content->description('工单操作');
            $content->body(view('show/workOrder'));
            Admin::script($this->script());
        });
    }
}