<?php
/**
 *
 */

namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use App\Http\Models\DefenseIp\XADefenseDataModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class InfoController extends Controller
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
     * 获取高防IP地址 列表
     */
    public function showList()
    {
        $this->userId = Auth::id();  //获取用户ID
        $businessM    = new BusinessModel();  //实例化

        //根据用户ID获取本用户所有高防IP业务表
        $listData = $businessM
            ->where([
                'user_id' => $this->userId    //用户ID
            ])
            ->get()
            ->toArray();   //将对象转为数组

        //遍历添加查询IP资源数组
        foreach ($listData as $key => $value) {
            $listData[$key]['defense_ip'] = StoreModel::find($value['ip_id'])->toArray()['ip']; //列表数组中添加高防IP
            $listData[$key]['status_cn']  = $this->checkStatus($value['end_at']);  //追加业务状态
        }
        return tz_ajax_echo($listData, '获取高防IP列表成功', 1);
    }


    /**
     *  判断业务时间状态
     *
     * @param $endTime '业务到期时间'
     * @return string    '返回业务中文状态'
     */
    protected function checkStatus($endTime)
    {
//        $endTime  = ;   //获取业务过期时间
        $nowDate  = Carbon::now();  //获取现在时间
        $willDate = Carbon::now()->addDay(config('tz_time.deadline.long')); //获取将要过期的时间限期

        //判断是否过期
        if ($endTime > $nowDate) {
            //未过期
            //判断是否准备过期
            if ($endTime < $willDate) {
                return '即将到期';
            }
            return '未过期';
        } else {
            //已过期
            return '已过期';
        }
    }




    /**
     * 统计高防IP数据流量
     * 用于绘制流量图表
     * 参数:
     *    date:数据日期
     *
     */
    public function getStatistics(Request $request)
    {

        

    }


    /**
     * 测试模型关联
     */
    public function test()
    {


        $XADefenseDataModel = new XADefenseDataModel();

        dump($XADefenseDataModel->getByIp());


        die();
//        $busM = new BusinessModel();
////        $data = $busM->test()->get();
//        $data = $busM->find(20)->test();
//        dump($data);
        $nowTime = Carbon::now();  //获取当前时间

        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
        ->join('tz_defenseip_store', 'tz_defenseip_business.ip_id', '=', 'tz_defenseip_store.id')
            ->get()
            ->toArray();  //获取数据比并转换成数组形式

        dump($endData);

    }

}
