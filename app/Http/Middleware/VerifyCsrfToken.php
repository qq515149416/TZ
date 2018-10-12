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
        'test/*',
        'auth/*',

        'home/recharge/payRechargeNotify',//用于支付宝 回调

        'tz_admin/message/*',   //TODO  记得删除

    ];
}
