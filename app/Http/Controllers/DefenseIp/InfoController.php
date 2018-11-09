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
        $businessM = new BusinessModel();  //实例化

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
        }
        return tz_ajax_echo($listData, '获取高防IP列表成功', 1);
    }


    /**
     * 统计高防IP  TODO 为未完成
     */
    public function statistics()
    {



//        $businessList = BusinessModel::where('user_id', '=', $this->userId)->get()->toArray();  //获取业务数据
//
//        //遍历统计
//        foreach ($businessList as $key => $value) {
//            dump($value['end_at']);
//        }
//

    }

}
