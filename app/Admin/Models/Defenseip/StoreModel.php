<?php

namespace App\Admin\Models\Defenseip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;


class StoreModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_defenseip_store';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['ip', 'status','site','protection_value'];

	public function insert($ip,$protection_value,$site){
		//DB::beginTransaction();
		$fail_arr = [];
		for ($i=0; $i < count($ip); $i++) { 
		
			$ip_arr = [
				'ip'			=> $ip[$i],
				'status'			=> 0,
				'protection_value'	=> $protection_value,
				'site'			=> $site,
			];
			$res = $this->create($ip_arr);
			if($res == false){
				$fail_arr[] = $ip[$i];
			}
		}
		
	}

}
