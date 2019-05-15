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
	protected $fillable = ['name', 'url','sort','image','description','user','links_order'];  

	public function getLinks(){
		$link = $this->select(['name', 'url', 'description','links_order'])->orderBy('links_order','asc')->get();
		
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

		return $link;
	}
}
