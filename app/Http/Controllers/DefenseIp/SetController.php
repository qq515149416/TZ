<?php
/**
 *
 */

namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SetController extends Controller
{

    protected $userId; //用户ID

    /**
     * 自动加载
     */
    public function __construct()
    {
        $this->userId = Auth::id();  //获取登录的用户ID
    }


    /**
     * 设定目标IP
     */
    public function setTarget()
    {
        //=============测试模拟数据=============================


        $busId = 1;//高防IP业务ID

        $targetIp = trim('192.168.1.1');  //去除左右两边空格
        //-------------------------------------------

        $businessData               = BusinessModel::find($busId);


        $apiModel                   = new ApiController();//实例化
        $businessData               = BusinessModel::find($busId)->toArray();  //根据业务ID 获取业务数据
        $businessData['defense_ip'] = StoreModel::find($businessData['ip_id'])->toArray()['ip']; //根根据高防ID资源获取IP
        $apiData                    = json_decode($apiModel->updateTarget($businessData['defense_ip'], $targetIp), true); //使用api接口更新目标IP地址

        //判断是否更新成功
        if ($apiData['code'] == 0) {
            //成功
            dump('api录入成功');
            


        } else {
            //失败
            dump('api录入失败');


        }

//        dump(StoreModel::find(1));
        dump($apiData);
        dump($businessData);


    }


}