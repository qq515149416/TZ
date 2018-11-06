<?php

namespace App\Http\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUsers extends Model
{
    use SoftDeletes;

    protected $table = 'admin_users'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间
    protected $hidden = ['password', 'remember_token',]; //设置隐藏字段

    /**
     * 根据后台用户ID获取用户显示名
     */
    public function getAdminUserName()
    {
        //


    }


}
