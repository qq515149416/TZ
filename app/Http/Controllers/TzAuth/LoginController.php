<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
use App\Http\Requests\TzAuth\LoginByEmailRequest;
use App\Http\Requests\TzAuth\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{


    /**
     * 退出登录并跳转到主页
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout(); //清除登录信息
        return Redirect::to('/'); //跳转
    }


    /**
     * 登录
     *
     * 参数:
     *   login_name: 登录名   邮箱或者name
     *   password :用户密码
     *   captcha :图形验证码
     *
     * @param LoginRequest $request
     * @return mixed|string
     */
    public function login(LoginRequest $request)
    {

        $res = $request->all();//获取参数

        $TzUserM    = new TzUser();//实例化用户模型
        $userExists = $TzUserM->where('name', '=', $res['login_name'])->exists();//判断是否存在对应的用户名帐号
        if ($userExists) {
            //存在 尝试用户名登录
            $loginInfo = $this->loginByName($res['login_name'], $res['password']);//尝试使用用户名登陆
            if ($loginInfo) {
                return tz_ajax_echo([], '登录成功', 1);//登录成功
            } else {
                return tz_ajax_echo([], '登录失败,帐号或者密码错误', 0);//登录失败
            }
        } else {
            //不存对应的用户名

            $loginInfo = $this->loginByEmail($res['login_name'], $res['password']);//尝试邮箱帐号登陆

            //判断是否登录成功
            if ($loginInfo) {
                return tz_ajax_echo([], '登录成功', 1);//登录成功
            } else {
                return tz_ajax_echo([], '登录失败,帐号或者密码错误', 0);//登录失败
            }
        }
    }


    /**
     * 用户名登录
     *
     * @param $loginName
     * @param $password
     * @return bool
     */
    protected function loginByName($loginName, $password)
    {
        return Auth::attempt(['name' => $loginName, 'password' => $password]);
    }

    /**
     * 通过邮箱登录
     *
     * @param $loginName
     * @param $password
     * @return bool
     */
    protected function loginByEmail($loginName, $password)
    {
        return Auth::attempt(['email' => $loginName, 'password' => $password]);
    }


    /**
     * 通过老用户帐号导入老OA数据
     *
     * 密码加密方式 md5()+ '01?!010@$%203**'
     *
     */
    protected function loginByOldOa()
    {



    }

    /**
     * 检测登录状态
     * @return mixed
     */
    public function loginCheck()
    {



        dump(md5(123456));
        die();

//        //判断有无登录
//        if (!Auth::check()) {
//            return tz_ajax_echo(null, '未登录', 5000);
//        }
//        return tz_ajax_echo(null, '已登录', 1);
    }


    //    /**
//     * 通过邮箱登录
//     *  auth/loginByEmail
//     * 类型:GET
//     * 参数:
//     *
//     *      email: 用户邮箱
//     *      password :用户密码
//     *      captcha :图形验证码
//     *
//     * @param LoginByEmailRequest $request
//     * @return mixed
//     */
//    public function loginByEmail(LoginByEmailRequest $request)
//    {
//        $res       = $request->all(); //获取参数
//        $loginInfo = Auth::attempt(['email' => $res['email'], 'password' => $res['password']]); //通过邮箱登录
//
//        //验证是否登成功
//        if (!$loginInfo) {
//            return tz_ajax_echo([], '密码错误', 0); //登录失败
//        }
//        return tz_ajax_echo($loginInfo, '登录成功', 1);  //登录成功
////        return tz_ajax_echo($loginInfo, '登录成功', 1);  //登录成功
////        return redirect('/tz/index.html');
//    }


}
