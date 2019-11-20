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
    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'more' => 'json',
    ];
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
    public function setThumbnailsAttribute($thumbnails)
    {
        if (is_array($thumbnails)) {
            $this->attributes['thumbnails'] = json_encode($thumbnails);
        }
    }

    public function getThumbnailsAttribute($thumbnails)
    {
        return json_decode($thumbnails, true);
    }

    public function getMoreAttribute($more)
    {
        if (is_array($more)) {
            return json_encode($more);
        }
        return $more;
    }
    /**
     * 导航关联.
     */
    public function navs()
    {
        return $this->belongsToMany(NavModel::class,'tz_machine_room_nav','machine_room_id','nav_id');
    }
}
