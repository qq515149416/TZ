<?php

namespace App\Http\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PackageModel extends Model
{
	use SoftDeletes;

	protected $table = 'tz_defenseip_package'; //表
	protected $primaryKey = 'id'; //主键
	protected $dates = ['deleted_at']; //删除时间

	/**
	 *
	 */
	public function showPackage(){
		$list = $this->where('sell_status',1)->get()->toArray();

		if(count($list) == 0){
			return [
				'data'	=> '',
				'msg'	=> '无数据',
				'code'	=> 1,
			]; 
		}

		for ($i=0; $i < count($list); $i++) { 
			$list[$i]['site'] = DB::table('idc_machineroom')->where('id',$list[$i]['site'])->value('machine_room_name');
			if($list[$i]['site'] == null){
				$list[$i]['site'] = '无此机房';
			}
		}
		return [
			'data'	=> $list,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}


   
	/**
	 *
	 */
//    public function

}
