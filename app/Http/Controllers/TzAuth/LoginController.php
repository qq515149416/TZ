<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
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
        Auth::logout(); //清除登录信息
        return Redirect::to('/'); //跳转
    }

    /**
     * 通过邮箱登录
     *  auth/loginByEmail
     * 类型:GET
     * 参数:
     *
     *      email: 用户邮箱
     *      password :用户密码
     *      captcha :图形验证码
     *
     * @param LoginByEmailRequest $request
     * @return mixed
     */
    public function loginByEmail(LoginByEmailRequest $request)
    {
        $res       = $request->all(); //获取参数
        $loginInfo = Auth::attempt(['email' => $res['email'], 'password' => $res['password']]); //通过邮箱登录

        //验证是否登成功
        if (!$loginInfo) {
            return tz_ajax_echo([], '密码错误', 0); //登录失败
        }
        return tz_ajax_echo($loginInfo, '登录成功', 1);  //登录成功
//        return tz_ajax_echo($loginInfo, '登录成功', 1);  //登录成功
//        return redirect('/tz/index.html');
    }


    /**
     * 登录
     */
    public function login()
    {

        $loginName='Jun';

        $TzUserM = new TzUser();

        //判断是否存在
        $userExists = $TzUserM->where('name', '=',$loginName )->exists();
        if ($userExists) {
            //存在


            dump('1');

        } else {
            //不存在


            dump('2');

        }

        dump($userExists);

    }


}
