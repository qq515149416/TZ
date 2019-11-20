<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 后台人员处理用户列表的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-31 17:21:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  Customer extends Model
{
	protected $table = 'tz_users';
	
	public $timestamps = true;

	
	protected $fillable = ['name', 'email','money','created_at'];
	// 测试

	/**
	* 查询前台user表的数据
	* @param  $admin_id 	后台人员id
	* @return  所属客户部分信息
	*/
	public function showCustomerList($admin_id){
		// 用模型进行数据查询
		$list = $this->select('name', 'email','money','created_at')->where('salesman_id',$admin_id)->get();
	
		// 返回
		return $list;
	}


	/**
	* 对cpu信息进行添加处理
	* @param  array $data 要添加的数据
	* @return array      返回的信息和状态
	*/
	public function insert($data){

		if($data){
			// 存在数据就用model进行数据写入操作
			// $fill = $this->fill($data);
		
			$row = $this->create($data);

			if($row != false){
			// 插入数据成功
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = 'cpu信息录入成功!!';

			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = 'cpu信息录入失败!!';
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
				$return['msg'] 	= '修改cpu信息成功！！';
			} else {
				$return['code']	= 0;
				$return['msg'] 	= '修改cpu信息失败！！';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '请确保信息正确';
		}
		return $return;
	}
	/**
	 * 删除cpu信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function dele($id) {
		if($id) {
			$row = $this->where('id',$id)->delete();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '删除cpu信息成功';
			} else {
				$return['code'] 	= 0;
				$return['msg'] 	= '删除cpu信息失败';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '无法删除cpu信息';
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
	
}
