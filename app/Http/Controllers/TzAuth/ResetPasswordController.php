<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
use App\Http\Models\User\TzUsersVerification;
use App\Http\Requests\TzAuth\SendEmailCodeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ResetPasswordController extends Controller
{

    /**
     * 通过邮箱重置密码
     *
     * 类型:POST
     * 参数:
     *      email  :  邮箱帐号
     *      password: 修改后的密码
     *      token  :邮箱验证码
     */
    public function resetPasswordByEmail(Request $request)
    {

        $res                    = $request->all();    //获取参数
        $usersVerificationModel = new TzUsersVerification();   //实例化
        $verificationData       = $usersVerificationModel->where('accounts', $res['email'])->first(); //根据帐号获取相关验证码信息

        //验证数据库账号与验证码是否匹配
        if ((!$verificationData) || ($verificationData['token'] !== $res['token'])) {
            return tz_ajax_echo(null, '验证码错误', 0);
        }

        //验证验证码是否已经过期
        if (!tz_time_expire($verificationData['updated_at'], 2)) {
            return tz_ajax_echo(null, '验证码已过期', 0);
        }

        $tzUserModel = new TzUser(); //实例化

        //根据用户邮箱更新 用户帐号密码
        $updateState = $tzUserModel->where('email', $res['email'])->update([
            'password' => Hash::make($res['password']),
        ]);

        //修改数据库中的密码
        if ($updateState) {
            //成功

        } else {
            //失败
//            return
        }


        //_______________________________测试数据____________________
//        dump($verificationData['created_at']); //打印测试数据
//        dump($time1 = date("Y-m-d H:i:s"));
//        dump(strtotime($time1));
//        dump(5 * 60 * 60);
//        dump(strtotime($verificationData['created_at']));
//        dump(tz_time_expire($verificationData['created_at'], 1));
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
        $par   = $request->all();//获取参数
        $token = mt_rand(10000, 99999);//生成随机验证码
        $mail  = $par['email']; //测试接受代码的邮箱

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
            return tz_ajax_echo([], '验证码发送失败', 0);  //返回发送失败
        }

    }

}