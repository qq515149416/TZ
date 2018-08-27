<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
use App\Http\Models\User\TzUsersVerification;
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
//        dump($request->all());

//        dump(Auth::login(TzUser::find(2)));
//        Auth::loginUsingId(2);
//        Auth::logout();
        Auth::attempt(['email' => '568171152@qq.com', 'password' => 'zhangjun'], true);
//        dump(Auth::check());
        dump(Hash::make('zhangjun'));
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
     */
    public function registerByEmail(Request $request)
    {
        //获取参数
        $par = $request->all();

        //实例化
        $usersVerificationModel = new TzUsersVerification();

        //判断邮箱验证码是否正确
        $verificationData = $usersVerificationModel->where('accounts', '=', '568171152@qq.com')->first();

        //验证码是否正确
        if ($par['token'] == $verificationData['token']) {

            
            dump('验证成功');
        } else {

            dump('验证失败');
        }

        dump($par['token']);
        dump($verificationData['token']);

        dd($verificationData);

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
