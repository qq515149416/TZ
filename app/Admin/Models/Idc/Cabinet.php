<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cabinet extends Model
{
	//引入软删除
	use SoftDeletes;

	//表名
	protected $table = 'idc_cabinet';

	//设置主键
	public $primaryKey = 'id';

	//设置软删除字段
	protected $dates = ['delete_at'];

	//设置填充字段
	protected $fillable = ['machineroom_id','cabinet_id','use_type','note','machine_count','use_state','images','add_time','update_time'];

	/**
	 * 测试方法
	 */
	public function test()
	{

		$data = $this->all();

		return $data;

	}


	/**
	 * 存储数据
	 */

	public function edit($data){
		if($data && $data['id']+0) {
			$id = $data['id'];
			unset($data['id']);
			
			$row = self::where('id', $id)->update($data);

			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '修改机柜信息成功！！';

			} else {
				$return['code']	= 0;
				$return['msg'] 	= '修改机柜信息失败！！';

			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '请确保信息正确';
		}
		return $return;
	}

}