<?php


namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;


class OverlayBelongModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_overlay_belong'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['overlay_id', 'user_id','buy_time','status','use_time','end_time','order_sn','target_business','price'];


	
}