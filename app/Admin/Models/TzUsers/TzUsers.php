<?php

namespace App\Admin\Models\TzUsers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TzUsers extends Model
{
    protected $table = 'tz_users';


    /**
     * 获取用户信息
     *
     * @return mixed
     */
    public function getUser()
    {


        $userId = 2203; //测试用户的ID

        //根据用户ID获取相关信息
        $userInfo = $this
            ->where('id', $userId)
            ->select('id', 'msg_phone', 'msg_qq', 'remarks', 'email', 'name', 'money')
            ->get();

        return $userInfo;

    }


    /**
     * 更新用户信息
     *
     * 需要先判断用户是否存在
     *
     */
    public function updateUserInfo()
    {
        $userId = 2203;//用于测试的用户ID


    }

}