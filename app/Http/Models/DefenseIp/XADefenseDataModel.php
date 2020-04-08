<?php

namespace App\Http\Models\DefenseIp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

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
        $dbRedis = Redis::connection('FW_XA');
        $startDate=$startDate - $startDate % 300 ;
        $redisRes = $dbRedis->hgetall('FW-' . $ip . '-' . $startDate);
        if ($redisRes) {
            $fTime = $endDate - $endDate % 300 + 300;
            $dbRedis = Redis::connection('FW_XA');

            for ($x = 0; $x <= 288; $x++) {
                if ($fData = $dbRedis->hgetall('FW-' . $ip . '-' . $fTime)) {
                    $data[] = array(
                        'time' => $fTime,
                        'bandwidth_down' => (float)$fData['MAX(fyip.bandwidth_down)'],
                        'upstream_bandwidth_up' => (float)$fData['MAX(fyip.upstream_bandwidth_up)'],
                        'bandwidth_up'=>(float)$fData['MAX(fyip.bandwidth_up)']
                    );
//                    $data[]['time']=$fTime;
//                    $data[]['bandwidth_down']=(float)$fData['MAX(fyip.bandwidth_down)'];
//                    $data[]['upstream_bandwidth_up']=(float)$fData['MAX(fyip.upstream_bandwidth_up)'];
//                    $data[]['id']=$x;
                }


                $fTime = $fTime - 300;
            }
        } else {
            $data = DB::connection('mysql_xagf')
                ->table("fyip_5max")
                ->select('id', 'time', 'bandwidth_down', 'upstream_bandwidth_up','bandwidth_up')
                ->where('ipaddress', '=', $ip)
                ->whereBetween('time', [$startDate, $endDate])
                ->orderBy('time', 'desc')
                ->get(['time', 'bandwidth_down', 'upstream_bandwidth_up','bandwidth_up'])
                ->toArray();
        }

        return $data;
    }

    public function getByIp5MinByRedis($ip, $startDate, $endDate)
    {


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
