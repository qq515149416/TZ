<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InfoController extends Controller
{
    /**
     * 获取帐号信息
     *
     * 接口: /home/user/getInfo
     * 类型: GET
     * 返回参数 :
     *     ID: 用户主键ID
     *     status: 用户帐号状态
     *      name  : 用户名   (暂用不上 后做决定)
     *      email  : 用户邮箱
     *      money : 用户余额
     *      salesman_id: 所属业务员ID
     *
     *
     * @return mixed
     */
    public function getInfo()
    {
        $info = Auth::user();
        return tz_ajax_echo($info,'获取成功',1);
    }
}
