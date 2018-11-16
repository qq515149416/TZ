<?php

namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessModel extends Model
{
    use SoftDeletes;

    protected $table = 'tz_defenseip_business'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间

//    /**
//     *
//     */
//    public function test()
//    {
//       return $this->hasOne('App\Http\Models\DefenseIp\StoreModel','id','ip_id');
//    }




}
