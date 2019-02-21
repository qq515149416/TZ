<?php

namespace App\Admin\Controllers\Search;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Search\SearchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * 直接通过数据库的精确搜索
 *
 * Class DbSearchController
 * @package App\Admin\Controllers\Search
 */
class DbSearchController extends Controller
{


    /**
     * 数据库直接搜索数据库执行精确搜索
     * 搜索类型：0.预留   1.IP  2.机器编号
     *
     * 参数；
     *   keyword   搜索关键词
     *   typeId    搜索类型编号
     *
     */
    public function doSearch(Request $request)
    {
        dump($request->all());//打印测试

        $keyword = $request->all()['keyword'];

        //判断是否输入关键词
        if (empty($keyword)) {
            return tz_ajax_echo(null, '搜索关键词不能为空', 0);
        }


        //根据类型选择不同的搜索流程
        switch ($request->all()['typeId']) {
            case 0://预留
                break;

            case 1://通过IP搜索

                $resData['data'] = $this->searchIp($keyword);
                dump($resData);
                break;

            case 2://通过资源编号搜索
                $resData = $this->searchMachineNum($keyword);
                dump($resData);
                break;

            default://默认搜索类型
                break;
        }
        return tz_ajax_echo($resData['data'], $resData['msg'], $resData['code']);
    }


    /**
     * 通过主机编号查询数据
     *
     * 私有
     *
     */
    private function searchMachineNum($machineNum)
    {
        //机器编号作为条件查询
        $resData['data'] = DB::table('tz_business')
            ->where('machine_number', $machineNum)
            ->where('remove_status', '!=', 4)
            ->first();

        $resData['msg']  = '获取成功';
        $resData['code'] = 1;

        return $resData;

    }


    /**
     * 通过IP搜索数据
     *
     * 私有
     *
     */
    private function searchIp($IP)
    {
        //ip作为条件查询
        $resData['data'] = DB::table('idc_ips')
            ->where('ip', $IP)
            ->first();


        return $resData;

    }


    /**
     * 查询机柜编号
     * 根据机柜ID获取机柜编号
     */
    private function getBusinessId()
    {


    }


    /**
     * 根据用户ID 获取用户数据
     */
    private function getUserInfo($userId)
    {

        $userData = DB::table('tz_users')
            ->where('id', $userId)
            ->first()
            ->toArray();

        return $userData;
    }


}