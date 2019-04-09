<?php

namespace App\Admin\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class RechargeFlowModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_recharge_flow';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'recharge_amount','recharge_way','trade_no','voucher','timestamp','money_before','money_after','trade_status','month','tax'];

	
}
