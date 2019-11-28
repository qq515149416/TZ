<?php


namespace App\Admin\Models\Idc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Admin\Models\DefenseIp\StoreModel;

class Ips extends Model
{
	use SoftDeletes;
	protected $table = 'idc_ips';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	/**
	* 可以被批量赋值的属性.
	*
	* @var array
	*/
	protected $fillable = ['vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom','created_at','updated_at','deleted_at'];
	// 测试
	public function test() {
		return 'ip 测试';
	}

	/**
	 * 查询IP表的数据
	 * @return 将数据及相关的信息返回到控制器
	 */
	public function index(){
		// 用模型进行数据查询
		$index = $this->all();
		// $index = $this->paginate(15);
		if(!$index->isEmpty()){
			// 判断存在数据就对部分需要转换的数据进行数据转换的操作
			$ip_company = [0=>'电信公司',1=>'移动公司',2=>'联通公司',3=>'BGP'];
			$ip_status = [0=>'未使用',1=>'使用中',2=>'使用(内部机器主IP)',3=>'使用(托管主机的主IP)',4=>'使用(高防业务)'];
			$ip_lock = [0=>'未锁定',1=>'锁定'];

			foreach($index as $ipkey=>$ipvalue) {
				// 对应的字段的数据转换
				$room = (array)$this->machineroom($ipvalue['ip_comproom']);
				$index[$ipkey]['ip_company'] = $ip_company[$ipvalue['ip_company']];
				$index[$ipkey]['ip_status'] = $ip_status[$ipvalue['ip_status']];
				$index[$ipkey]['ip_lock'] = $ip_lock[$ipvalue['ip_lock']];
				$index[$ipkey]['ziyuan'] = 4;
				if(!empty($room)){
					$index[$ipkey]['ip_comproomname'] = $room['machine_room_name'];
					$index[$ipkey]['ip_roomno'] = $room['machine_room_id'];
				}

            }
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '暂无数据';
		}
		// 返回
		return $return;
	}

	/**
	 * 对IP地址进行添加处理
	 * @param  array $data 要添加的数据
	 * @return array      返回的信息和状态
	 */
	public function insertIps($data){
		if(!$data){
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
			return $return;
		}
		// 起始的IP
		$ip_start = $data['ip_start'];
		// 结束的IP
		$ip_end = $data['ip_end'];
		if(empty($ip_end)){
			// 结束IP的第一组的为空则代表进行一条IP插入
			$data['ip'] = $ip_start;
			// unset($ip_start);
			$row = $this->create($data);
			if($row != false){
				// 插入数据成功
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '新增IP地址信息成功!!';

			} else {
				// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '新增IP地址信息失败!!';
			}
		} else {
			//截取开始时的IP段(如:192.168.1)
			$startstr = substr($ip_start,0,strrpos($ip_start,'.'));
			//截取结束时的IP段(如:192.168.1)
			$endstr = substr($ip_end,0,strrpos($ip_end,'.'));
			//批量插入IP
			if($startstr != $endstr){
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = 'IP段需要一致才可以批量(如:192.168.1.1,192.168.1.25)';
			} else {
				// 起始的数字
				$start = ltrim(strrchr($ip_start,'.'),'.');;
				// 结束的数字
				$end = ltrim(strrchr($ip_end,'.'),'.');;
				// 进行循环插入IP
				while($start<=$end){
					$data['ip'] = $endstr.'.'.$start;
					$row = $this->create($data);
					$start++;
				}
				if($row != false){
					// 插入数据成功
					$return['data'] = '';
					$return['code'] = 2;
					$return['msg'] = '批量新增IP地址信息成功!!';
				} else {
					// 插入数据失败
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '新增IP地址信息失败!!';
				}
			}

		}
		return $return;
	}

	/**
	 * 查找对应的IP数据
	 * @param  int $id 查找IP的id条件
	 * @return array     返回相关的数据和信息提示
	 */
	public function edit($id){
		if($id){
			$result = $this->where('id',$ids)->get(['vlan', 'ip','ip_company','ip_status','ip_lock','ip_note','ip_comproom']);
			if($result){
			   $return['data'] = $result;
			   $return['code'] = 1;
			   $return['msg'] = '获取信息成功！！';
			} else {
				$return['data'] = $result;
				$return['code'] = 0;
				$return['msg'] = '无法获取到信息！！';
		   }
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法获取到对应的信息！！';
		}

		return $return;
	}

