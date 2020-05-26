<?php


namespace App\Admin\Models\Waf;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;


class WafDomainModel extends Model
{


	protected $table = 'tz_waf_domain'; //表
	protected $primaryKey = 'id'; //主键
	
	protected $fillable = ['domain_name', 'business_id'];


}