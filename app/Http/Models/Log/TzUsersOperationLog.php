<?php

/**
 *
 */
namespace App\Http\Models\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class  TzUsersOperationLog extends Model
{

    protected $table = 'tz_users_operation_log'; //表

    protected $primaryKey = 'id'; //主键



}