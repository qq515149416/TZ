<?php
/*
 * @Author: your name
 * @Date: 2020-01-07 11:15:21
 * @LastEditTime : 2020-01-19 15:11:55
 * @LastEditors  : Please set LastEditors
 * @Description: In User Settings Edit      
 * @FilePath: \BJf:\OA\app\Http\Controllers\User\Show\DetailController.php
 */

namespace App\Http\Controllers\User\Show;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer\Business;
use App\Http\Models\DefenseIp\BusinessModel;
use Illuminate\Support\Facades\DB;


class DetailController extends Controller
{
    public function index($id)
    {
        return view("user_admin/detail",[
            "page" => "server_detail",
            "data" => $this->detail($id)
        ]);
    }

    public function gaofang($id) 
    {
        return view("user_admin/gaofang_detail",[
            "page" => "gaofang_detail",
            "data" => $this->gaofangDetail($id)
        ]);
    }

    /**
     * 高防IP业务详情页获取数据:
     * @param int 业务id
     * @return:
     * */ 
    public function gaofangDetail($id) 
    {
        if(!$id){
            return '无法获取对应信息';
        }
        $business = BusinessModel::where(['id'=>$id])->first();
        if(!$business){
            return '暂无对应数据';
        }
        $business->ip = DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip');
        $status = ['预留状态','正在使用','申请下架','已下架','试用','待审核'];
        $business->status = $status[$business->status];
        return $business;
    }

    /**
     * IDC业务详情页获取数据: 
     * @param int 业务id 
     * @return: 
     */
    public function detail($id)
    {
        if(!$id){
            return '无法获取对应信息';
        }
        $business = Business::where(['id'=>$id])->select('id','business_number','business_type','machine_number','resource_detail','money','length','endding_time','business_status')->first();
        if(!$business){
            return '暂无对应数据';
        }
        $detail = json_decode($business->resource_detail);
        $business->machineroom = $detail->machineroom_name;
        if($business->business_type < 3){
            $business->cpu = $detail->cpu;
            $business->harddisk = $detail->harddisk;
            $business->memory = $detail->memory;
            $business->protected = $detail->protect;
            $business->bandwidth = $detail->bandwidth;
            $business->ip = $detail->ip;
            $business->cabinets = $detail->cabinets;
            $business->loginname = $detail->loginname;
            $business->loginpass = $detail->loginpass;
        }
        $business->resource_type = resource_type($business->business_type);
        $business->status = business_status($business->business_status);
        return $business;

    }
    
}
