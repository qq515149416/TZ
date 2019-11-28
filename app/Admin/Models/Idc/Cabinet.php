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

	/**
	 * 后台业务给客户下单时选择机柜
	 * @param  array $where [description]
	 * @return array       返回相关的机柜信息
	 */
	public function selectCabinet($where){
		if($where){
			$where['machineroom_id'] = $where['machineroom'];
			unset($where['machineroom']);
			$where['use_type'] = 1;
			$data = $this->where($where)->get(['id','cabinet_id','machineroom_id']);
			if(!$data->isEmpty()){
				foreach($data as $key=>$value){
					$data[$key]['machineroom_name'] = $this->machineroom($value['machineroom_id']);
				}
				$return['data'] = $data;
				$return['code'] = 1;
				$return['msg'] = '机柜获取成功';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '机柜获取失败';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '机柜无法获取';
		}
		return $return;
	}

	/**
	 * 转换机柜所在的机房数据
	 * @param  int $id 机房表的id
	 * @return string     返回机房的中文名
	 */
	public function machineroom($id){
		$machineroom = DB::table('idc_machineroom')->where('id',$id)->value('machine_room_name');
		return $machineroom;
	}

}