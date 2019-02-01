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
use XS;
use XSDocument;

class RegisterController extends Controller
{
    /**
     * 测试方法
     */
    public function test(Request $request)
    {


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

            //判断帐号是否存在
            $userExists = $TzUserModel->where('email', '=', $par['email'])->exists();
            if ($userExists) {
                return tz_ajax_echo([], '注册失败,帐号已存在', 0);//注册失败,邮箱帐号已存在
            }

            //添加帐号
            $addUserInfo = $TzUserModel->create([
//                'name'     => $par['name'], //用户名暂时不写入
                'email'    => $par['email'],  //邮箱
                'password' => Hash::make($par['password']),  //密码
                'status'   => 2,  //状态为已验证
                'pwd_ver'  => 1,
            ]);
            $this->bindSalesman($addUserInfo['id'], $par['salesman']); //绑定业务员
            Auth::loginUsingId($addUserInfo['id']);  //注册后自动登录
            /**
             * 将先注册的账户相关信息放入索引文件
             * @var XS
             */
            $xunsearch    = new XS('customer');
            $index        = $xunsearch->index;
            $doc['id']    = strtolower($addUserInfo['id']);
            $doc['email'] = strtolower($par['email']);
            $document     = new \XSDocument($doc);
            $index->update($document);
            $index->flushIndex();
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
        $token = mt_rand(1000, 9999);         //生成随机验证码
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
     *
     *[
     *  {
     *      "id": 业务员ID
     *      "username": 登录名
     *      "name": 显示名
     *  },
     * ]
     *
     */
    public function getAllSalesman()
    {
        $tzJobsModel     = new TzJobs();  //实例化  职位表
        $oaStaffModel    = new OaStaff(); // 实例化 员工表
        $adminUsersModel = new AdminUsers(); // 实例化 后台用户表

        $salemanJobId = $tzJobsModel->getAllSalesmanJobId();  //获取所有销售员职位ID
        $adminUserId  = $oaStaffModel->getAdminUserIdByJob($salemanJobId); //根据职位ID获取后台账户ID
        $salemanData  = $adminUsersModel->getAdminUserName($adminUserId);  //获取业务员数据

        /**
         * 去除重复
         */
        $salemanId = [];//去除用
        foreach ($salemanData as $v => $k) {

            //判断数组中是否已经存在
            if (in_array($k['id'], $salemanId)) {

                unset($salemanData[$v]);

            }
            $salemanId[] = $k['id'];
        }

        return tz_ajax_echo($salemanData, '业务员列表获取成功', 1);

    }


    /**
     * 注册中绑定业务员
     *
     * @param int $userId 用户ID
     * @param int $salesmanUserId 业务员后台用户ID
     * @return mixed   true:成功   false:失败
     */
    private function bindSalesman($userId, $salesmanUserId)
    {
        $TzUserModel       = new TzUser(); //实例化腾正用户模型
        $user              = $TzUserModel->find($userId);  //根据用户ID 获取用户数据
        $user->salesman_id = $salesmanUserId;    //修改用数据中的业务员ID
        $bool              = $user->save();           //保存
        return $bool;
    }

}
