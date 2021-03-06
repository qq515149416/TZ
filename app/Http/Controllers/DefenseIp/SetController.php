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
     * 用于设定高防IP的防护IP
     *
     * 接口:/home/defenseIp/setTarget
     * 接口类型:POST
     * 参数:
     *      business_id:高防IP业务ID
     *      target_ip :高防目标IP
     *
     * 返回参数:  ....
     * 状态码:   ....
     */
    public function setTarget(Request $request)
    {
        $this->userId = Auth::id();  //获取登录的用户ID
        $busId        = $request['business_id'];//获取参数,高防IP业务ID
        $targetIp     = trim($request['target_ip']);  //获取参数,去除左右两边空格

        $apiModel = new ApiController();//实例化
//        $businessData = BusinessModel::find($busId); //根据业务ID获取相关业务数据
        $businessData = BusinessModel::where('business_number', '=', $busId)->first(); //根据业务ID获取相关业务数据

        //判断有误相关的业务数据
        if (!$businessData) {
            return tz_ajax_echo([], '没有找到相关的业务', 0);
        }
        $businessData = $businessData->toArray();  //将业务数据转换成数组

        //判断业务是否为用户本人
        if (!($businessData['user_id'] == $this->userId)) {
            return tz_ajax_echo([], '非本人资源', 0); //非本人业务
        }

        $businessData['defense_ip'] = StoreModel::find($businessData['ip_id'])->toArray()['ip']; //根根据高防ID资源获取IP
        $apiData                    = json_decode($apiModel->createTarget($businessData['defense_ip'], $targetIp), true); //使用api接口更新目标IP地址
        $apiData2                   = json_decode($apiModel->updateTarget($businessData['defense_ip'], $targetIp), true); //使用api接口更新目标IP地址

        //判断是否更新成功
        if (($apiData['code'] == 0) || ($apiData2['code'] == 0)) {
            //成功
            $businessData            = BusinessModel::where('business_number', '=', $busId)->first();
            $businessData->target_ip = $targetIp;  //更新高防IP业务目标IP
            $businessData->save();
            return tz_ajax_echo($apiData, '成功', 1);
        } else {
            //失败
            return tz_ajax_echo([], '失败', 0);
        }
    }


    public function test()
    {
//        $businessData = BusinessModel::find(33);
//     $businessData = BusinessModel::where('business_number', '=','G_1542937532')->first(); //根据业务ID获取相关业务数据
//        $businessData= $businessData->toArray();
//        dump($businessData);
    }

}