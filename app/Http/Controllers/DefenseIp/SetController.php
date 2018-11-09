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


        $busId = 1 ;//高防IP业务ID

        $targetIp= trim('192.168.1.1');  //去除左右两边空格
        //-------------------------------------------

        $testMode = new BusinessModel();

//        $businessData=BusinessModel::find(2)->get()->toArray();
        $businessData=$testMode->test();

//        dump($testMode->find(1)->get());


        dump($businessData);

//        $apiModel = new ApiController();


    }


}