<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
use App\Http\Models\User\TzUsersVerification;
use App\Http\Requests\TzAuth\RegisterByEmailRequest;
use App\Http\Requests\TzAuth\SendEmailCodeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * 测试方法
     */
    public function test(Request $request)
    {

//        Auth::logout();
        dump(Auth::check());
        dump(Auth::user());

    }

    public function test2()
    {
        dump(Auth::check());

    }

    /**
     * 添加
     */
    public function create()
    {

    }

    /**
     * 通过邮箱注册帐号
     *
     * 参数:
     * email: 邮箱帐号
     * token :  邮箱验证码
     * password :密码
     *
     *
     */
    public function registerByEmail(RegisterByEmailRequest $request)
    {
        //获取参数
        $par = $request->all();

        //实例化
        $usersVerificationModel = new TzUsersVerification();

        //判断邮箱验证码是否正确
        $verificationData = $usersVerificationModel->where('accounts', '=', $par['email'])->first();

        //验证码是否正确
        if (($par['token'] == $verificationData['token']) && ($par['email'] == $verificationData['accounts'])) {
            //实例化
            $TzUserModel = new TzUser();

            //添加帐号
            $addUserInfo = $TzUserModel->create([
//                'name'     => $par['name'], //用户名暂时不写入
                'email'    => $par['email'],
                'password' => Hash::make($par['password']),
                'status'   => 2,  //状态为已验证
            ]);
            Auth::loginUsingId($addUserInfo['id']);
//            dump(Auth::loginUsingId($addUserInfo['id'],true));
//            dump(Auth::check());
//            dump($addUserInfo);
//            dump('验证成功');
            return tz_ajax_echo([],'注册成功',1);
        } else {
            return tz_ajax_echo([],'注册失败,验证码失败',0);
        }
    }

    /**
     * 发送邮箱验证码
     *
     * 参数:
     * email: 发送验证码的邮箱
     * captcha : 验证码
     *
     */
    public function sendCodeToEmail(SendEmailCodeRequest $request)
    {

        //获取参数
        $par = $request->all();

        //生成随机验证码
        $token = mt_rand(10000, 99999);

        //测试接受代码的邮箱
        $mail = $par['email'];

        //发送邮件
        Mail::send('emails.code', ['token' => $token], function ($message) use ($mail) {
            $to = $mail;
            $message->to($to)->subject('邮箱验证');
        });

        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) < 1) {
            //实例化
            $usersVerificationModel = new TzUsersVerification();
            $usersVerificationModel->addMailToken($mail, $token);

            return tz_ajax_echo([], '验证码发送成功', 1);
        } else {
            return tz_ajax_echo([], '验证码发送失败', 0);
        }

    }




//return User::create([
//'name' => $data['name'],
//'email' => $data['email'],
//'password' => Hash::make($data['password']),
//]);

}
