<?php

// +----------------------------------------------------------------------
// | Author: kiri<420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 机器统计表的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-20 17:02:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class  MachineStatistics extends Model
{
   use SoftDeletes;
   
	protected $table = 'idc_machine_statistics';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['room_id', 'rent_inuse','rent_on_free','rent_off_free','tru_inuse','tru_on_free','tru_off_free','total','month'];

	/**
	* 统计机器的方法
	* @return 将数据及相关的信息返回到控制器
	*/

	public function statistics()
	{	
		//生成区分月份的字段
		$time = date("y-m");	

		//获取所有机房数据
		$machineroom = $this->getMachineRoom();
		//获取所有机器数据
		$machine = $this->getMachine();

		if($machineroom == false||$machine == false){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '数据更新失败!!';
			return $return;
		}

		//处理数据

		//生成各个机房的空数组
		$data = [];
		for($i = 0;$i < count($machineroom);$i++){
			$data[$machineroom[$i]['roomid']]['room_id'] 		= $machineroom[$i]['roomid'];
			$data[$machineroom[$i]['roomid']]['rent_inuse']		= 0;
			$data[$machineroom[$i]['roomid']]['rent_on_free']	= 0;
			$data[$machineroom[$i]['roomid']]['rent_off_free']	= 0;
			$data[$machineroom[$i]['roomid']]['tru_inuse']		= 0;
			$data[$machineroom[$i]['roomid']]['tru_on_free']		= 0;
			$data[$machineroom[$i]['roomid']]['tru_off_free']		= 0;
			$data[$machineroom[$i]['roomid']]['total']		= 0;
			$data[$machineroom[$i]['roomid']]['month']		= $time;
		}
		$data['total']=[
			'room_id'	=> 0,
			'rent_inuse'	=> 0,
			'rent_on_free'	=> 0,
			'rent_off_free'	=> 0,
			'tru_inuse'	=> 0,
			'tru_on_free'	=> 0,
			'tru_off_free'	=> 0,
			'total'		=> 0,
			'month'		=> $time,
		];

		//开始统计数据
		for($j = 0;$j < count($machine);$j++){
			$data[$machine[$j]['machineroom']]['total']++;
			$data['total']['total']++;
			if($machine[$j]['business_type'] == 1){
				if($machine[$j]['used_status'] == 1){
					$data[$machine[$j]['machineroom']]['rent_inuse']++;
					$data['total']['rent_inuse']++;
				}else{
					if($machine[$j]['machine_status'] == 0){
						$data[$machine[$j]['machineroom']]['rent_on_free']++;	
						$data['total']['rent_on_free']++;
					}else{
						$data[$machine[$j]['machineroom']]['rent_off_free']++;
						$data['total']['rent_off_free']++;	
					}
				}
			}else{
				if($machine[$j]['used_status'] == 1){
					$data[$machine[$j]['machineroom']]['tru_inuse']++;
					$data['total']['tru_inuse']++;
				}else{
					if($machine[$j]['machine_status'] == 0){
						$data[$machine[$j]['machineroom']]['tru_on_free']++;
						$data['total']['tru_on_free']++;	
					}else{
						$data[$machine[$j]['machineroom']]['tru_off_free']++;
						$data['total']['tru_off_free']++;	
					}
				}
			}
		}

		$res = $this->insert($data);
		if($res == false){
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '数据更新失败!!';
		}else{
			$return['data'] = '';
			$return['code'] = 1;
			$return['msg'] = '数据更新成功!!';
		}

		return $return;
	}

	//获取所有机房数据的方法
	public function getMachineRoom()
	{
		$machineroom = DB::table('idc_machineroom')->select('id as roomid','machine_room_name')->get();
		$machineroom = json_decode(json_encode($machineroom),true);
		return $machineroom;
	}
	//获取所有机器的方法
	public function getMachine()
	{
		$machine = DB::table('idc_machine')->select('used_status','machine_status','business_type','machineroom')->get();
		$machine = json_decode(json_encode($machine),true);
		return $machine;
	}

	//插入统计数据的方法
	//	$data[
	//		'key' => ['room_id' => ?? , 'rent_inuse' => ?? , .....]
	//	]
	public function insert($data)
	{
		foreach($data as $key => $value){

			$res = $this->updateOrCreate(
				[
					'room_id' 	=> $value['room_id'],
					'month'		=> $value['month'],
				],

				[
					'rent_inuse' 	=> $value['rent_inuse'] , 
					'rent_on_free' 	=> $value['rent_on_free'] , 
					'rent_off_free' 	=> $value['rent_off_free'] , 
					'tru_inuse' 	=> $value['tru_inuse'] , 
					'tru_on_free' 	=> $value['tru_on_free'] , 
					'tru_off_free' 	=> $value['tru_off_free'] , 
					'total'		=> $value['total'],
					'month'		=> $value['month'],
				]);
			if($res == false){			
				return false;
			}		
		}
		return true;
	}


	/**
	* 查询统计表的数据
	* @param  $month : 需要查询的月份
	* @return 将该月数据及相关的信息返回到控制器
	*/
	public function getStatistics($month){
		// 用模型进行数据查询
		$index = $this->where("month",$month)->get();

		if(!$index->isEmpty()){
		// 判断存在数据就对部分需要转换的数据进行数据转换的操作
		
			$room = json_decode(json_encode($this->getMachineRoom() ),true);
			$room_arr = [];
			foreach ($room as $k=> $v) {
				$room_arr[$v['roomid']] = $v['machine_room_name'];
			}
			$room_arr[0] = '合计';

			foreach($index as $key=>$value) {
			// 对应的字段的数据转换
				$index[$key]['room_name'] 	= $room_arr[$value['room_id']];				
			}
			$index = json_decode(json_encode($index),true);
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = $index;
			$return['code'] = 0;
			$return['msg'] = '暂无数据';
		}

		// 返回
		return $return;
	}


	
  	
}
