<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class HelpCategoryModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_help_category';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	/**
	 * 获取父级信息.
	 *
	 * @param  string  $value
	 * @return Model
	 */
	public function getParentIdAttribute($value)
	{
		if($value) {
			return $this->where("id",$value)->first();
		}
	}

	//根据名字模糊查找分类及所有子分类的id
	public function getIdByProduct($name)
	{
		$category = $this->where('parent_id',0)
				->where('name' , 'like' , '%'.$name.'%')
				->where('status' , 1)
				->get(['id']);
		$id_arr = [];
		if(!$category->isEmpty()){
			
			foreach ($category as $k => $v) {
				$id_arr[$k]['id_arr'] = [ $category[$k]['id'] ];
				$son_id = HelpCategoryModel::where(["parent_id" => $category[$k]['id'] , "status" => 1])->get(['id']);
				
				while (!$son_id->isEmpty()) {
					$son_arr = [];

					for ($i=0; $i < count($son_id); $i++) { 
						$son_arr[] = $son_id[$i]['id'];
						$id_arr[$k]['id_arr'][]  = $son_id[$i]['id'];
					}

					$son_id = HelpCategoryModel::whereIn("parent_id" , $son_arr)
									->where("status" ,1)
									->get(['id']);
				}
			}
		
		}
		return $id_arr;
	}
}
