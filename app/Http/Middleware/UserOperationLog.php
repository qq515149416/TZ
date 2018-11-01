<?php

namespace App\Http\Middleware;

use App\Http\Models\Log\TzUsersOperationLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 每次请求都记录下请求方式、请求地址、提交数据
 * Class UserOperationLog
 * @package App\Http\Middleware
 */
class UserOperationLog
{
    public function handle(Request $req, Closure $next)
    {
        $user_id = 0;   //用户ID 默认为0

        //检测是否登录
        if (Auth::guard('web')->check()) {
            $user_id = (int)Auth::guard('web')->user()->id;  //若登录后  替换掉默认ID
        }

        $input = $req->all();
        $log   = new TzUsersOperationLog();    //实例化 用户日志模型
        $log->setAttribute('user_id', $user_id);  //用户ID
        $log->setAttribute('path', $req->path());  //路径
        $log->setAttribute('method', $req->method());   //模型
        $log->setAttribute('ip', $req->ip());      //IP
        $log->setAttribute('input', json_encode($input, JSON_UNESCAPED_UNICODE));  //转换成JSON格式
        $log->save();    //保存数据库
        return $next($req);   //
    }
}