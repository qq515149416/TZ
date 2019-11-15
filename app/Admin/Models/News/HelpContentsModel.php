<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\News\HelpCategoryModel;


class HelpContentsModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_help_contents';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $dates = ['deleted_at'];
    /**
     * 获取所属分类信息.
     *
     * @param  string  $value
     * @return Model
     */
    public function getCategoryIdAttribute($value)
    {
        if($value) {
            $helpCategoryModel = new HelpCategoryModel();
            // dd($helpCategoryModel->where("id",$value)->first()->toArray());
            return collect($helpCategoryModel->where("id",$value)->first())->except(["parent_id"]);
        }
    }
}
