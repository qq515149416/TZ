<?php

namespace App\Http\Models\DefenseIp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function getByIp($ip, $startDate, $endDate)
    {
        //============测试数据=================
//        $ip = '113.141.160.136';

        //==============END===============
        $today0 = strtotime(date("Y-m-d", time()));
        if ($endDate < $today0) {
            $data = DB::connection('mysql_xagf')
                ->table("fyip_5max")
                ->select('id', 'time', 'bandwidth_down', 'upstream_bandwidth_up')
                ->where('ipaddress', '=', $ip)
                ->whereBetween('time', [$startDate, $endDate])
                ->orderBy('time', 'desc')
                ->get(['time', 'bandwidth_down', 'upstream_bandwidth_up'])
                ->toArray();
        } else {
            $data = $this
                ->select('id', 'time', 'bandwidth_down', 'upstream_bandwidth_up')
                ->where('ipaddress', '=', $ip)
                ->whereBetween('time', [$startDate, $endDate])
                ->orderBy('time', 'desc')
                ->get(['time', 'bandwidth_down', 'upstream_bandwidth_up'])
                ->toArray();
        }

//        $data = DB::connection('mysql_xagf')
//            ->table("fyip_5max")
//            ->select('id', 'time', 'bandwidth_down', 'upstream_bandwidth_up')
//            ->where('ipaddress', '=', $ip)
//            ->whereBetween('time', [$startDate, $endDate])
//            ->get(['time', 'bandwidth_down', 'upstream_bandwidth_up'])
//            ->toArray();
//
//        if (!$data) {
//            $data = $this
//                ->select('id', 'time', 'bandwidth_down', 'upstream_bandwidth_up')
//                ->where('ipaddress', '=', $ip)
//                ->whereBetween('time', [$startDate, $endDate])
//                ->orderBy('time', 'desc')
//                ->get(['time', 'bandwidth_down', 'upstream_bandwidth_up'])
//                ->toArray();
//        }


        return $data;
    }

    public function getByIp5Min($ip, $startDate, $endDate)
    {

//        dump($data);
//        return $data;
//            $data2=DB::commit()
    }

}

//log-bin=/home/mysql-bin
//server-id=1
//innodb_flush_log_at_trx_commit=1
//sync_binlog=1
//binlog-do-db=test

//stop slave;
//change master to
//master_user='repl_user',master_password='123456',master_host='192.168.153.128',master_port=3306,master_log_file='mysql-bin.000007',master_log_pos=154;
