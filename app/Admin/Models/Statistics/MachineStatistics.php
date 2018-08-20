<?php

// +----------------------------------------------------------------------
// | Author: kiri<420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 机器统计表的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-20 17:02:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\MachineStatistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  MachineStatistics extends Model
{
   use SoftDeletes;
   
	protected $table = 'idc_machine_statistics';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['tid', 'title','content','created_at','updated_at','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest'];
	// 测试

	/**
	* 查询文章表的数据
	* @return 将数据及相关的信息返回到控制器
	*/
	public function index(){
		// 用模型进行数据查询
		$index = $this->all(['id','tid','title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','created_at','updated_at']);

		if(!$index->isEmpty()){
		// 判断存在数据就对部分需要转换的数据进行数据转换的操作
			$status 	= [0=>'不显示',1=>'显示'];		
			$type = json_decode(json_encode($this->get_news_type() ),true);
			$type = $type['data'];
			$type_arr = [];
			foreach ($type as $k=> $v) {
				$type_arr[$v['tid']] = $v['type_name'];
			}
		
			foreach($index as $key=>$value) {
			// 对应的字段的数据转换
			// return 123;
				$index[$key]['type_name'] 	= $type_arr[$value['tid']];
				$index[$key]['top_status'] 	= $status[$value['top_status']];
				$index[$key]['home_status'] 	= $status[$value['home_status']];
				
			}

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
	* 对文章信息进行添加处理
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
				$return['msg'] = '消息发布成功!!';

			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '消息发布失败!!';
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
			$edit = $this->find($data['id']);
			$edit->tid 		= $data['tid'];
			$edit->title 		= $data['title'];
			$edit->content 		= $data['content'];
			$edit->top_status 	= $data['top_status'];
			$edit->home_status 	= $data['home_status'];
			$edit->seoKeywords 	= $data['seoKeywords'];
			$edit->seoTitle 		= $data['seoTitle'];
			$edit->seoDescription 	= $data['seoDescription'];
			$edit->digest 		= $data['digest'];
			$row = $edit->save();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '修改文章信息成功！！';
			} else {
				$return['code']	= 0;
				$return['msg'] 	= '修改文章信息失败！！';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '请确保信息正确';
		}
		return $return;
	}
	/**
	 * 删除文章信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function dele($id) {
		if($id) {
			$row = $this->where('id',$id)->delete();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '删除文章信息成功';
			} else {
				$return['code'] 	= 0;
				$return['msg'] 	= '删除文章信息失败';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '无法删除文章信息';
		}

		return $return;
	}

	/**
	* 获取文章的信息
	* @return array 返回相关的信息和数据
	*/
	public function get_news_type($id='') {
		if($id){
			$type = DB::table('tz_news_type')->find($id,['name']);
			return $type;
		} else {
			$result = DB::table('tz_news_type')->select('id as tid','name as type_name')->get();
			if($result) {
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = '文章类型获取成功!!';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '文章类型获取失败!!';
			}

			return $return;
		}
	}

}
