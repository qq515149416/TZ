<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\User\TzUsersVerification;
use App\Http\Requests\TzAuth\SendEmailCodeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class ResetPasswordController extends Controller
{

    /**
     * 通过邮箱重置密码
     *
     * 类型:POST
     * 参数:
     *      password: 修改后的密码
     *      token  :邮箱验证码
     */
    public function resetPasswordByEmail(Request $request)
    {
        $res = $request->all(); //获取参数
        $usersVerificationModel = new TzUsersVerification();//实例化
        $testData = $usersVerificationModel->find(1); // 测试数据
//
        dump($testData['created_at']); //打印测试数据
        dump($time1=date("Y-m-d H:i:s"));
        dump(strtotime($time1));
        dump(5*60*60);
        dump(strtotime($testData['created_at']));
        dump(tz_time_expire($testData['created_at'],1));

    }


    /**
     * 发送邮箱验证码
     *
     * 类型:POST
     * 参数:
     *      email: 需要发送验证码的邮箱
     *
     * @param SendEmailCodeRequest $request
     * @return mixed
     */
    public function sendEmailCode(SendEmailCodeRequest $request)
    {
        $par = $request->all();//获取参数
        $token = mt_rand(10000, 99999);//生成随机验证码
        $mail = $par['email']; //测试接受代码的邮箱

        //发送邮件
        Mail::send('emails.code', ['token' => $token], function ($message) use ($mail) {
            $to = $mail;
            $message->to($to)->subject('邮箱验证');
        });

        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) < 1) {
            $usersVerificationModel = new TzUsersVerification();//实例化
            $usersVerificationModel->addMailToken($mail, $token);  //添加邮箱作为帐号的验证码
            return tz_ajax_echo([], '验证码发送成功', 1);
        } else {
            return tz_ajax_echo([], '验证码发送失败', 0);
        }

    }

}