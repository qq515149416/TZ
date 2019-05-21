<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class PromotionModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_promotion';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['img', 'link','title','top','digest','end_at','pro_order','sale_status'];  

	public function insert($par){
		return $this->create($par);

	}

	public function del($del_id){
		$link = $this->find($del_id);
		if($link == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$del_res = $link->delete();
		if($del_res){
			return [
				'data'	=> [],
				'msg'	=> '删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '删除失败',
				'code'	=> 0,
			];
		}
	}

	public function edit($par){
		$link = $this->find($par['edit_id']);
		if($link == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$edit_res = $link->update($par);

		if($edit_res){
			return [
				'data'	=> [],
				'msg'	=> '编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '编辑失败',
				'code'	=> 0,
			];
		}
	}

	public function show(){
		$pro = $this->get();
		if ($pro->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无数据',
				'code'	=> 1,
			];
		}else{
			foreach ($pro as $k => $v) {
				$v = $this->trans($v);
			}

			return [
				'data'	=> $pro,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}	
	}

	protected function trans($pro){

		$pro->img = json_decode($pro->img);
		$pro->link = json_decode($pro->link);
		switch ($pro->top) {
			case '0':
				$pro->top = "不置顶";
				break;
			case '1':
				$pro->top = "置顶";
				break;
			default:
				$pro->top = "未知状态";
				break;
		}
		switch ($pro->sale_status) {
			case '0':
				$pro->sale_status = "活动结束";
				break;
			case '1':
				$pro->sale_status = "在售";
				break;
			case '2':
				$pro->sale_status = "预备中";
				break;
			default:
				$pro->sale_status = "未知状态";
				break;
		}
		return $pro;
	}
}