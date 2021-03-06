<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 处理harddisk的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-015 14:34:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  Harddisk extends Model
{
   use SoftDeletes;
   
	protected $table = 'idc_harddisk';
	
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['harddisk_number', 'harddisk_param','harddisk_used','created_at','updated_at','service_num','room_id'];
	// 测试

	/**
	* 查询harddisk表的数据
	* @return 将数据及相关的信息返回到控制器
	*/
	public function index(){
		// 用模型进行数据查询
		$index = $this->all(['id','harddisk_number','harddisk_param','harddisk_used','created_at','updated_at','service_num','room_id']);

		//分页获取方法
		//$index = $this->paginate(15);
		$status = [
			0 => '未使用',
			1 => '已使用',
			2 => '内部主机使用中',
			3 => '托管主机使用中'
		];
		//获取机房名称并转换
		$room = json_decode(json_encode($this->get_machineroom() ),true);
		$room = $room['data'];
		$room_arr = [];
		foreach ($room as $k=> $v) {
			$room_arr[$v['room_id']] = $v['room_name'];
		}

		foreach ($index as $k => $v) {
			$index[$k]['harddisk_used'] = $status[$index[$k]['harddisk_used']];
			$index[$k]['room'] = $room_arr[$index[$k]['room_id']];
			$index[$k]['ziyuan'] = 6;
		}
		
		if(!$index->isEmpty()){	
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = [];
			$return['code'] = 1;
			$return['msg'] = '暂无数据';
		}
		// 返回
		return $return;
	}


	/**
	* 对harddisk信息进行添加处理
	* @param  array $data 要添加的数据
	* @return array      返回的信息和状态
	*/
	public function insert($data){

		if($data){
			// 存在数据就用model进行数据写入操作
			// $fill = $this->fill($data);
			$data['harddisk_number'] = $data['harddisk_number'];
			$row = $this->create($data);

			if($row != false){
			// 插入数据成功
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = 'harddisk信息录入成功!!';

			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = 'harddisk信息录入失败!!';
			}
		} else {
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
		}
		return $return;

	}
	
  	 /**
	 * 对要修改的信息进行处理
	 * @param  array $data 要修改的数据
	 * @return array       返回信息和状态
	 */
	public function edit($data){
		if($data && $data['id']+0) {
			
			$row = self::where('id', $data['id'])
				->update($data);

			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '修改harddisk信息成功！！';
			} else {
				$return['code']	= 0;
				$return['msg'] 	= '修改harddisk信息失败！！';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '请确保信息正确';
		}
		return $return;
	}
	/**
	 * 删除harddisk信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function dele($id) {
		if($id) {
			$row = $this->where('id',$id)->delete();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '删除harddisk信息成功';
			} else {
				$return['code'] 	= 0;
				$return['msg'] 	= '删除harddisk信息失败';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '无法删除harddisk信息';
		}

		return $return;
	}

	/**
	* 获取机房的信息
	* @return array 返回相关的信息和数据
	*/
	public function get_machineroom($id='') {
		if($id){
			$room = DB::table('idc_machineroom')->find($id,['machine_room_name']);
			return $room;
		} else {
			$result = DB::table('idc_machineroom')->select('id as room_id','machine_room_name as room_name')->get();
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
	 * 客户选择增加硬盘
	 * @return array 相关资源数据
	 */
	public function selectHarddisk($machineroom){
		$where['harddisk_used'] = 0;
		$where['room_id'] = $machineroom;
		$harddisk = $this->where($where)->get(['harddisk_number','harddisk_param','room_id','id']);
		foreach($harddisk as $key => $value){
			$harddisk[$key]['machineroom'] = $this->machineroom($value['room_id']);
			$harddisk[$key]['label'] = $value['harddisk_number'];
			$harddisk[$key]['value'] = $value['harddisk_param'];
			unset($harddisk[$key]['harddisk_number']);
			unset($harddisk[$key]['harddisk_param']);
		}
		return $harddisk;
	}

	/**
	 * 转换机柜所在的机房数据
	 * @param  int $id 机房表的id
	 * @return string     返回机房的中文名
	 */
	public function machineroom($id){
		$machineroom = DB::table('idc_machineroom')->where('id',$id)->value('machine_room_name');
		return $machineroom;
	}

}
