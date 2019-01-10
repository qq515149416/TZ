<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MachineRoomModel extends Model
{
	use SoftDeletes;

	//表名
	protected $table = 'idc_machineroom';

	//设置主键
	public $primaryKey = 'id';
	public $timestamps = true;
	//定义软删除 字段
	protected $dates = ['delete_at'];
	protected $fillable = ['machine_room_id', 'machine_room_name','list_order','white_list_add','white_list_key'];

	/**
	 * 根据机房编号,机房名称生成机房 记录
	 *
	 * @param $roomId
	 * @param $roomName
	 * @return mixed
	 */
	public function store($roomId, $roomName,$departId,$white_list_add,$white_list_key)
	{   
		//判断机房编号是否存在
		if ($this->where('machine_room_id', '=', $roomId)->exists()) {
			$res['content'] = '1';
			$res['message'] = '机房编号已存在';
			$res['state']   = 0;
			return $res;
		}

		//判断机房名称是否存在
		if ($this->where('machine_room_name', '=', $roomName)->exists()) {
			$res['content'] = '2';
			$res['message'] = '机房名字已存在';
			$res['state']   = 0;
			return $res;
		}

		//判断管理机房的部门是否已绑定其他机房
		if ($this->where('list_order', '=', $departId)->exists()) {
			$res['content'] = '3';
			$res['message'] = '此部门已管理其他机房';
			$res['state']   = 0;
			return $res;
		}

		$this->machine_room_id   = $roomId;
		$this->machine_room_name = $roomName;
		$this->list_order = $departId;
		$this->white_list_add = $white_list_add;
		$this->white_list_key = $white_list_key;
		$insertInfo = $this->save();
		// dd($insertInfo);
		//添加机房记录
		if ($insertInfo) {
			$res['content'] = $insertInfo;
			$res['message'] = '添加机房成功';
			$res['state']   = 1;
			return $res;
		} else {
			$res['content'] = $insertInfo;
			$res['message'] = '添加机房失败';
			$res['state']   = 0;
			return $res;
		}

	}

	/**
	 * 修改机房信息
	 * @param  int $id             机房id
	 * @param  string $roomId         机房编号
	 * @param  string $roomName       机房名称
	 * @param  int $departId      机房所对应的管理部门
	 * @param  string $white_list_add 白名单的api接口
	 * @param  string $white_list_key 白名单的api接口的密钥
	 * @return array                 修改后的返回信息及提示
	 */
	public function updateStore($id,$roomId, $roomName,$departId,$white_list_add,$white_list_key){
		if(!isset($id)){
			$res['content'] = '';
			$res['message'] = '(#101)修改机房失败';
			$res['state']   = 0;
			return $res;
		}
		$machineroom = $this->where(['id'=>$id])->first();
		if(empty($machineroom)){
			$res['content'] = '';
			$res['message'] = '(#102)机房不存在';
			$res['state']   = 0;
			return $res;
		}
		$machineroom = [];
		$machineroom['machine_room_id']   = $roomId;
		$machineroom['machine_room_name'] = $roomName;
		$machineroom['list_order'] = $departId;
		$machineroom['white_list_add'] = $white_list_add;
		$machineroom['white_list_key'] = $white_list_key;
		$machineroom['id'] = $id;
		$row = $this->where(['id'=>$id])->update($machineroom);
		if($row != 0){
			$res['content'] = '';
			$res['message'] = '机房信息修改成功';
			$res['state']   = 1;
			
		} else {
			$res['content'] = '';
			$res['message'] = '(#103)机房信息修改失败';
			$res['state']   = 0;
		}
		return $res;
	}

	/**
	 * 查询列表数据
	 *
	 *
	 */
	public function show()
	{
		$res = $this->all();
		if(!$res->isEmpty()){
			foreach ($res as $key => $value) {
				$res[$key]['list_order'] = $this->machineroom($value['list_order']);
			}
		}else{
			$res = false;
		}
		return $res;
	}

	/**
	 * 获取机房多选列表
	 */
	public function showSelectList()
	{
		$listData = $this->select('id', 'machine_room_name')->get();


		return $listData;
	}


	/**
	 * 根据机房id查询机房中文名称
	 */
	public function queryMachineRoomName($id = '')
	{

		$data = $this->where('id', $id)->select('machine_room_name')->first();

		return $data;

	}

	/**
	 * 获取机房管理部门的部门名称
	 * @param  [type] $machineroom_id [description]
	 * @return [type]                 [description]
	 */
	public function machineroom($machineroom_id){
		$department = DB::table('tz_department')->where(['id'=>$machineroom_id])->value('depart_name');
		return $department;

	}

	/**
	 * 机房旧数据库转移方法
	 */
	public function trans(){
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
			];

			//查找新表是否存在该机房
			$check = $this->where('machine_room_name',$old_room[$i]->comproomname)->first();
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
			$res = $this->create($data);
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

	public function gogogo($data){

	}
}
