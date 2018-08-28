<?php

namespace App\Http\Controllers\TzAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{


    /**
     * 退出登录并跳转到主页
     */
    public function logout()
    {
        //清除登录信息
        Auth::logout();

        //跳转
        return Redirect::to('/');
    }

}
