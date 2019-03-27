<?php

namespace App\Http\Controllers\DefenseIp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{


    protected $username;  //用户名
    protected $password; //密码
    protected $host; //host

    /**
     * 加载配置文件中 帐号密码
     */
    public function __construct()
    {
        $this->username = config('tz_defense_ip.username');  //加载配置文件中的API用户名
        $this->password = config('tz_defense_ip.password');  //加载配置文件中的API密码
        $this->host     = config('tz_defense_ip.host');  //加载配置文件中的API地址

//        $this->username = 'tzapi';  //加载配置文件中的API用户名
//        $this->password = 'fh28s9dJncDwF72G';  //加载配置文件中的API密码
//        $this->host     = '1.81.5.85:9666';  //加载配置文件中的API地址
    }


    /**
     * 执行CURL
     */
    protected function executeCurl($url,$data=null,$questType)
    {


        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $questType);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        curl_close($ch);//关闭curl
        return $result;

    }



    /**
     *  添加目标地址
     */
    public function createTarget($host, $target)
    {

        $data=array("ip" => $host, "vip" => $target);
        $url='http://'.$this->host.'/openapi/host?user='. $this->username.'&password='.$this->password;
        $res = $this->executeCurl($url,$data,'POST');
        return $res;

    }


    /**
     * 删除目标地址
     */
    public function deleteTarget($host)
    {


        $url='http://'.$this->host.'/openapi/host?ip='.$host.'&user='. $this->username.'&password='.$this->password;
        $res = $this->executeCurl($url,null,'DELETE');
        return $res;

    }


    /**
     * 修改目标地址
     */
    public function updateTarget($host, $target)
    {

        $data=array("ip" => $host, "vip" => $target);
        $url='http://'.$this->host.'/openapi/host?user='. $this->username.'&password='.$this->password;
        $res = $this->executeCurl($url,$data,'PUT');
        return $res;


    }


    /**
     * 获取图表数据
     *
     * @param $host
     * @param $date
     * @return mixed
     */
    public function getState($host, $date)
    {
        $url = $this->host . '/openapi/giphoststate?host=' . $host . '&user=' . $this->username . '&password=' . $this->password . '&date=' . $date;
        $res = $this->executeCurl($url);
        return $res;
    }





    /**
     * 对状态进行判断     TODO  状态判断
     */
    protected function state()
    {

    }


    /**
     * 添加 http://host:port/openapi/giphost?type=create&host=1.1.1.1&target=2.2.2.2&user=admin&password=123456
     * 删除 http://host:port/openapi/giphost?type=delete&host=1.1.1.1&user=admin&password=123456
     * 图表 http://host:port/openapi/giphoststate?host=1.1.1.1&user=admin&password=admin&date=2018-08-04
     */


    /**
     * API 返回状态码
     * 添加
     *   0 :  添加成功
     *   1 : 主机已存在
     *
     * 删除 :
     *    0:删除成功
     *    1:删除失败
     *
     *
     * 图表:
     *    0: 获取成功
     *    1: 获取失败  (多数为日期错误)
     */





    //    /**
//     * 执行CURL
//     */
//    protected function executeCurl($url)
//    {
//        $ch = curl_init();//初始化curl
//        curl_setopt($ch, CURLOPT_URL, $url);//设置url属性
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //内容作为变量储存
//        curl_setopt($ch, CURLOPT_HEADER, 0);  //关闭获取头部信息
//        $output = curl_exec($ch);//获取数据
//        curl_close($ch);//关闭curl
//        return $output;
//    }


//    public function addTest()
//    {
//        $this->deleteTarget('1.2.3.4');
//    }


}
