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
     * 查找属于租用业务的机器
     * @return [type] [description]
     */
    public function showRentMachine(){
    	// 进行条件查询业务类型为1的即租用的所有机器信息
    	$result = $this->where('business_type','=',1)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		// 查询到数据进行某些字段的数据转换
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
    		$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
    		$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
    		// 遍历查询到的数据并进行相应的转换
    		foreach($result as $key=>$value){
    			// 状态等的转换
    			$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
    			$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
    			$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
    			// 机柜等的对应查询
    			$cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			$ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $cabinet['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $ip['ip'];
    				$result[$key]['ip_company'] = $ip['ip_company'];
    				//机房的信息返回
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

    /**
     * 查找属于托管业务的机器
     * @return [type] [description]
     */
    public function showDepositMachine(){
    	// 进行条件查询业务类型为2的即托管的所有机器信息
    	$result = $this->where('business_type','=',1)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		// 查询到数据进行某些字段的数据转换
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
    		$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
    		$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
    		// 遍历查询到的数据并进行相应的转换
    		foreach($result as $key=>$value){
    			// 状态等的转换
    			$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
    			$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
    			$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
    			// 机柜等的对应查询
    			$cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			$ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $cabinet['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $ip['ip'];
    				$result[$key]['ip_company'] = $ip['ip_company'];
    				//机房的信息返回
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

    /**
     * 查找属于备用的机器
     * @return [type] [description]
     */
    public function showReserveMachine(){
    	// 进行条件查询机器状态为3的即备用的所有机器信息
    	$result = $this->where('business_type','=',3)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		// 查询到数据进行某些字段的数据转换
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
    		$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
    		$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
    		// 遍历查询到的数据并进行相应的转换
    		foreach($result as $key=>$value){
    			// 状态等的转换
    			$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
    			$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
    			$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
    			// 机柜等的对应查询
    			$cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			$ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $cabinet['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $ip['ip'];
    				$result[$key]['ip_company'] = $ip['ip_company'];
    				//机房的信息返回
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




    /**
     * 查找属于对应条件的机器
     * @return [type] [description]
     */
    public function showMachine($where){
    	// 进行条件查询业务类型为1的即租用的所有机器信息
    	$result = $this->where($where)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		// 查询到数据进行某些字段的数据转换
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
    		$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
    		$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
    		// 遍历查询到的数据并进行相应的转换
    		foreach($result as $key=>$value){
    			// 状态等的转换
    			$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
    			$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
    			$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
    			// 机柜等的对应查询
    			$cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			$ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $cabinet['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $ip['ip'];
    				$result[$key]['ip_company'] = $ip['ip_company'];
    				//机房的信息返回
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
