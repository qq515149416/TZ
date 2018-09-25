<?php

namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class MachineModel extends Model
{
    use SoftDeletes;
    protected $table = 'idc_machine';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['machine_num', 'cpu','harddisk','cabinet','memory','ip_id','machineroom','protect','bandwidth','loginname','loginpass','machine_type','used_status','machine_status','business_type','created_at','updated_at','deleted_at'];

    /**
     * 查找属于对应条件的机器
     * @return [type] [description]
     */
    public function showMachine($where){
    	// 进行条件查询业务类型为1的即租用的所有机器信息
    	$result = $this->where($where)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','own_business','business_end','business_type','machine_note','created_at','updated_at']);
    	// 判断是否查询到数据
    	if(!$result->isEmpty()){
    		// 查询到数据进行某些字段的数据转换
    		$used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
    		$machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
    		$business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
    		$ip_company = [0=>'电信',1=>'移动',2=>'联通'];
    		// 遍历查询到的数据并进行相应的转换
    		foreach($result as $key=>$value){
    			// 状态等的转换
    			$result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
    			$result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
    			$result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
    			//机柜等的对应查询
    			$machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
    			// 进行对应的机柜等信息的转换或者显示
    			if(!empty($machineroom)){
    				$result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
    				//IP信息的返回
    				$result[$key]['ip'] = $machineroom['ip'].'('.$ip_company[$machineroom['ip_company']].')';
                    $result[$key]['ip_company'] = $machineroom['ip_company'];
    				//机房的信息返回
    				$result[$key]['machineroom_name'] = $machineroom['machine_room_name'];
    	       	}
    		}
    		$return['data'] = $result;
    		$return['code'] = 1;
    		$return['msg'] = '获取信息成功！！';
    	} else {
    		$return['data'] = $result;
    		$return['code'] = 0;
    		$return['msg'] = '暂无数据';
    	}

    	return $return;
    }

    /**
     * 选择机器(用于下订单时使用App\Admin\Controllers\Business\OrdersController)
     * @return array 返回对应机房的机器信息
     */
    public function selectMachine($where){
        // 查找对应机房为未使用的机器
        $where['used_status'] = 0;
        // 查找对应机房为上架的机器
        $where['machine_status'] = 0;
        // 进行条件查询业务类型为1的即租用的所有机器信息
        $result = $this->where($where)->get(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note','created_at','updated_at']);
        // 判断是否查询到数据
        if(!$result->isEmpty()){
            // 查询到数据进行某些字段的数据转换
            $used_status = [0=>'未使用',1=>'使用中',2=>'锁定',3=>'迁移'];//使用状态的转换数据
            $machine_status = [0=>'上架',1=>'下架'];//机器上下架的转换数据
            $business_type = [1=>'租用',2=>'托管',3=>'备用'];//业务类型的转换数据
            $ip_company = [0=>'电信',1=>'移动',2=>'联通'];
            // 遍历查询到的数据并进行相应的转换
            foreach($result as $key=>$value){
                // 状态等的转换
                $result[$key]['used'] = $used_status[$value['used_status']];//使用状态的转换
                $result[$key]['status'] = $machine_status[$value['machine_status']];//机器上下架的转换
                $result[$key]['business'] = $business_type[$value['business_type']];//业务类型的转换
                unset($value['business_type']);
                $machineroom = (array)$this->machineroom($value['machineroom'],$value['cabinet'],$value['ip_id']);//机房信息的查询
                // 进行对应的机柜等信息的转换或者显示
                if(!empty($cabinet) && !empty($ip) && !empty($machineroom)){
                    $result[$key]['cabinets'] = $machineroom['cabinet_id'];//机柜信息的返回
                    //IP信息的返回
                    $result[$key]['ip'] = $machineroom['ip'];
                    $result[$key]['ip_detail'] = $machineroom['ip'].'('.$ip_company[$machineroom['ip_company']].')';
                    //机房的信息返回
                    $result[$key]['machineroom_name'] = $machineroom['machine_room_name'];
                }
            }
            $return['data'] = $result;
            $return['code'] = 1;
            $return['msg'] = '获取信息成功！！';
        } else {
            $return['data'] = $result;
            $return['code'] = 0;
            $return['msg'] = '暂无数据';
        }

        return $return;
    }

    /**
     * 对机器信息进行添加处理
     * @param  array $data 要新增的机器信息
     * @return 返回新增的状态和提示信息
     */
    public function insertMachine($data){
    	if($data){
            DB::beginTransaction();//开启事务
            $data['created_at'] = date('Y-m-d H:i:s',time());
    		$row = DB::table('idc_machine')->insertGetId($data);//将新增的机器信息插入数据库
    		if($row != 0){
                // 如果新增机器成功则将机器编号更新到对应的IP库中
                $ip_row = DB::table('idc_ips')->where('id',$data['ip_id'])->update(['mac_num'=>$data['machine_num'],'ip_status'=>2]);
    			if($ip_row != 0){
                    // 如果更新IP库的所属机器编号成功，进行所有数据的提交
                    DB::commit();
                    $return['data'] = $row;
                    $return['code'] = 1;
                    $return['msg'] = '新增机器信息成功！！';
                } else {
                    // 失败则回滚
                    DB::rollBack();
                    $return['data'] = '';
                    $return['code'] = 0;
                    $return['msg'] = '新增机器信息失败！！';
                }
                
    		} else {
                // 失败则回滚
                DB::rollBack();
    			$return['data'] = '';
    			$return['code'] = 0;
    			$return['msg'] = '新增机器信息失败！！';
    		}
    	} else {
    		$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '新增机器信息失败！';
    	}
    	return $return;
    }

    /**
     * 对机器信息进行修改
     * @param  array $editdata 要修改的数据
     * @return array           返回提示信息和状态
     */
    public function editMachine($editdata){
    	if($editdata){
            DB::beginTransaction();//开启事务
            $editdata['updated_at'] = date('Y-m-d H:i:s',time());
    		$row = DB::table('idc_machine')->where('id',$editdata['id'])->update($editdata);
    		if($row != 0){
                // 先将原来所属IP的机器编号字段清除，状态修改
                $original = DB::table('idc_ips')->where('mac_num',$editdata['machine_num'])->update(['mac_num'=>'','ip_status'=>0]);
    			if($original != 0){
                    // 原来的修改成功，将新的IP更新机器编号字段
                    $ip = DB::table('idc_ips')->where('id',$editdata['ip_id'])->update(['mac_num'=>$editdata['machine_num'],'ip_status'=>2]);
                    if($ip != 0){
                        // 都更新成功，进行事务提交
                        DB::commit();
                        $return['code'] = 1;
                        $return['msg'] = '修改信息成功！！';
                    } else {
                        // 新的IP所属机器编号更新失败，事务回滚
                        DB::rollBack();
                        $return['code'] = 0;
                        $return['msg'] = '修改信息失败！！';
                    }
                } else {
                    //原来的IP所属机器编号字段更新失败，事务回滚 
                    DB::rollBack();
                    $return['code'] = 0;
                    $return['msg'] = '修改信息失败！！';
                }
                
    		} else {
                // 更新机器信息失败事务回滚
                DB::rollBack();
    			$return['code'] = 0;
    			$return['msg'] = '修改信息失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '请确保要修改的信息正确！！';
		}
		return $return;
    }

    /**
     * 删除机器信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteMachine($id){
    	if($id){
    		$row = $this->where('id',$id)->delete();
    		if($row != false){
    			$return['code'] = 1;
    			$return['msg'] = '删除机器信息成功！！';
    		} else {
    			$return['code'] = 0;
    			$return['msg'] = '删除机器信息失败！！';
    		}
    	} else {
    		$return['code'] = 0;
    		$return['msg'] = '无法删除机器信息！！';
		}
		return $return;
    }


    /**
     * 机房信息的获取，当是展示机器的时候IP，机柜，机房等信息转换的时候需要传入对应的参数进行查询，如果只是简单获取机房数据（添加，修改时）无须传参，
     * @param  integer $roomid  机房的id
     * @param  integer $cabinet 机柜的id
     * @param  integer $ip      IP表的id
     * @return [type]           [description]
     */
    public function machineroom($roomid = 0,$cabinet = 0,$ip = 0){
    	if($roomid != 0 && $cabinet != 0 && $ip != 0){
    		// 当是IP，机柜，机房等信息转换时对应参数都传入
    		$related = DB::table('idc_machineroom')//机房表
    					->join('idc_cabinet','idc_machineroom.id','=','idc_cabinet.machineroom_id')//关联查询机柜表
    					->join('idc_ips','idc_machineroom.id','=','idc_ips.ip_comproom')//关联查询IP表
    					->where('idc_machineroom.id',$roomid)//机房表的条件
    					->where('idc_cabinet.id',$cabinet)//机柜表的条件
    					->where('idc_ips.id',$ip)//IP的条件
    					->select('idc_machineroom.machine_room_name','idc_cabinet.cabinet_id','idc_ips.ip','idc_ips.ip_company')//所需获得的字段
    					->first();
    		return $related;//返回数据
    	} else {
    		// 当未传入参数时代表简单的查询机房数据
    		$result = DB::table('idc_machineroom')->whereNull('deleted_at')->select('id as roomid','machine_room_id','machine_room_name')->get();
	    	if($result) {
	    		$return['data'] = $result;
	    		$return['code'] = 1;
	    		$return['msg'] = '机房信息获取成功!!';
	    	} else {
	    		$return['data'] = '';
	    		$return['code'] = 0;
	    		$return['msg'] = '机房信息获取失败!!';
	    	}

	    	return $return;
    	}
    }

    /**
     * 对应机房的机柜信息的获取
     * @param   $roomid 机柜的机房字段machineroom_id
     * @return array         返回相关的数据和状态提示信息
     */
    public function cabinets($roomid){
   		if($roomid){
   			$cabinets = DB::table('idc_cabinet')
                            ->where(['machineroom_id'=>$roomid,'use_type'=>0])
   							->whereNull('deleted_at')
   							->select('id as cabinetid','cabinet_id')
   							->get();
   			if($cabinets){
   				$return['data'] = $cabinets;
   				$return['code'] = 1;
   				$return['msg'] = '机柜信息获取成功';
   			} else {
   				$return['data'] = '';
   				$return['code'] = 0;
   				$return['msg'] = '机柜信息获取失败';
   			}
   		} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '机柜信息无法获取';
   		}
   		return $return;
    }

    /**
     * 对应机房的IP信息获取
     * @param  array $data 机房id对应ip_comproom字段，所属运营商对应ip_company字段
     * @return array       返回相关的数据和提示信息及状态
     */
    public function ips($data){
    	if($data){
    		$roomid = $data['roomid'];
    		$company = $data['ip_company'];
    		$ips = DB::table('idc_ips')
    				// ->where('ip_comproom',$roomid)
    				// ->where('ip_company',$company)
                    // ->where('ip_status',0)
                    // ->where('ip_lock',0)
                    ->where(['ip_comproom'=>$roomid,'ip_company'=>$company,'ip_status'=>0,'ip_lock'=>0])
    				->whereNull('deleted_at')
    				->select('id as ipid','ip','ip_company')
                    ->get();
            // dump($ips);
   			if($ips){
   				$return['data'] = $ips;
   				$return['code'] = 1;
   				$return['msg'] = 'IP信息获取成功';
   			} else {
   				$return['data'] = '';
   				$return['code'] = 0;
   				$return['msg'] = 'IP信息获取失败';
   			}
    	} else {
   			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = 'IP信息无法获取';
   		}
   		return $return;
    }

}
