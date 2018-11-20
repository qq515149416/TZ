<?php

namespace App\Http\Models\DefenseIp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class XADefenseDataModel extends Model
{

    protected $table = 'fyip'; //表
    protected $primaryKey = 'id'; //主键
    public $timestamps = false;     //取消时间戳
    protected $connection = 'mysql_xagf';//链接外部数据库


    public function test()
    {


    }


    /**
     * 根据IP查询相关数据
     *
     */
    public function getByIp($ip=0,$startDate,$endDate)
    {

        //============测试数据=================
        $ip = '113.141.160.136';

        //==============END===============

        $data=$this
//            ->whereBetween('time',[$startDate,$endDate ])
            ->where('ipaddress','=',$ip)
            ->whereBetween('time',[$startDate,$endDate ])
            ->get()
//            ->toArray();
            ->toJson();


        return $data;

    }

}
