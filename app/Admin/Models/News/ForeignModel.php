<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\MachineRoomModel;

class ForeignModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_foreign_server';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $casts = [
        'more' => 'json',
    ];
    /**
     * 获取机房信息.
     *
     * @param  string  $value
     * @return Model
     */
    public function getMachineRoomIdAttribute($value)
    {
        // dd(MachineRoomModel::where("id",$value)->first()->toArray());
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
        // dd(NavModel::where("id",$value)->first()->toArray());
        return collect(NavModel::where("id",$value)->first()->toArray())->except(["parent_id"]);
    }
}
