<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Requests\TzAuth\LoginByEmailRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TestController extends Controller
{

    /**
     * 模拟登录
     */
    public function login()
    {
        Auth::loginUsingId(27);
        return tz_ajax_echo([],'登录成功',1);
    }

    public function login2()
    {
//        Auth::loginUsingId(2);
//        return tz_ajax_echo([],'登录成功',1)

        dump(Auth::user());
    }


}