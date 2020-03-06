<?php

namespace App\Http\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OaStaff extends Model
{
    use SoftDeletes;

    protected $table = 'oa_staff'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间

    /**
     * 根据 职位ID获取 后台用户ID
     */
    public function getAdminUserIdByJob($jobId)
    {
        $list=[];   //定义空数组
        foreach ($jobId as $key => $value) {
            $list =  array_merge($list,$this->where(['job' => $value,'dimission'=>0])->get()->toArray());  //拼装数组
        }
        return $list;
    }

}
