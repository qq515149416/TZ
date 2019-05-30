<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Schema;

class MachineModel extends Model
{
	use SoftDeletes;
	protected $table = 'idc_machine';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['machine_num', 'cpu','harddisk','cabinet','memory','ip_id','machineroom','protect','bandwidth','loginname','loginpass','machine_type','used_status','machine_status','business_type','created_at','updated_at','deleted_at'];

	/**
	 * 查找属于对应条件的机器
	 * @return [type] [description]
	 */
	public function showMachine($where){
		// 进行条件查询业务类型为1的即租用的所有机器信息
		$result = $this->where($where)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);

		//分页取数据
		// $result  = $this->paginate(15);

		// 判断是否查询到数据
		if(!$result->isEmpty()){
			// 查询到数据进行某些字段的数据转换
			$used_status = [0=>'未使用',1=>'业务锁定',2=>'使用中',3=>'锁定使用',4=>'迁移'];//使用状态的转换数据
			$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
			$business_type = [1=>'租用',2=>'托管',3=>'预备机器',4=>'托管预备机器'];//业务类型的转换数据
			$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
			// 遍历查询到的数据并进行相应的转换
			foreach($result as $key=>$value){
				// 状态等的转换
				$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
				$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
				$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
				$result[$key]['ziyuan'] = $value['business_type'];
				$cabinet = $value['cabinet']?$value['cabinet']:0;
				$result[$key]['cabinet'] = $cabinet;
				$ip_id = $value['ip_id']?$value['ip_id']:0;
				$result[$key]['ip_id'] = $ip_id;
				$machineroom = $value['machineroom']?$value['machineroom']:0;
				$result[$key]['machineroom'] =  $machineroom;
				//机柜等的对应查询
				$machinerooms = $this->machineroom($machineroom);//机房信息的查询
				$cabinet = $this->showCabinets($machineroom,$cabinet);
				$ip = $this->showIps($machineroom,$ip_id);
				// 进行对应的机柜等信息的转换或者显
				
				$result[$key]['cabinets'] = $cabinet->cabinet_id;//机柜信息的返回
				//IP信息的返回
				$result[$key]['ip'] = $ip->ip.'('.$ip_company[$ip->ip_company].')';
				$result[$key]['ip_company'] = $ip->ip_company;
				//机房的信息返回
				$result[$key]['machineroom_name'] = $machinerooms;
				
			}
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = [];
			$return['code'] = 1;
			$return['msg'] = '暂无数据';
		}

