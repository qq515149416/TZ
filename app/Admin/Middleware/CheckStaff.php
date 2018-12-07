<?php
/**
 * 检测后台管理账户是否信息填写完整 中间件
 */

namespace App\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Layout\Content;

class CheckStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   

        $admin_id = Admin::user()->id;
        $staff = DB::table('oa_staff')
                    ->join('tz_department','oa_staff.department','=','tz_department.id')
                    ->join('tz_jobs','oa_staff.job','=','tz_jobs.id')
                    ->where(['admin_users_id'=>$admin_id])
                    ->select('oa_staff.work_number','oa_staff.department','tz_department.sign','tz_jobs.slug')
                    ->first();
        // if(empty($staff)){
        //     return  redirect('/tz_admin/auth/logout');
        // }

        return $next($request);
    }

}
