<?php

namespace App\Http\Controllers\DefenseIp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    /**
     * 测试方法
     */
    public function test()
    {
        dump('123');
        dump(config('tz_defense_ip.username'));
        die();

        $host   = '5.5.5.12';
        $target = '6.6.6.6';
//        $data   = json_decode($this->createTarget($host, $target), true);  //添加主机地址
//        $data   = json_decode($this->getState($host, '2018-12-08'), true);  //删除主机地址
//        $data   = json_decode($this->deleteTarget($host), true);  //获取图表

        $tModel= new ApiController();

        dump($tModel->createTarget($host,$target));
    }




}
