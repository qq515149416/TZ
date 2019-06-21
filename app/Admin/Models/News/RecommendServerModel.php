<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Admin\Models\News\NavModel;
use App\Admin\Models\News\MachineRoomModel;

class RecommendServerModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_recommend_server';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
}
