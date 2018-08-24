<?php

/**
 * 用户帐号验证
 *
 * 用于验证手机或者邮箱是否为本人
 */
namespace App\Http\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class  TzUsersVerification extends Model
{

    protected $table = 'tz_users_verification'; //表

    protected $primaryKey = 'id'; //主键


    /**
     * 添加邮箱验证码
     *
     */
    public function addMailToken()
    {

        return 'su';

    }


}