		return $return;
	}

	/**
	 * 选择机器(用于下订单时使用App\Admin\Controllers\Business\OrdersController)
	 * @return array 返回对应机房的机器信息
	 */
	public function selectMachine($where){
		// 查找对应机房为未使用的机器
		$where['used_status'] = 0;
		// 查找对应机房为上架的机器
		$where['machine_status'] = 0;
		// 进行条件查询业务类型为1的即租用的所有机器信息
		$result = $this->where($where)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note','created_at','updated_at']);
		//dd($result);
		// 判断是否查询到数据
		if(!$result->isEmpty()){
			// 查询到数据进行某些字段的数据转换
			$used_status = [0=>'未使用',1=>'业务锁定',2=>'使用中',3=>'锁定使用',4=>'迁移'];
			$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
			$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
			$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
			// 遍历查询到的数据并进行相应的转换
			foreach($result as $key=>$value){
				// 状态等的转换
				$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
				$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
				$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
				$result[$key]['machineroom_id'] = $value['machineroom'];
				unset($value['business_type']);
				// $cabinet = $value['cabinet']?$value['cabinet']:0;
				// $ip_id = $value['ip_id']?$value['ip_id']:0;
				$machinerooms = $this->machineroom($value['machineroom']);//机房信息的查询
				// 进行对应的机柜等信息的转换或者显示
				$machineroom = $this->machineroom($value['machineroom']);//机房信息的查询
				$cabinet = $this->showCabinets($value['machineroom'],$value['cabinet']);
				$ip = $this->showIps($value['machineroom'],$value['ip_id']);
				// 进行对应的机柜等信息的转换或者显
				
				$result[$key]['cabinets'] = $cabinet->cabinet_id;//机柜信息的返回
				//IP信息的返回
				$result[$key]['ip'] = $ip->ip;
				$result[$key]['ip_detail'] = $ip->ip.'('.$ip_company[$ip->ip_company].')';;
				//机房的信息返回
				$result[$key]['machineroom_name'] = $machinerooms;
				
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
			if(isset($data['business_type'])&&$data['business_type']==1||$data['business_type']==2){//当机器是租用/托管时，机柜/IP/机房必须选择
				if(isset($data['cabinet']) && empty($data['cabinet'])){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#001)租用/托管的机器必须放在机柜上';
					return $return;
				}
				if(isset($data['ip_id']) && empty($data['ip_id'])){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#002)租用/托管的机器必须配置IP';
					return $return;
				}
				if(isset($data['machineroom']) && empty($data['machineroom'])){
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#003)租用/托管的机器必须选择存放机房';
					return $return;
				}
			}
			DB::beginTransaction();//开启事务
			if(isset($data['ip_id']) && $data['ip_id'] != 0){
				$ip = DB::table('idc_ips')->where(['id'=>$data['ip_id']])->select('ip_status')->first();
				if(!$ip){//不存在此IP
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#101)新增机器信息失败,失败原因为:所选IP不存在!!';
					return $return;
				}
				if($ip->ip_status != 0){//此IP已被使用
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#102)新增机器信息失败,失败原因为:所选IP已经在使用!!';
					return $return;
				}
				$ip_row = DB::table('idc_ips')->where(['id'=>$data['ip_id']])->update(['mac_num'=>$data['machine_num'],'ip_status'=>1]);
				if($ip_row == 0){
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '(#103)新增机器信息失败！！';
					return $return;
				}
			}

			$data['created_at'] = date('Y-m-d H:i:s',time());
			$row = DB::table('idc_machine')->insertGetId($data);//将新增的机器信息插入数据库
			if($row != 0){
				DB::commit();
				$return['data'] = $row;
				$return['code'] = 1;
				$return['msg'] = '新增机器信息成功！！';
			} else {
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '(#104)新增机器信息失败！！';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '(#105)新增机器信息失败！';
		}
		return $return;
	}

	/**
	 * 对机器信息进行修改
	 * @param  array $editdata 要修改的数据
	 * @return array           返回提示信息和状态
	 */
	public function editMachine($editdata){
		$machine = $this->where(['id'=>$editdata['id']])->select('used_status','own_business','machine_num','ip_id','machineroom','cabinet','machine_status','business_type','cpu','memory','harddisk','bandwidth','protect','loginname','loginpass','machine_type')->first();
		if(empty($machine)){
			$return['code'] = 0;
			$return['msg'] = '(#101)未找到对应的机器信息!';
			return $return;
		}
		DB::beginTransaction();//开启事务
		if($machine->business_type == 1 || $machine->business_type == 2){
			if($machine->used_status == 1){
				$return['code'] = 0;
				$return['msg'] = '(#102)机器:'.$machine->machine_num.'有业务在锁定,无法进行修改!';
				return $return;
			}
		}
		/**
		 * 机器的IP字段是否更改
		 */
		if(isset($editdata['ip_id']) &&  $editdata['ip_id'] != $machine->ip_id){//当机器库的IP字段存在，且传递的新的IP字段，不等同于数据库的IP
			/**
			 * 原IP的去除
			 */
			$old_ip = DB::table('idc_ips')->where('id',$machine->ip_id)->first();//查找原本绑定的IP信息
			if(!empty($old_ip)){//存在原绑定的IP信息则进行数据抹除
				$original = DB::table('idc_ips')->where('id',$machine->ip_id)->update(['mac_num'=>'','ip_status'=>0]);
				if($original == 0){
					//原来的IP所属机器编号字段更新失败，事务回滚
					DB::rollBack();
					$return['code'] = 0;
					$return['msg'] = '(#103)机器信息修改失败！！!';
					return $return;
				}
			}
			/**
			 * 新IP的更改
			 */
			$new_ip = DB::table('idc_ips')->where(['id'=>$editdata['ip_id'],'ip_status'=>0,'ip_lock'=>0])->first();//查找新的未使用，未锁定的IP信息
			if(!empty($new_ip)){//找到对应的新IP信息
				$new_update =  DB::table('idc_ips')->where('id',$editdata['ip_id'])->update(['mac_num'=>$editdata['machine_num'],'ip_status'=>1]);
				if($new_update == 0){
					DB::rollBack();
					$return['code'] = 0;
					$return['msg'] = '(#104)机器信息修改失败！！!';
					return $return;
				}
			}
			if($editdata['ip_id'] != 0){
				$ip = $this->ip($editdata['ip_id']);
				$detail['ip'] = $ip->ip;
				$detail['ip_detail'] = $ip->ip_detail;
				$detail['ip_id'] = 	$editdata['ip_id'];	
			}
			
		} elseif(isset($editdata['ip_id']) &&  $editdata['ip_id'] == $machine->ip_id){
			if($editdata['ip_id'] != 0){
				$ip = $this->ip($editdata['ip_id']);
				$detail['ip'] = $ip->ip;
				$detail['ip_detail'] = $ip->ip_detail;
				$detail['ip_id'] = 	$editdata['ip_id'];	
			}
		}
		if($machine->business_type == 1 || $machine->business_type == 2){
			if($machine->used_status == 2 && $machine->used_status != $editdata['used_status']){
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '(#105)机器有业务在使用,无法进行修改';
				return $return;
			}
			if($machine->used_status != 1 && $editdata['used_status'] == 1){
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '(#106)业务锁定状态只能添加业务时锁定,无法手动修改为此状态';
				return $return;
			}
			if($machine->used_status != 2 && $editdata['used_status'] == 2){
				DB::rollBack();
				$return['code'] = 0;
				$return['msg'] = '(#107)使用中状态只能业务审核通过后自动修改为此状态,无法手动修改为此状态';
				return $return;
			}
		}
		if($machine->used_status == 2){//当机器的状态为使用中时，更改业务里面的resource_detail字段
			$business = DB::table('tz_business')->where(['business_number'=>$machine->own_business])->whereBetween('business_status',[0,4])->whereBetween('remove_status',[0,1])->select('id','business_number','machine_number','resource_detail')->first();
			if(!empty($business)){
				/**
				 * 重新对机器绑定的业务里面的详情进行更新
				 */
				$detail['id'] = $editdata['machine_num'];
				$detail['machine_num'] = $editdata['machine_num'];
				$detail['cpu'] = $editdata['cpu'];
				$detail['memory'] = $editdata['memory'];
				$detail['harddisk'] = $editdata['harddisk'];
				$detail['bandwidth'] = $editdata['bandwidth'];
				$detail['protect'] = $editdata['protect'];
				$detail['loginname'] = $editdata['loginname'];
				$detail['loginpass'] = $editdata['loginpass'];
				$detail['machine_type'] = $editdata['machine_type'];
				$detail['business_type'] = $editdata['business_type'];
				$detail['cabinet'] = $editdata['cabinet'];
				$detail['cabinets'] = $this->cabinet($editdata['cabinet']);
				$detail['machineroom_id'] = $editdata['machineroom'];
				$detail['machineroom_name'] = $this->machineroom($editdata['machineroom']);
				$resource_detail = json_encode($detail);
				$result = DB::table('tz_business')->where(['business_number'=>$machine->own_business])->update(['machine_number'=>$editdata['machine_num'],'resource_detail'=>$resource_detail]);
				if($result == 0){
					DB::rollBack();
					$return['code'] = 0;
					$return['msg'] = '(#106)机器信息修改失败！！!';
					return $return;
				}
			}
		}
		$editdata['updated_at'] = date('Y-m-d H:i:s',time());
		$row = DB::table('idc_machine')->where('id',$editdata['id'])->update($editdata);
		if($row == 0){
			//更新机器信息失败事务回滚
			DB::rollBack();
			$return['code'] = 0;
			$return['msg'] = '(#107)修改机器信息失败！！';
			
		} else {
			DB::commit();
			$return['code'] = 1;
			$return['msg'] = '修改成功！！';
		}
		
		return $return;
	}

	/**
	 * 删除机器信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteMachine($id){
		$res = $this->checkDel($id);
		if($res['code'] != 1){
			return $res;
		}
		$row = $this->where('id',$id)->delete();
		if($row != false){
			$return['code'] = 1;
			$return['msg'] = '删除机器信息成功！！';
		} else {
			$return['code'] = 0;
			$return['msg'] = '删除机器信息失败！！';
		}
			
		return $return;
	}

	protected function checkDel($id){
		$mod = $this->find($id);
		if($mod == null){
			return [
				'code'	=> 0,
				'msg'	=> '无此id',
			];
		}
		if($mod->used_status != 0){
			return [
				'code'	=> 2,
				'msg'	=> '机器正在使用,无法删除或编辑',
			];
		}else{
			return [
				'code'	=>1,
			];
		}
	}

	/**
	 * 机房信息的获取，当是展示机器的时候机房信息转换的时候需要传入对应的参数进行查询
	 * @param  integer $roomid  机房的id
	 * @return [type]           [description]
	 */
	public function machineroom($roomid = 0){
		
		if($roomid != 0){
			// 当是IP，机柜，机房等信息转换时对应参数都传入
			$machineroom = DB::table('idc_machineroom')->where('id',$roomid)->value('machine_room_name');//机房表
			if(empty($machineroom)){
				$machineroom = '机房暂未选择';
			}
			
		} else {
			$machineroom = '机房暂未选择';
		}
		return $machineroom;//返回数据
	}

	/**
	 * 机柜信息
	 * @param  integer $roomid  机房id
	 * @param  integer $cabinet 机柜id
	 * @return [type]           [description]
	 */
	public function showCabinets($roomid=0,$cabinet=0){
		if($cabinet != 0){
			$cabinets = DB::table('idc_cabinet')->where('id',$cabinet)->select('cabinet_id','machineroom_id')->first();
			if(empty($cabinets)){
				$cabinets->cabinet_id = '机柜暂未选择';
			} else {
				if($roomid != 0 && $cabinets->machineroom_id != $roomid){
					$cabinets->cabinet_id = $cabinets->cabinet_id.':机柜所在机房与机器所在机房不一致';
			    }
			}
			
		} else {
			$cabinets = json_decode('{"cabinet_id":"机柜暂未选择"}');
		}
		return $cabinets;
	}

	/**
	 * IP
	 * @param  integer $roomid 机房id
	 * @param  integer $ip_id  IP的id
	 * @return [type]          [description]
	 */
	public function showIps($roomid=0,$ip_id=0){
		if($ip_id != 0){
			$ip = DB::table('idc_ips')->where('id',$ip_id)->select('ip','ip_company','ip_comproom')->first();
			if(empty($ip)){
				$ip->ip = '0.0.0.0 IP暂未选择';
				$ip->ip_company = 0;
			} else {
				if($roomid !=0 && $ip->ip_comproom != $roomid){
					$ip->ip = $ip->ip.':IP所在机房与机器所在机房不一致';
				}
			}
			
		} else {
			$ip = json_decode('{"ip":"0.0.0.0 IP暂未选择","ip_company":0}');
		}
		return $ip;
	}

	/**
	 * 获取机房数据
	 * @return [type] [description]
	 */
	public function rooms(){
		// 当未传入参数时代表简单的查询机房数据
		$result = DB::table('idc_machineroom')->whereNull('deleted_at')->select('id as roomid','machine_room_id','machine_room_name')->get();
		if(!$result->isEmpty()) {
			$return['data'] = $result;
			$return['code'] = 1;
			$return['msg'] = '机房信息获取成功!!';
		} else {
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '机房信息获取失败!!';
		}
		return $return;
	}

	/**
	 * 对应机房的机柜信息的获取
	 * @param   $roomid 机柜的机房字段machineroom_id
	 * @return array         返回相关的数据和状态提示信息
	 */
	public function cabinets($roomid){

		if($roomid){

			$where = ['machineroom_id'=>$roomid['roomid']];
			$cabinets = DB::table('idc_cabinet')
							->where($where)
							->whereNull('deleted_at')
							->select('id as cabinetid','cabinet_id')
							->get();
			if(!$cabinets->isEmpty()){
				$return['data'] = $cabinets;
				$return['code'] = 1;
				$return['msg'] = '机柜信息获取成功';
			} else {
				$return['data'] = [];
				$return['code'] = 1;
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
			$orwhere = [];
			$where = ['ip_comproom'=>$roomid,'ip_company'=>$company,'ip_status'=>0,'ip_lock'=>0];
			if(isset($data['id'])){
				$orwhere['id'] = $data['id'];
			}
			$ips = DB::table('idc_ips')
					->where($where)
					->orWhere($orwhere)
					->whereNull('deleted_at')
					->select('id as ipid','ip','ip_company')
					->get();
			if(!$ips->isEmpty()){
				$return['data'] = $ips;
				$return['code'] = 1;
				$return['msg'] = 'IP信息获取成功';
			} else {
				$return['data'] = [];
				$return['code'] = 1;
				$return['msg'] = 'IP信息获取失败';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = 'IP信息无法获取';
		}
		return $return;
	}

	/**
	 * 查找机房信息
	 * @return [type] [description]
	 */
	public function machineRooms($id = 0){
		if($id != 0){
			$machineroom = DB::table('idc_machineroom')->where(['id'=>$id])->value('machine_room_name');
		} else {
			$machineroom = DB::table('idc_machineroom')->whereNull('deleted_at')->select('id','machine_room_name')->get();
			foreach($machineroom as $key => $value){
				$machineroom[$key] = $value->id.'--'.$value->machine_room_name;
			}
			$machineroom = $machineroom->toArray();
		}

		return $machineroom;
	}

	/**
	 * 获取机柜
	 * @return [type] [description]
	 */
	public function cabinet($cabinet_id){
		if($cabinet_id){
			$cabinet = DB::table('idc_cabinet')->where(['id'=>$cabinet_id])->value('cabinet_id');
		} elseif($cabinet_id == 0) {
			$cabinet = '机柜暂未选择';
		} else {
			$cabinet = DB::table('idc_cabinet')->whereNull('deleted_at')->select('id','machineroom_id','cabinet_id','use_type')->get();
			$use_type = [0=>'内部机柜',1=>'客户机柜'];
			foreach($cabinet as $key => $value){
				$cabinet[$key] =$this->machineRooms($value->machineroom_id).'--'.$value->id.'--'.$value->cabinet_id.'('.$use_type[$value->use_type].')';
			}
			$cabinet = $cabinet->toArray();
		}
		
		return $cabinet;
	}

	/**
	 * 获取IP
	 * @return [type] [description]
	 */
	public function ip($ip_id){
		$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
		if($ip_id){
			$ips = DB::table('idc_ips')->where(['id'=>$ip_id])->select('ip','ip_company')->first();
			if(!empty($ips)){
				$ips->ip_detail = $ips->ip.$ip_company[$ips->ip_company];
			}
		} else {
			$ips = DB::table('idc_ips')->where(['ip_status'=>0])->whereNull('deleted_at')->select('id','ip','ip_company','ip_comproom')->get();
			$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
			foreach($ips as $key => $value){
				$ips[$key] = $this->machineRooms($value->ip_comproom).'--'.$value->id.'--'.$value->ip.'('.$ip_company[$value->ip_company].')';
			}
			$ips = $ips->toArray();
		}
		
		return $ips;
	}

	/**
	 * 下载excel模板
	 * @return [type] [description]
	 */
	public function excelTemplate(){
		$spreadsheet = new Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle('机器批量导入表格');
		$worksheet->setCellValueByColumnAndRow(1, 1, '机器批量导入表格(此为测试功能)');
		$row_value = ['机器编号(必填)','CPU(必填)','内存(必填)','硬盘(必填)','机器型号(必填)','业务类型(必填)','机房(选填)','登录名(选填)','登录密码(选填)','备注'];//填写的字段
		$row = $worksheet->fromArray($row_value,NULL,'A4');//分配字段从A4开始填写（横向）
		$highest_row = $worksheet->getHighestRow();//总行数
		$highest_colum = $worksheet->getHighestColumn();//总列数
		//标题样式
		$title_font = [
			'font' => [
				'bold' => true,//加粗
				'size' => '20px',//字体大小
			],
			'alignment' => [//内容居中
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		];
		$worksheet->mergeCells('A1:'.$highest_colum.'1')->getStyle('A1:'.$highest_colum.'1')->applyFromArray($title_font);//设置标题样式
		//说明内容
		$worksheet->getCell('A2')->setValue("填写说明:填写机房时请参照右边的机房信息,填写对应id(例如A机房的id为1,此时填1);填写业务类型时请填写对应的代号即可(主要用于预备库的添加),以上字段请参照右边的对照表");
		$worksheet->getStyle('A2')->getFont()->applyFromArray(['bold'=>TRUE,'size'=>'12px']);//说明内容样式
		$worksheet->getRowDimension('2')->setRowHeight(16);//说明内容行高
		$worksheet->mergeCells('A2:'.$highest_colum.'3')->getStyle('A2:'.$highest_colum.'3')->getAlignment()->setWrapText(true);//说明内容自动换行
		//设置字段宽度
		for($i='A';$i<=$highest_colum;$i++){
			$worksheet->getColumnDimension($i)->setWidth(16);
		}
		$colum = ++$highest_colum;//字段名的列数
		//列名样式
		$row_font = [
			'font' => [
				'size' => '11px',//字体大小
			],
			'alignment' => [//内容居中
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		];
		$colum = ++$highest_colum;//说明字段的开始列数
		$note_value = ['机房(id-名称)','业务类型(代号-名称)'];//说明字段
		$row_note = $worksheet->fromArray($note_value,NULL,$colum.'4');//分配说明字段（横向）
		$highest_colum = $worksheet->getHighestColumn();//总的列数
		$row->getStyle('A4:'.$highest_colum.'4')->applyFromArray($row_font);//设置字段样式
		//设置说明字段样式
		for($i=$colum;$i<=$highest_colum;$i++){
			$worksheet->getColumnDimension($i)->setWidth(35);
		}
		$worksheet->mergeCells($colum.'1:'.$highest_colum.'3')->getStyle($colum.'1')->getFont()->applyFromArray(['bold'=>TRUE,'size'=>'12px']);//合并说明字段
		$worksheet->getCell($colum.'1')->setValue('字段填写对照表(注意:由于数据的随时变化,为了准确性,每次批量前都请重新下载模板)');
		$worksheet->mergeCells($colum.'1:'.$highest_colum.'3')->getStyle($colum.'1:'.$highest_colum.'3')->getAlignment()->setWrapText(true);
	   
		/**
		 * 机房数据
		 * @var [type]
		 */
		$machineroom = $this->machineRooms();
		$machineroom = array_chunk($machineroom,1);
		$worksheet->fromArray($machineroom,NULL,$colum.'5');
		// /**
		//  * 机柜数据
		//  * @var [type]
		//  */
		// $cabinet = $this->cabinet();
		// $cabinet = array_chunk($cabinet,1);
		// $worksheet->fromArray($cabinet,NULL,++$colum.'5');
		// /**
		//  * IP数据
		//  * @var [type]
		//  */
		// $ips = $this->ip();
		// $ips = array_chunk($ips,1);
		// $worksheet->fromArray($ips,NULL,++$colum.'5');
		// /**
		//  * 使用状态
		//  * @var [type]
		//  */
		// $use = ['0--未使用','1--使用中','2--锁定'];
		// $use = array_chunk($use,1);
		// $worksheet->fromArray($use,NULL,++$colum.'5');
		/**
		 * 业务类型
		 * @var [type]
		 */
		$business = ['3--预备机器','4--托管预备机器'];
		$business = array_chunk($business,1);
		$worksheet->fromArray($business,NULL,++$colum.'5');
		// /**
		//  * 上下架
		//  * @var [type]
		//  */
		// $machine_status = ['0--上架','1--下架'];
		// $machine_status = array_chunk($machine_status,1);
		// $worksheet->fromArray($machine_status,NULL,++$colum.'5');
		/**
		 * 下载模板
		 * @var [type]
		 */

		$filename = '机器批量导入表格模板.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		exit;
	}

	/**
	 * 处理批量添加机器
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function handleExcel($file){
		if(!$file){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请上传文件!!';
			return $return;
		}
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');//读取excel文件
		$spreadsheet = $reader->load($file->getRealPath());//加载文件
		$worksheet = $spreadsheet->getActiveSheet();//获取表格的活动区域
		$highest_colum = $worksheet->getHighestColumn();//获取总的列数
		$highest_colum_num = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highest_colum)-3;//将总列数转换为数字
		$highest_colum = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($highest_colum_num);//数字转换为列
		for($colum = 'A';$colum <= $highest_colum;$colum++){//转换列名
			switch($worksheet->getCell($colum.'4')->getValue()){
				case '机器编号(必填)':
					$colum_value[$colum] = 'machine_num';
					break;
				case 'CPU(必填)':
					$colum_value[$colum] = 'cpu';
					break;
				case '内存(必填)':
					$colum_value[$colum] = 'memory';
					break;
				case '硬盘(必填)':
					$colum_value[$colum] = 'harddisk';
					break;
				case '机器型号(必填)':
					$colum_value[$colum] = 'machine_type';
					break;
				case '机房(选填)':
					$colum_value[$colum] = 'machineroom';
					break;
				// case '机柜(必填)':
				//     $colum_value[$colum] = 'cabinet';
				//     break;
				// case 'IP(必填)':
				//     $colum_value[$colum] = 'ip_id';
				//     break;
				// case '带宽(M)(必填)':
				//     $colum_value[$colum] = 'bandwidth';
				//     break;
				// case '防护(G)(必填)':
				//     $colum_value[$colum] = 'protect';
				//     break;
				case '登录名(选填)':
					$colum_value[$colum] = 'loginname';
					break;
				case '登录密码(选填)':
					$colum_value[$colum] = 'loginpass';
					break;
				// case '使用状态(必填)':
				//     $colum_value[$colum] = 'used_status';
				//     break;
				case '业务类型(必填)':
					$colum_value[$colum] = 'business_type';
					break;
				// case '上下架(必填)':
				//     $colum_value[$colum] = 'machine_status';
				//     break;
				case '备注':
					$colum_value[$colum] = 'machine_note';
					break;
			}
		}
		$mysql = Schema::getColumnListing($this->table);//获取数据库中的字段
		if(empty($colum_value) && count(array_intersect($colum_value,$mysql) != 10)){//判断列名是否与数据库一致
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请从网站下载正确的模板填写!!';
			return $return;
		}
		$higehest_row = $worksheet->getHighestRow('A');//获取需添加字段的总行数
		for($row = 5;$row<=$higehest_row;$row++){
			for($colum_key = 'A';$colum_key<=$highest_colum;$colum_key++){
				$insert_data[$row-5][$colum_value[$colum_key]] = $worksheet->getCell($colum_key.$row)->getValue();
				$insert_data[$row-5]['created_at'] = date('Y-m-d H:i:s',time());
			}
		}
		if(!$insert_data){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请确认您有数据需要导入!!';
			return $return;
		}
		$return['data'] = '';
		for($i=0;$i<count($insert_data);$i++){
			DB::beginTransaction();//开启事务
			$row = DB::table($this->table)->insertGetId($insert_data[$i]);
			if($row == 0){
				DB::rollBack();
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '批量添加机器失败,失败原因为:编号'.$insert_data[$i]['machine_num'].'的机器信息有误,从此机器开始修改并重新提交信息,此机器前的所有信息已提交成功无须重新提交';
				return $return;
			}  else {
				DB::commit();
				$return['data'] = rtrim($row.','.$return['data'],',');
				$return['code'] = 1;
				$return['msg'] = '批量添加机器成功';
			}
			// $ip = DB::table('idc_ips')->where(['id'=>$insert_data[$i]['ip_id']])->select('ip_status')->first();
			// if(!$ip){//不存在此IP
			// 	DB::rollBack();
			// 	$return['data'] = '';
			// 	$return['code'] = 0;
			// 	$return['msg'] = '批量添加机器失败,失败原因为:编号'.$insert_data[$i]['machine_num'].'的机器所选IP不存在,从此机器开始修改并重新提交信息,此机器前的所有信息已提交成功无须重新提交';
			// 	return $return;
			// }
			// if($ip->ip_status != 0){//此IP已被使用
			// 	DB::rollBack();
			// 	$return['data'] = '';
			// 	$return['code'] = 0;
			// 	$return['msg'] = '批量添加机器失败,失败原因为:编号'.$insert_data[$i]['machine_num'].'的机器所选IP已经在使用,从此机器开始修改并重新提交信息,此机器前的所有信息已提交成功无须重新提交';
			// 	return $return;
			// }
			// if($insert_data[$i]['business_type'] == 1 || $insert_data[$i]['business_type'] == 3){
			// 	//如果新增机器成功则将机器编号更新到对应的IP库中
			// 	$ip_row = DB::table('idc_ips')->where(['id'=>$insert_data[$i]['ip_id']])->update(['mac_num'=>$insert_data[$i]['machine_num'],'ip_status'=>2]);
			// } elseif($insert_value['business_type'] == 2) {
			// 	//如果新增机器成功则将机器编号更新到对应的IP库中
			// 	$ip_row = DB::table('idc_ips')->where(['id'=>$insert_data[$i]['ip_id']])->update(['mac_num'=>$insert_data[$i]['machine_num'],'ip_status'=>3]);
			// }
			// if($ip_row != 0){
			// 	DB::commit();
			// 	$return['data'] = rtrim($row.','.$return['data'],',');
			// 	$return['code'] = 1;
			// 	$return['msg'] = '批量添加机器成功';
			// } 
   //          else {
			// 	DB::rollBack();
			// 	$return['data'] = '';
			// 	$return['code'] = 0;
			// 	$return['msg'] = '批量添加机器失败,失败原因为:编号'.$insert_data[$i]['machine_num'].'的机器IP信息有误,从此机器开始修改并重新提交信息,此机器前的所有信息已提交成功无须重新提交';
			// 	return $return;
			// }
		}
		return $return;
	}

	public function tranStatus(){
		$trans = $this->where('used_status','>',0)->select('id','used_status','machine_num')->get();
		if(!$trans->isEmpty()){
			DB::beginTransaction();
			foreach($trans as $key=>$value){
				echo '机器:'.$value['machine_num'].'的使用状态为'.$value['used_status'].'<br>';
				if($value['used_status'] == 1){
					$update = DB::table('idc_machine')->where(['id'=>$value['id']])->update(['used_status'=>2]);
				} else {
					$update = 1;
				}
				// elseif($value['used_status'] == 2){
				// 	$update = DB::table('idc_machine')->where(['id'=>$value['id']])->update(['used_status'=>3]);
				// } elseif($value['used_status'] == 3){
				// 	$update = DB::table('idc_machine')->where(['id'=>$value['id']])->update(['used_status'=>4]);
				// }
				if($update == 0){
					DB::rollBack();
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '机器:'.$value['machine_num'].'使用状态修改失败';
				} else {
					DB::commit();
				}
			}
			return ['data'=>'','code'=>1,'msg'=>'机器使用状态转换成功'];
		} else {
			return ['data'=>'','code'=>2,'msg'=>'暂无机器使用状态需要转换'];
		}

	}

}
