<?php

namespace App\Http\Controllers\TzAuth;

use App\Http\Requests\TzAuth\LoginByEmailRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController extends Controller
{

    /**
     * 通过邮箱重置密码
     *
     * 类型:POST
     * 参数:
     *      password: 修改后的密码
     *      xxxx  :邮箱验证码
     */
    public function resetPasswordByEmail(Request $request)
    {
        $res = $request->all(); //获取参数


    }


    /**
     * 发送邮箱验证码
     */
    public function sendEmailCode(Request $request)
    {



    }

}