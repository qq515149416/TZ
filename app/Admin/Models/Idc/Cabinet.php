<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cabinet extends Model
{
    //引入软删除
    use SoftDeletes;

    //表名
    protected $table = 'idc_cabinet';

    //设置主键
    public $primaryKey = 'id';

    //设置软删除字段
    protected $dates = ['delete_at'];


    /**
     * 测试方法
     */
    public function test()
    {
//        $res =
        return '测试方法';
    }

}