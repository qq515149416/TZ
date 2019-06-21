<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\News\NavModel;
use Illuminate\Database\Eloquent\Builder;

class MachineRoomModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_machine_room';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	// protected $fillable = ['name', 'nav_id', 'overview','grade','detail_url','customer_representative','status'];
    /**
     *模型的「启动」方法.
     *
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('status', function (Builder $builder) {
    //         $builder->where('status', 1);
    //     });
    // }
    /**
     * 导航关联.
     */
    public function navs()
    {
        return $this->belongsToMany(NavModel::class,'tz_machine_room_nav','machine_room_id','nav_id');
    }
}
