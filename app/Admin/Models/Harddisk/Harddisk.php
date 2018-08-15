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
namespace App\Admin\Models\Harddisk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  Harddisk extends Model
{
   use SoftDeletes;
   
	protected $table = 'idc_harddisk';
	
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['harddisk_number', 'harddisk_param','harddisk_used','created_at','updated_at','service_num'];
	// 测试

	/**
	* 查询harddisk表的数据
	* @return 将数据及相关的信息返回到控制器
	*/
	public function index(){
		// 用模型进行数据查询
		$index = $this->all(['id','harddisk_number','harddisk_param','harddisk_used','created_at','updated_at','service_num']);
		$status = [
			0 => '未使用',
			1 => '已使用',
			2 => '内部主机使用中',
			3 => '托管主机使用中'
		];
		
		foreach ($index as $k => $v) {
			$index[$k]['harddisk_used'] = $status[$index[$k]['harddisk_used']];
		}
		
		if(!$index->isEmpty()){	
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = $index;
			$return['code'] = 0;
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


}
