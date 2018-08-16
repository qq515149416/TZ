<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
	 // `cabinet_id` int(10) unsigned NOT NULL COMMENT '机器所在机柜，跟机柜的id关联',
  // `ip_id` int(10) unsigned NOT NULL COMMENT 'IP地址，跟IP表的id关联',
  // `machineroom_id` int(10) unsigned NOT NULL COMMENT '机器所属机房，跟机房表的id关联',
class MachineModel extends Model
{
    use SoftDeletes;
    protected $table = 'idc_machine';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * 查找属于租用的所有服务器
     * @return [type] [description]
     */
    public function showRentMachine(){
    	// 进行条件查询业务类型为1的即租用的所有机器信息
    	$result = $this->where('business_type','=',1)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];
    		$machine_status = [0=>'上架',1=>'下架',2=>'备用'];
    		$business_type = [1=>'租用',2=>'托管'];
    		foreach($result as $key=>$value){
    			$result[$key]['used'] = $used_status[$value['used_status']];
    			$result[$key]['status'] = $machine_status[$value['machine_status']];
    			$result[$key]['business'] = $business_type[$value['business_type']];
    			$cbinet = (array)$this->cbinet($value['cabinet']);
    			$ip = (array)$this->ips($value['ip_id']);
    			$machineroom = (array)$this->machineroom($value['machineroom']);
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $cabinet['cabinet_id'];
    				$result[$key]['ip'] = $ip['ip'];
    				$result[$key]['ip_company'] = $ip['ip_company'];
    				$result[$key]['machineroom_name'] = $machineroom['machine_room_name'];
    			}

    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取信息成功！！';
    	} else {
    		$return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '暂无数据';
    	}

    	return $return;
    }
}
