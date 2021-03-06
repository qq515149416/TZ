<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

        'tz_admin/rules',


        //此处用于排除CSRF  用户开发测试
        'tz_admin/jun/*',
        'tz_admin/machine_room/*',
        'tz_admin/cabinet/*',
        'tz_admin/test/*',
        'test/*',
        'auth/*',

        'home/recharge/payRechargeNotify',  //用于支付宝 回调
        'home/customer/aliNotify',                  //用于支付宝 回调
        'home/recharge/wechatNotify',           //用于微信 回调

        'tz_admin/message/*',   //TODO  记得删除
        'home/defenseIp/*',     //TODO   记得删除
        'tz_admin/users/*',    //后台用户管理   //TODO   记得删除

        /* ---  以下为供客户调用的渠道购买api --- */
        'api/ver1/*',   //渠道购买api版本1
        /* ---  以上为供客户调用的渠道购买api --- */
    ];
}
