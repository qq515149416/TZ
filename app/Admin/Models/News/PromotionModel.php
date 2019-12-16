<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 促销活动管理模型
 *
 */

class PromotionModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_promotion';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['img', 'link','title','top','digest','end_at','pro_order','start_at'];

    public function getSaleStatusAttribute($value)
    {
        // dd($value);
        if($value > 0) {
            if(!($this->start_at < date("Y-m-d H:i:s") &&  $this->end_at > date("Y-m-d H:i:s"))) {
                return 0;
            }
        }
        return $value;
    }

	/**
	 * 增
	 */
	public function insert($par){
		return $this->create($par);

	}

	/**
	 * 删
	 */
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

	/**
	 * 改
	 */
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

	/**
	 * 查
	 */
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

	/**
	 * 渲染数据
	 */
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

		return $pro;
	}
}
