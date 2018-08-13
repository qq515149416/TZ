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

    //设置填充字段
    protected $fillable = ['machineroom_id','cabinet_id','use_type','note'];

    /**
     * 测试方法
     */
    public function test()
    {

        $data = $this->all();

        return $data;

    }


    /**
     * 存储数据
     */



}