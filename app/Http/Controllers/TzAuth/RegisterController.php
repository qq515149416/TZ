<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Models\TzUser;
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
//        dump(Hash::make('zhangjun'));
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
     * 发送邮箱验证码
     */
    public function sendCodeToEmail()
    {
        //生成随机验证码
        $code = mt_rand(0, 99999);

        dump($code);

        $ma='568171152@qq.com';

        Mail::send('emails.code', ['code' => $code], function ($message) use ($ma) {
            $to = $ma;
            $message->to($to)->subject('邮箱验证');
        });

        // 返回的一个错误数组，利用此可以判断是否发送成功
        if(count(Mail::failures()) < 1){
            return tz_ajax_echo([],'验证码发送成功',1);
        }else{
            return tz_ajax_echo([],'验证码发送失败',0);
        }

    }

//return User::create([
//'name' => $data['name'],
//'email' => $data['email'],
//'password' => Hash::make($data['password']),
//]);


}
