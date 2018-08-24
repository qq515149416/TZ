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

    protected $fillable = ['type', 'accounts', 'token']; //设置可填充属性

    /**
     * 添加邮箱验证码
     *
     */
    public function addMailToken($accounts,$token)
    {

        //测试参数
        $accounts = '568171152@qq.com';

        //根据条件更新
        $res = $this->updateOrCreate([
            'accounts' => $accounts
        ], [
            'token' => $token
        ]);

        return $res;

        //数据库添加邮箱验证token
//        $res = $this->create([
//            'type'     => 1,
//            'accounts' => $accounts,
//            'token'    => $token,
//        ]);

    }


}