<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TzUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'tz_users'; //表

    protected $primaryKey = 'id'; //主键

    public $timestamps = false;    //关闭自动写入时间戳

    /**
     * The attributes that are mass assignable.
     * 添加可模型可操作字段
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
