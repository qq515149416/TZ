<?php

namespace App\Admin\Controllers\Defenseip;

use App\Http\Controllers\Controller;
use App\Http\Models\DefenseIp\BusinessModel;
use Illuminate\Http\Request;

class RemoveController extends Controller
{

    /**
     * 查询过期业务
     */
    public function selectExpireList()
    {

        $nowTime = Carbon::now();  //获取当前时间
        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
        ->join('tz_defenseip_store', 'tz_defenseip_business.ip_id', '=', 'tz_defenseip_store.id')//关联数组
        ->get()->toArray();  //获取数据比并转换成数组形式
        return $endData;

    }

}