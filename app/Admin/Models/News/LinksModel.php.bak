<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class LinksModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_links';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'url','sort','image','description','user','links_order'];  

	public function insert($par){
		$par['url'] = json_encode($par['url']);
		if (isset($par['image'])) {
			$par['image'] = json_encode($par['image']);
		}
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
		if (isset($par['image'])) {
			$par['image'] = json_encode($par['image']);
		}
		if (isset($par['url'])) {
			$par['url'] = json_encode($par['url']);
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
		$link = $this->get();
		if ($link->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无数据',
				'code'	=> 1,
			];
		}else{

			foreach ($link as $k => $v) {
				$v = $this->trans($v);
			}
			return [
				'data'	=> $link,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}	
	}

	public function trans($link){
		$link->url = json_decode($link->url);
		$link->image = json_decode($link->image);
		switch ($link->sort) {
			case '0':
				$link->sort = '友情链接';
				break;
			case '1':
				$link->sort = '轮播图';
				break;
			default:
				# code...
				break;
		}

		return $link;
	}
}
