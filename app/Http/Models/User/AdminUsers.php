<?php

namespace App\Http\Models\User;

use Illuminate\Database\Eloquent\Model;


class AdminUsers extends Model
{
  

    protected $table = 'admin_users'; //表
    protected $primaryKey = 'id'; //主键
    protected $hidden = ['password', 'remember_token',]; //设置隐藏字段

    /**
     * 根据后台用户ID获取用户显示名
     */
    public function getAdminUserName($userId)
    {
        $list = []; //定义空数组
        foreach ($userId as $key =>$value) {
            $list = array_merge($list,$this->where(['id' => $value['admin_users_id']])->get()->toArray());
        }
        return $list;
    }


}
