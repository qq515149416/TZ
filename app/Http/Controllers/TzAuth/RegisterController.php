<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
use App\Http\Models\User\AdminUsers;
use App\Http\Models\User\OaStaff;
use App\Http\Models\User\TzJobs;
use App\Http\Models\User\TzUsersVerification;
use App\Http\Requests\TzAuth\RegisterByEmailRequest;
use App\Http\Requests\TzAuth\SendEmailCodeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    /**
     * 测试方法
     */
    public function test(Request $request)
    {

//        dump(captcha_src('tz'));
        dump(Session::all());
//        Auth::logout();
        dump(Auth::check());
        dump(Auth::user());

//        return response()->view()
//        return

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
    public function registerByEmail(RegisterByEmailRequest $request)
    {

        $par                    = $request->all();  //获取参数
        $usersVerificationModel = new TzUsersVerification();  //实例化

        //判断邮箱验证码是否正确
        $verificationData = $usersVerificationModel->where('accounts', '=', $par['email'])->first();

        //验证码是否正确
        if (($par['token'] == $verificationData['token']) && ($par['email'] == $verificationData['accounts'])) {
            $TzUserModel = new TzUser();//实例化

            //添加帐号
            $addUserInfo = $TzUserModel->create([
//                'name'     => $par['name'], //用户名暂时不写入
                'email'    => $par['email'],
                'password' => Hash::make($par['password']),
                'status'   => 2,  //状态为已验证
            ]);
            Auth::loginUsingId($addUserInfo['id']);  //注册后自动登录
            return tz_ajax_echo([], '注册成功', 1);   //注册成功
        } else {
            return tz_ajax_echo([], '注册失败,验证码失败', 0);   //注册失败
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

        $par   = $request->all();                  //获取参数
        $token = mt_rand(10000, 99999);         //生成随机验证码
        $mail  = $par['email'];                  //测试接受代码的邮箱

        //发送邮件
        Mail::send('emails.code', ['token' => $token], function ($message) use ($mail) {
            $to = $mail;
            $message->to($to)->subject('邮箱验证');
        });

        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) < 1) {   //返回错误数大于1
            //实例化
            $usersVerificationModel = new TzUsersVerification();
            $usersVerificationModel->addMailToken($mail, $token);

            return tz_ajax_echo([], '验证码发送成功', 1);  //成功
        } else {
            return tz_ajax_echo([], '验证码发送失败', 0);  //失败
        }

    }


    /**
     * 查询所有业务员
     * admin_users_id  职位表里面的user_id
     */
    public function getAllSalesman()
    {
        $tzJobsModel     = new TzJobs();  //实例化  职位表
        $oaStaffModel    = new OaStaff(); // 实例化 员工表
        $adminUsersModel = new AdminUsers(); // 实例化 后台用户表

        $salemanJobId = $tzJobsModel->getAllSalesmanJobId();  //获取所有销售员职位ID
        $adminUserId  = $oaStaffModel->getAdminUserIdByJob($salemanJobId); //根据职位ID获取后台账户ID

        dump($adminUserId);

//--------------------------------------------------------------------------------------
//        $oaStaffList = [];  //定义空数组
//        foreach ($salemanJobId as $key => $value) {
////            dump($oaStaffModel->getAdminUserIdByJob($value));
//            $a           = $oaStaffModel->getAdminUserIdByJob($value);
//            $oaStaffList = array_merge($oaStaffList, $a);
//        }
//
//        dump($oaStaffList);
//------------------------------------------------------------------------------------------

//        dump($salemanJobId);
//        dump($adminUserId);


//        $testData = DB::table('admin_users')


//        $b = $tzJobsModel->getAllSalesmanJobId();
//        $c = $tzJobsModel->getAllSalesmanJobId();
//
//        $a = array_merge($b,$c);

//        dump($a);

    }


}
