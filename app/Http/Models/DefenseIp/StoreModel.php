<?php

namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreModel extends Model
{
    use SoftDeletes;

    protected $table = 'tz_defenseip_store'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间
//    protected $fillable = ['id', 'ip'];


    /**
     *
     */
    public function test()
    {

    }

}
