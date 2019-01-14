<?php

namespace App\Admin\Models\DataTransfer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DataTransfer extends Model
{
	/**
	 * 机房旧数据库转移方法
	 */
	public function transMachineroom(){
		//is_trans字段判断是否已经转移,找未转移的
		$old_room = DB::table('comproom')->where('is_trans',0)->get()->toArray();
		if(count($old_room) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无未转移机房',
				'code'	=> 0,
			];
		}
		//循环转到新表

		for ($i=0; $i < count($old_room); $i++) { 
			$data = [
				'machine_room_id'	=> $old_room[$i]->comproomid,
				'machine_room_name'	=> $old_room[$i]->comproomname,
				'created_at'		=> date('Y-m-d H:i:s'),
			];

			//查找新表是否存在该机房
			$check = DB::table('idc_machineroom')->where('machine_room_name',$old_room[$i]->comproomname)->first();
			if($check != null){
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_room[$i]->id.' , 该机房已存在',
					'code'	=> 0,
				];
			}
			//开启事务
			DB::beginTransaction();
			//在新表创建数据
			$res = DB::table('idc_machineroom')->insert($data);
			if($res != false){
				//如果成功创建,就将旧表的is_trans改为1
				$up = DB::table('comproom')->where('id',$old_room[$i]->id)->update(['is_trans' => 1]);
				if($up != true){
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_room[$i]->id.' , 更新转移状态,转移失败',
						'code'	=> 0,
					];
					break;
				}
			}else{
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_room[$i]->id.' , 转移失败',
					'code'	=> 0,
				];			
				break;
			}
			DB::commit();
		}
		return [
				'data'	=> '',
				'msg'	=> '转移成功',
				'code'	=> 1,
			];
	}

	/**
	 * 旧数据库    后台人员信息 转移方法
	 */
	public function transAdminUser(){
		$old_admin_user = DB::table('masters')->where('is_trans',0)->get()->toArray();

		if(count($old_admin_user) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无未转移后台账号',
				'code'	=> 0,
			];
		}
		//循环转到新表

		for ($i=0; $i < count($old_admin_user); $i++) { 
			$data = [
				'username'		=> $old_admin_user[$i]->name,
				'password'		=> $old_admin_user[$i]->password,
				'name'			=> $old_admin_user[$i]->truename,
				'created_at'		=> date('Y-m-d H:i:s'),
			];

			//查找新表是否存在
			$check = DB::table('admin_users')->where('username',$old_admin_user[$i]->name)->first();
			if($check != null){
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_admin_user[$i]->maid.' , 该账号已存在',
					'code'	=> 0,
				];
			}
			//开启事务
			DB::beginTransaction();
			//在新表创建数据
			$res = DB::table('admin_users')->insert($data);
			if($res != false){
				//如果成功创建,就将旧表的is_trans改为1
				$up = DB::table('masters')->where('maid',$old_admin_user[$i]->maid)->update(['is_trans' => 1]);
				if($up != true){
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_admin_user[$i]->maid.' , 更新转移状态,转移失败',
						'code'	=> 0,
					];
					break;
				}
			}else{
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_admin_user[$i]->maid.' , 转移失败',
					'code'	=> 0,
				];			
				break;
			}
			DB::commit();
		}
		return [
				'data'	=> '',
				'msg'	=> '转移成功',
				'code'	=> 1,
			];
	}

	/**
	 * 旧数据库    IP资源 转移方法
	 */
	public function transIp(){
		// $test = DB::table('idc_ips')->where('ip','183.2.243.0')->first();
		// dd($test);
		$old_dxips = DB::table('dxips')->where('is_trans',0)->get()->toArray();
		$old_unicomips = DB::table('unicomips')->where('is_trans',0)->get()->toArray();
		if(count($old_dxips) == 0 && count($old_unicomips) == 0 ){
			return [
				'data'	=> '',
				'msg'	=> '无未转移ip',
				'code'	=> 1,
			];
		}
		$sameIp = '';
		if(count($old_dxips) != 0){
			for ($i=0; $i < count($old_dxips); $i++) { 
				$data = [
					'vlan'			=> $old_dxips[$i]->vlan,
					'ip'			=> $old_dxips[$i]->dxip,
					'ip_note'		=> $old_dxips[$i]->note,
					'created_at'		=> date('Y-m-d H:i:s'),
					'ip_company'		=> 0,
					'ip_status'		=> 0,
				];
				if($old_dxips[$i]->ipstatus == 4){
					$data['ip_lock'] = 1;
				}
				//找机房关联
				$old_room = DB::table('comproom')->where('comproomid',$old_dxips[$i]->comproom)->value('comproomname');
				$data['ip_comproom'] = DB::table('idc_machineroom')->where('machine_room_name',$old_room)->value('id');

				//查找新表是否存在
				$check = DB::table('idc_ips')->where('ip',$old_dxips[$i]->dxip)->first();
				
				if($check != null){
					// return [
					// 	'data'	=> '',
					// 	'msg'	=> 'id : '.$old_dxips[$i]->id.' , 该电信ip已存在',
					// 	'code'	=> 0,
					// ];
					$up = DB::table('idc_ips')->where('id',$check->id)->update(['ip' => $check->ip.'(new)']);
					$sameIp.= $check->id. ' 、 ';
				}
				//开启事务
				DB::beginTransaction();
				//在新表创建数据
				$res = DB::table('idc_ips')->insert($data);
				if($res != false){
					//如果成功创建,就将旧表的is_trans改为1
					$up = DB::table('dxips')->where('id',$old_dxips[$i]->id)->update(['is_trans' => 1]);
					if($up != true){
						DB::rollBack();
						return [
							'data'	=> '',
							'msg'	=> 'id : '.$old_dxips[$i]->id.' , 此电信IP  更新转移状态失败',
							'code'	=> 0,
						];
						break;
					}
				}else{
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_dxips[$i]->id.' ,此电信IP 转移失败',
						'code'	=> 0,
					];			
					break;
				}
				DB::commit();
			}
		}
		//循环转到新表
		$sameIp.= ' 这些id的电信ip重名,新库的后面加了 (new);';
		
		if(count($old_unicomips) != 0){
			for ($j=0; $j < count($old_unicomips); $j++) { 
				$data = [
					'vlan'			=> $old_unicomips[$j]->vlan,
					'ip'			=> $old_unicomips[$j]->unip,
					'ip_note'		=> $old_unicomips[$j]->note,
					'created_at'		=> date('Y-m-d H:i:s'),
					'ip_company'		=> 2,
					'ip_status'		=> 0,
				];
				if($old_unicomips[$j]->ipstatus == 4){
					$data['ip_lock'] = 1;
				}
				//找机房关联
				$old_room = DB::table('comproom')->where('comproomid',$old_unicomips[$j]->comproom)->value('comproomname');
				$data['ip_comproom'] = DB::table('idc_machineroom')->where('machine_room_name',$old_room)->value('id');

				//查找新表是否存在
				$check = DB::table('idc_ips')->where('ip',$old_unicomips[$j]->unip)->first();
				if($check != null){
					// return [
					// 	'data'	=> '',
					// 	'msg'	=> 'id : '.$old_unicomips[$j]->id.' , 该联通ip已存在',
					// 	'code'	=> 0,
					// ];
					$up = DB::table('idc_ips')->where('id',$check->id)->update(['ip' => $check->ip.'(new)']);
					$sameIp.= $check->id. ' 、 ';
				}
				//开启事务
				DB::beginTransaction();
				//在新表创建数据
				$res = DB::table('idc_ips')->insert($data);
				if($res != false){
					//如果成功创建,就将旧表的is_trans改为1
					$up = DB::table('unicomips')->where('id',$old_unicomips[$j]->id)->update(['is_trans' => 1]);
					if($up != true){
						DB::rollBack();
						return [
							'data'	=> '',
							'msg'	=> 'id : '.$old_unicomips[$j]->id.' ,该联通ip 更新转移状态失败',
							'code'	=> 0,
						];
						break;
					}
				}else{
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_unicomips[$j]->id.' ,该联通ip 转移失败',
						'code'	=> 0,
					];			
					break;
				}
				DB::commit();
			}
		}
		$sameIp.= ' 这些id的联通ip重名,新库的后面加了 (new);';
		return [
				'data'	=> '',
				'msg'	=> '转移成功,'.$sameIp,
				'code'	=> 1,
			];
	}


	public function transCabinet(){

		$old_cabinet = DB::table('jg')->where('is_trans',0)->get()->toArray();
		if(count($old_cabinet) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无未转移机柜',
				'code'	=> 0,
			];
		}
		//循环转到新表

		for ($i=0; $i < count($old_cabinet); $i++) { 
			$data = [
				'cabinet_id'		=> $old_cabinet[$i]->cabinet,
				'use_type'		=> $old_cabinet[$i]->usedtype,
				'note'			=> $old_cabinet[$i]->note,
				'add_time'		=> $old_cabinet[$i]->addtime,
				'created_at'		=> date('Y-m-d H:i:s'),
			];

			$old_room = DB::table('comproom')->where('comproomid',$old_cabinet[$i]->comproomid)->value('comproomname');
			$data['machineroom_id'] = DB::table('idc_machineroom')->where('machine_room_name',$old_room)->value('id');
			//查找新表是否存在
			$check = DB::table('idc_cabinet')->where('cabinet_id',$old_cabinet[$i]->cabinet)->first();
			if($check != null){
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_cabinet[$i]->jgid.' , 该机柜已存在',
					'code'	=> 0,
				];
			}
			//开启事务
			DB::beginTransaction();
			//在新表创建数据
			$res = DB::table('idc_cabinet')->insert($data);
			if($res != false){
				//如果成功创建,就将旧表的is_trans改为1
				$up = DB::table('jg')->where('jgid',$old_cabinet[$i]->jgid)->update(['is_trans' => 1]);
				if($up != true){
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_cabinet[$i]->jgid.' , 更新转移状态,转移失败',
						'code'	=> 0,
					];
					break;
				}
			}else{
				DB::rollBack();
				return [
					'data'	=> '',
					'msg'	=> 'id : '.$old_cabinet[$i]->jgid.' , 转移失败',
					'code'	=> 0,
				];			
				break;
			}
			DB::commit();
		}
		return [
				'data'	=> '',
				'msg'	=> '转移成功',
				'code'	=> 1,
			];
	}

	public function transMachine(){
		
		$old_machine = DB::table('machinelibrary')->where('is_trans',0)->get()->toArray();
	
		if(count($old_machine) == 0){
			return [
				'data'	=> DB::table('idc_machine')->where('machine_status',0)->whereNull('cabinet')->get(['id']),
				'msg'	=> '无未转移机器,data里的这些id机柜信息有问题',
				'code'	=> 0,
			];
		}
		//循环转到新表
		$wrong_cabinet = [];
		for ($i=0; $i < count($old_machine); $i++) { 
			$data = [
				'machine_num'		=> $old_machine[$i]->macnum,
				'cpu'			=> $old_machine[$i]->cpu,
				'memory'		=> $old_machine[$i]->memory,
				'harddisk'		=> $old_machine[$i]->harddisk,
				'loginname'		=> $old_machine[$i]->macname,
				'loginpass'		=> $old_machine[$i]->macpass,
				'machine_type'		=> $old_machine[$i]->mactype,
				'machine_note'		=> $old_machine[$i]->note,
				'machine_status'	=> $old_machine[$i]->status,
				'created_at'		=> date('Y-m-d H:i:s'),
			];
			switch ($old_machine[$i]->biztype) {
				case '0':
					$data['business_type']	= 2;
					break;
				case '1':
					$data['business_type']	= 1;
					break;
				default:
					
					break;
			}
			$old_machine_room = DB::table('comproom')->where('comproomid',$old_machine[$i]->comproom)->value('comproomname');
			$data['machineroom'] = DB::table('idc_machineroom')->where('machine_room_name',$old_machine_room)->value('id');

			if($old_machine[$i]->status == 0){
				$info = DB::table('idc_cabinet')->where('cabinet_id',$old_machine[$i]->cabinet)->select(['id', 'machineroom_id'])->first();
				if($info == null){

					$wrong_cabinet[]= $old_machine[$i]->machid;
					// return [
					// 	'data'	=> '',
					// 	'msg'	=> ' id : '.$old_machine[$i]->machid.' 机柜信息错误,请手动核实',
					// 	'code'	=> 0,
					// ];
				}else{
					$data['cabinet'] = $info->id;
				}
				// if(filter_var(trim($old_machine[$i]->dxip), FILTER_VALIDATE_IP)) {
				// 	$data['ip_id'] = DB::table('idc_ips')->where('ip',$old_machine[$i]->dxip)->value('id');
				// }else{
				// 	if(filter_var(trim($old_machine[$i]->unicomip), FILTER_VALIDATE_IP)) {
				// 		$data['ip_id'] = DB::table('idc_ips')->where('ip',$old_machine[$i]->unicomip)->value('id');
				// 	}	
				// }
			}
			
			//查找新表是否存在
			$check = DB::table('idc_machine')->where('machine_num',$old_machine[$i]->macnum)->first();

			if($check != null){
				
				// return [
				// 	'data'	=> '',
				// 	'msg'	=> 'id : '.$old_machine[$i]->machid.' , 该机器已存在',
				// 	'code'	=> 0,
				// ];
			}else{
				//开启事务
				DB::beginTransaction();
				//在新表创建数据
				$res = DB::table('idc_machine')->insert($data);
				if($res != false){
					//如果成功创建,就将旧表的is_trans改为1
					$up = DB::table('machinelibrary')->where('machid',$old_machine[$i]->machid)->update(['is_trans' => 1]);
					if($up != true){
						DB::rollBack();
						return [
							'data'	=> '',
							'msg'	=> 'id : '.$old_machine[$i]->machid.' , 更新转移状态,转移失败',
							'code'	=> 0,
						];
						break;
					}
				}else{
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_machine[$i]->machid.' , 转移失败',
						'code'	=> 0,
					];			
					break;
				}
				DB::commit();
			}
			
		}
		return [
				'data'	=> DB::table('idc_machine')->where('machine_status',0)->whereNull('cabinet')->get(['id']),
				'msg'	=> '转移成功,可这些id的机柜信息有问题',
				'code'	=> 1,
			];
	}

	public function transCustomer(){

		// $test = DB::table('customer')->where('cusname','xiaowu')->get()->toArray();
		// dd($test);
		$old_customer = DB::table('customer')->where('is_trans',0)->get()->toArray();
		// dd($old_customer);
		if(count($old_customer) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无未转移客户',
				'code'	=> 0,
			];
		}
		//循环转到新表

		for ($i=0; $i < count($old_customer); $i++) { 
			$data = [
				'name'			=> $old_customer[$i]->cusname,
				'password'		=> $old_customer[$i]->cuspassword,
				'nickname'		=> $old_customer[$i]->custruename,
				'created_at'		=> $old_customer[$i]->createdate,
			];

			$old_sale = DB::table('masters')->where('maid',$old_customer[$i]->masterid)->value('name');
			if($old_sale == null){
				$data['salesman_id'] = null;
			}else{
				$data['salesman_id'] = DB::table('admin_users')->where('username',$old_sale)->value('id');
			}

			switch ($old_customer[$i]->status) {
				case '0':
					$data['status'] = 2;
					break;
				case '1':
					$data['status'] = 0;
					break;
				default:
					break;
			}
			//查找新表是否存在
			$check = DB::table('tz_users')->where('name',$old_customer[$i]->cusname)->first();
			if($check != null){
				// return [
				// 	'data'	=> '',
				// 	'msg'	=> 'id : '.$old_customer[$i]->cusid.' , 该用户已存在',
				// 	'code'	=> 0,
				// ];
			}else{
				//开启事务
				DB::beginTransaction();
				//在新表创建数据
				$res = DB::table('tz_users')->insert($data);
				if($res != false){
					//如果成功创建,就将旧表的is_trans改为1
					$up = DB::table('customer')->where('cusid',$old_customer[$i]->cusid)->update(['is_trans' => 1]);
					if($up != true){
						DB::rollBack();
						return [
							'data'	=> '',
							'msg'	=> 'id : '.$old_customer[$i]->cusid.' , 更新转移状态,转移失败',
							'code'	=> 0,
						];
						break;
					}
				}else{
					DB::rollBack();
					return [
						'data'	=> '',
						'msg'	=> 'id : '.$old_customer[$i]->cusid.' , 转移失败',
						'code'	=> 0,
					];			
					break;
				}
				DB::commit();
			}
		}
		return [
				'data'	=> '',
				'msg'	=> '转移成功',
				'code'	=> 1,
			];
	}
}
