<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class NavModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_nav';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'description', 'url','seo_title','seo_keywords','seo_description','type','status','parent_id'];

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
}
