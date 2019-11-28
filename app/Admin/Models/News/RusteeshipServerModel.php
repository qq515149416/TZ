<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\MachineRoomModel;

class RusteeshipServerModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_rusteeship_server';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
    /**
     * 获取机房信息.
     *
     * @param  string  $value
     * @return Model
     */
    public function getMachineRoomIdAttribute($value)
    {
        return MachineRoomModel::where("id",$value)->first();
    }
    /**
     * 获取导航信息.
     *
     * @param  string  $value
     * @return Model
     */
    public function getNavIdAttribute($value)
    {
        return collect(NavModel::where("id",$value)->first())->except(["parent_id"]);
    }
}
