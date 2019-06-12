<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class LinksModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_links';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'url','sort','image','description','user','links_order'];
}
