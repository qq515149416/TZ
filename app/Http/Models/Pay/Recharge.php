<?php

/**
 *
 */
namespace App\Http\Models\Pay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Recharge extends Model
{

	protected $table = 'tz_recharge_flow'; //表

	protected $primaryKey = 'id'; //主键



}