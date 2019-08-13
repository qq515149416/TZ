<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReasonModel extends Model
{
    use SoftDeletes;
	protected $table = 'tz_reason';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
}
