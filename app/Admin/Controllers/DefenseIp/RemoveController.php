<?php

namespace App\Admin\Controllers\DefenseIp;

use App\Http\Controllers\Controller;
use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Admin\Requests\DefenseIp\BusinessRequest;
use Encore\Admin\Facades\Admin;

class RemoveController extends Controller
{

    /**
     * 查询过期业务
     */
    public function selectExpireList()
    {
//---------------------业务表与资源表联查-----------------------------
//        $nowTime = Carbon::now();  //获取当前时间
//        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
//        ->join('tz_defenseip_store', 'tz_defenseip_business.ip_id', '=', 'tz_defenseip_store.id')//关联数组
//        ->select('tz_defenseip_business.id', 'tz_defenseip_business.id')
//            ->get(); //获取数据比并转换成数组形式
//----------------------END----------------------------------------------

        $nowTime = Carbon::now();  //获取当前时间
        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
        ->get()
            ->toArray(); //获取数据比并转换成数组形式

        //遍历过期列表数组
        foreach ($endData as $key => $value) {
            $storeData           = StoreModel::find($value['ip_id'])->toArray();//获取资源数据
            $endData[$key]['ip'] = $storeData['ip'];  //过期列表添加IP键值
        }

//        dump($endData);
        return $endData;
    }


    /**
     * 修改业务状态 用户
     */
    public function updataStatus()
    {

        
    }

    /**
     * 高防IP资源表 获取资源内容
     */
    protected function getStoreIP($storeId)
    {
        $storeData = StoreModel::find($storeId); //获取资源数据
        return $storeData;
    }

     /**
     * 高防IP业务员提交下架审核
     */
    public function subExamine(BusinessRequest $request)
    {
        $par = $request->only(['business_id']);
        $business_id = $par['business_id'];
        $admin_user_id = Admin::user()->id;

        $model = new BusinessModel();
        $tijiao = $model->subExamine($business_id,$admin_user_id);
        
        return tz_ajax_echo($tijiao['data'],$tijiao['msg'],$tijiao['code']);
    }



    public function goExamine(BusinessRequest $request)
    {
        $par = $request->only(['business_id','status']);
        $business_id = $par['business_id'];
        $admin_user_id = Admin::user()->id;
        $status = $par['status'];

        $model = new BusinessModel();
        $examineRes = $model->$examine($business_id,$status,$admin_user_id);
        dd($examineRes);
    }
}