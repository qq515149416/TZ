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

    /**
     * 通过邮箱登录
     *
     * 类型:GET
     * 参数:
     *      email: 用户邮箱
     *      password :用户密码
     *      captcha :图形验证码
     *
     * @param Request $request
     */
    public function loginByEmail(Request $request)
    {
        //获取参数
        $res = $request->all();




    }

}
