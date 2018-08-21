<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//每次请求都记录下请求方式、请求地址、提交数据
class UserOperationLog {
//    public function handle(Request $req, Closure $next) {
//        $user_id = 0;
//        if(Auth::guard('admin')->check()) {
//            $user_id = (int) Auth::guard('admin')->user()->id;
//        }
//        $input = $req->all();
////        $log = new \App\Models\OperationLog();
//        $log->setAttribute('user_id', $user_id);
//        $log->setAttribute('path', $req->path());
//        $log->setAttribute('method', $req->method());
//        $log->setAttribute('ip', $req->ip());
//        $log->setAttribute('input', json_encode($input, JSON_UNESCAPED_UNICODE));
//        $log->save();
//        return $next($req);
//    }
}