	/**
	 * 对要修改的信息进行处理
	 * @param  array $data 要修改的数据
	 * @return array       返回信息和状态
	 */
	public function doEdit($data){
		if($data) {
			$edit = $this->select("vlan","ip","ip_company","ip_status","ip_lock","ip_note","ip_comproom")->find($data['id']);
			if(empty($edit)){
                $return['code'] = 0;
                $return['msg'] = '(#101)无此IP';
                return $return;
            }
            DB::beginTransaction();
            if($edit->ip_status == $data['ip_status'] && $data['ip_status'] != 0){//当ip的状态不是未使用的时候，且状态与数据表里的状态一致
            	if($edit->ip_note != $data['ip_note']){//当备注不一样的时候进行修改
            		$row = DB::table('idc_ips')->where(['id'=>$data['id']])->update(['ip_note'=>$data['ip_note']]);
            	} else {
            		$row = 1;
            	}
            	if($row == 0){
            		DB::rollBack();
            		$return['code'] = 0;
					$return['msg'] = '(#102)修改信息失败';
            	}
            } else{//当IP状态是所有的状态时，且传递的状态与数据表里的状态不一致时
            	if($edit->ip_status != 0){//判断IP状态是否为0，不为0则代表IP在使用，不给予修改
		        	$return['code'] = 0;
					$return['msg'] = '(#103)此IP正在,无法进行修改';
					return $return;
            	}
            	if($edit->ip_comproom != $data['ip_comproom']){//当修改IP所在机房时
            		$defense = DB::table('tz_defenseip_store')->where(['ip'=>$edit->ip])->whereNull('deleted_at')->select('id')->first();
            		if(!empty($defense)){//当高防库里存在此IP信息时进行机房的修改
            			$result = DB::table('tz_defenseip_store')->where(['id'=>$defense->id])->update(['site'=>$data['ip_comproom']]);
            			if($result == 0){
            				DB::rollBack();
            				$return['code'] = 0;
							$return['msg'] = '(#104)此IP信息修改失败';
							return $return;
            			}
            		}
            	}
            	/**
            	 * 当机房不修改时，执行正常的修改流程
            	 * @var [type]
            	 */
            	$row = DB::table('idc_ips')->where(['id'=>$data['id']])->update($data);
            	if($row == 0){
            		DB::rollBack();
    				$return['code'] = 0;
					$return['msg'] = '(#105)此IP信息修改失败';
					return $return;
            	}
            }
            /**
             * 当所有的事件都成功时进行修改数据的事务提交
             */
            DB::commit();
            $return['code'] = 1;
			$return['msg'] = 'IP信息修改成功';
		} else {
			$return['code'] = 0;
			$return['msg'] = '(#106)确保信息正确';
		}
		return $return;
	}

	/**
	 * 删除IP信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function dele($id) {
		if($id) {
						 $check = $this->checkDel($id);
						if($check['code'] != 1){
							return $check;
						}
			$row = $this->where('id',$id)->delete();
			if($row != false){
				$return['code'] = 1;
				$return['msg'] = '删除IP信息成功';
			} else {
				$return['code'] = 0;
				$return['msg'] = '删除IP信息失败';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '无法删除IP信息';
		}

		return $return;
	}

	/**
	* 检查是否可编辑
	*/
	protected function checkDel($id){

		$mod = $this->find($id);
		if($mod == null){
			return [
				'code'  => 0,
				'msg'   => '无此id',
			];
		}
		if ($mod->ip_lock != 0) {
			return [
				'code'  => 3,
				'msg'   => 'ip锁定中,无法删除',
			];
		}
		if($mod->ip_status != 0){
			return [
				'code'  => 2,
				'msg'   => 'ip正在使用,无法删除或编辑',
			];
		}else{
			return [
				'code'  =>1,
			];
		}
	}
	/**
	 * 获取机房的信息
	 * @return array 返回相关的信息和数据
	 */
	public function machineroom($id = 0) {
		if($id != 0){
			// echo $id;
			$room = DB::table('idc_machineroom')->find($id,['machine_room_id','machine_room_name']);
			// echo 123;
			return $room;
		} else {
			// echo 456;
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
	 * 客户增加IP资源
	 * @param  int $machineroom 机房的id
	 * @return array              返回所有符合的IP资源
	 */
	public function selectIps($machineroom,$company){
		$where['ip_comproom'] = $machineroom;
		$where['ip_company'] = $company;
		$where['ip_status'] = 0;
		$where['ip_lock'] = 0;
		$ips = $this->where($where)->get(['ip','id','ip_company','ip_comproom']);
		if(!$ips->isEmpty()){
			$ip_company = [0=>'电信公司',1=>'移动公司',2=>'联通公司',3=>'BGP'];
			foreach($ips as $key=>$value){
				$ips[$key]['label'] = $value['ip'];
				$ips[$key]['value'] = $value['ip'].$ip_company[$value['ip_company']];
				$ips[$key]['room_id'] = $value['ip_comproom'];
				$ips[$key]['machineroom'] = $this->machineroom($value['ip_comproom'])->machine_room_name;
				unset($ips[$key]['ip']);
				unset($ips[$key]['ip_comproom']);
			}
			return $ips;
		} else {
			return [];
		}

	}


}
