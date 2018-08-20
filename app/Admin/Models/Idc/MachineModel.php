<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
	 // `cabinet` int(10) unsigned NOT NULL COMMENT '机器所在机柜，跟机柜的id关联',
  // `ip_id` int(10) unsigned NOT NULL COMMENT 'IP地址，跟IP表的id关联',
  // `machineroom` int(10) unsigned NOT NULL COMMENT '机器所属机房，跟机房表的id关联',
class MachineModel extends Model
{
    use SoftDeletes;
    protected $table = 'idc_machine';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    // 将DB查询的数据转换为数组
    protected $fetchMode = PDO::FETCH_ASSOC;
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
    			// // 机柜等的对应查询
    			// $cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			// $ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $machineroom['ip'];
    				$result[$key]['ip_company'] = $machineroom['ip_company'];
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
    			// // 机柜等的对应查询
    			// $cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			// $ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $machineroom['ip'];
    				$result[$key]['ip_company'] = $machineroom['ip_company'];
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
    			// // 机柜等的对应查询
    			// $cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			// $ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $machineroom['ip'];
    				$result[$key]['ip_company'] = $machineroom['ip_company'];
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
    			// // 机柜等的对应查询
    			// $cbinet = (array)$this->cbinet($value['cabinet']);//机柜信息的查询
    			// $ip = (array)$this->ips($value['ip_id']);//IP信息的查询
    			$machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
    				$result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $machineroom['ip'];
    				$result[$key]['ip_company'] = $machineroom['ip_company'];
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
     * 对机器信息进行添加处理
     * @param  array $data 要新增的机器信息
     * @return 返回新增的状态和提示信息
     */
    public function insertMachine($data){
    	if($data){
    		$row = $this->create($data);
    		if($row != false){
    			$return['data'] = $row->id;
    			$return['code'] = 1;
    			$return['msg'] = '新增机器信息成功！！';
    		} else {
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '新增机器信息失败！！';
    		}
    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '新增机器信息失败！';
    	}
    	return $return;
    }


    /**
     * 对机器信息进行修改
     * @param  array $editdata 要修改的数据
     * @return array           返回提示信息和状态
     */
    public function editMachine($editdata){
    	if($editdata){
    		$row = $this->where('id',$editdata['id'])->update($editdata);
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '修改信息成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '修改信息失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '请确保要修改的信息正确！！';
    	}
    }

    /**
     * 删除机器信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteMachine($id){
    	if($id){
    		$row = $this->where('id',$id)->delete();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '删除机器信息成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '删除机器信息失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法删除机器信息！！';
    	}
    }


    /**
     * 机房信息的获取，当是展示机器的时候IP，机柜，机房等信息转换的时候需要传入对应的参数进行查询，如果只是简单获取机房数据（添加，修改时）无须传参，
     * @param  integer $roomid  机房的id
     * @param  integer $cabinet 机柜的id
     * @param  integer $ip      IP表的id
     * @return [type]           [description]
     */
    public function machineroom($roomid = 0,$cabinet = 0,$ip = 0){
    	if($roomid != 0 && $cabinet != 0 && $ip != 0){
    		// 当是IP，机柜，机房等信息转换时对应参数都传入
    		$related = DB::table('idc_machineroom')//机房表
    					->join('idc_cabinet','idc_machineroom.id','=','idc_cabinet.machineroom_id')//关联查询机柜表
    					->join('idc_ips','idc_machineroom.id','=','idc_ips.ip_comproom')//关联查询IP表
    					->where('idc_machineroom.id',$roomid)//机房表的条件
    					->where('idc_cabinet.id',$cabinet)//机柜表的条件
    					->where('idc_ips.id',$ip)//IP的条件
    					->select('idc_machineroom.machine_room_name','idc_cabinet.cabinet_id','idc_ips.ip','idc_ips.ip_company')//所需获得的字段
    					->first();
    		return $related;//返回数据
    	} else {
    		// 当未传入参数时代表简单的查询机房数据
    		$result = DB::table('idc_machineroom')->whereNull('deleted_at')->select('id as roomid','machine_room_id','machine_room_name')->get();
	    	if($result) {
	    		$return['data'] = $result;
	    		$return['code'] = 1;
	    		$return['msg'] = '机房信息获取成功!!';
	    	} else {
	    		$return['data'] = '';
	    		$return['code'] = 0;
	    		$return['msg'] = '机房信息获取失败!!';
	    	}

	    	return $return;
    	}
    }

    /**
     * 对应机房的机柜信息的获取
     * @param   $roomid 机柜的机房字段machineroom_id
     * @return array         返回相关的数据和状态提示信息
     */
    public function cabinets($roomid){
   		if($roomid){
   			$cabinets = DB::table('idc_cabinet')
   							->where('machineroom_id',$roomid)
   							->whereNull('deleted_at')
   							->select('id as cabinetid','cabinet_id')
   							->get();
   			if($cabinets){
   				$return['data'] = $cabinets;
   				$return['code'] = 1;
   				$return['msg'] = '机柜信息获取成功';
   			} else {
   				$return['data'] = '';
   				$return['code'] = 0;
   				$return['msg'] = '机柜信息获取失败';
   			}
   		} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '机柜信息无法获取';
   		}
   		return $return;
    }

    /**
     * 对应机房的IP信息获取
     * @param  array $data 机房id对应ip_comproom字段，所属运营商对应ip_company字段
     * @return array       返回相关的数据和提示信息及状态
     */
    public function ips($data){
    	if($data){
    		$roomid = $data['roomid'];
    		$company = $data['ip_company'];
    		$ips = DB::table('idc_ips')
    				->where('ip_comproom',$roomid)
    				->where('ip_company',$company)
    				->whereNull('deleted_at')
    				->select('id as ipid','ip')
   					->get();
   			if($cabinets){
   				$return['data'] = $ips;
   				$return['code'] = 1;
   				$return['msg'] = 'IP信息获取成功';
   			} else {
   				$return['data'] = '';
   				$return['code'] = 0;
   				$return['msg'] = 'IP信息获取失败';
   			}
    	} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = 'IP信息无法获取';
   		}
   		return $return;
    }

}
