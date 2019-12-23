<?php

namespace App\Http\Models\News;

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
	protected $fillable = ['name', 'url','type','description','user','links_order'];  

	public function getLinks($type){
		$link = $this->select(['id','name', 'url', 'description','links_order','type'])->where('type',$type)->orderBy('links_order','desc')->get();
		
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
		
		switch ($link->type) {
			case '0':
				$link->type = '友情链接';
				break;
			case '1':
				$link->type = '轮播图';
				break;
			default:
				# code...
				break;
		}
		return $link;
	}
}
