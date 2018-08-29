<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Requests\TzAuth\LoginByEmailRequest;
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
     * @param LoginByEmailRequest $request
     * @return mixed
     */
    public function loginByEmail(LoginByEmailRequest $request)
    {
        $res = $request->all(); //获取参数

        //通过邮箱登录
        $loginInfo = Auth::attempt(['email' => $res['email'], 'password' => $res['password']]);

        //验证是否登成功
        if (!$loginInfo) {
            //登录失败
            return tz_ajax_echo([], '密码错误', 0);
        }
        return tz_ajax_echo($loginInfo, '登录成功', 1);
    }

}
