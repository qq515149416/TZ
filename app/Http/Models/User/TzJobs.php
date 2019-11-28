<?php

namespace App\Http\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TzJobs extends Model
{
    use SoftDeletes;

    protected $table = 'tz_jobs'; //表
    protected $primaryKey = 'id'; //主键
    protected $dates = ['deleted_at']; //删除时间

    /**
     * 查询业务员职位ID
     */
    public function getAllSalesmanJobId()
    {
        $list = $this->where(['slug' => 3])->get()->toArray(); //获取数据

        //拼装成新数组
        foreach ($list as $k => $v) {
            $allSalesmanId[] = $v['id'];
        }

        return $allSalesmanId;
    }



}
