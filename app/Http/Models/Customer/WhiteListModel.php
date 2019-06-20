<?php

namespace App\Http\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use App\Admin\Models\Idc\MachineRoom;
use App\Http\Models\Customer\Order;
use App\Http\Models\Customer\Business;
/**
 * 前台客户有关的白名单的模型
 */
class WhiteListModel extends Model
{
	use  SoftDeletes;
	protected $table = 'tz_white_list';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = [ 'white_number','white_ip','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit','submit_note','check_time','check_note','white_status'];

	//不能开,开了有bug
	// protected $abc = '';

	// public function __construct(){
	// 	$this->abc = Auth::user();
	// }

	/**
	 * 找出对应客户的工单
	 * @param  [type] $white_status [description]
	 * @return [type]               [description]
	 */
	public function showWhiteList($white_status){
		// 当前登陆用户的id
		$user_id = Auth::id();
		$white_status['customer_id'] = $user_id;
		$list = $this->where($white_status)->get(['id','white_number','domain_name','record_number','binding_machine','customer_id','customer_name','submit_id','submit_name','submit_note','check_time','white_status','created_at']);
		if(!$list->isEmpty()){
			$status = [0=>'审核中',1=>'审核通过',2=>'审核不通过',3=>'审核不通过'];
			foreach($list as $list_key => $list_value){
				$list[$list_key]['status'] = $status[$list_value['white_status']];
			}
			$return['data'] = $list;
			$return['code'] = 1;
			$return['msg'] = '获取白名单信息成功';
		} else {
			$return['data'] = $list;
			$return['code'] = 0;
			$return['msg'] = '获取白名单信息失败';
		}

		return $return;
	}

	/**
	 * 白名单信息的提交
	 * @param  array $insert_data 需要提交的白名单相关数据
	 * @return   array            返回相关的状态提示及信息
	 */
	public function insertWhiteList($insert_data){
		if($insert_data){
			$pattern = '/^((http){1}|w{3}|\W)/i';//意思是以  http  | www  |  非单词字符即 a-z A-Z 0-9的字符/

			$res = preg_match($pattern,$insert_data['domain_name'],$match);

			if( $res){
				return [
					'data'	=> [],
					'msg'	=> '域名格式错误,勿填 : http:// ; https ; www ; / ;',
					'code'	=> 0,
				];
			}

			$white_number = create_number();
			$insert_data['white_number'] = $white_number;
			$insert_data['customer_id'] = Auth::id();
			$insert_data['customer_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
			$insert_data['submit_id'] = Auth::id();
			$insert_data['submit_name'] = Auth::user()->name?Auth::user()->name:Auth::user()->email;
			$insert_data['submit'] = 1;
			$insert_data['white_status'] = 0;
			$row = $this->create($insert_data);
			if($row != false){
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '白名单信息提交成功，请耐心等待审核';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '白名单信息提交失败，请确认后重新提交';
			}
		} else {
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '无法提交白名单信息';
		}
		return $return;
	}

	/**
	 * 提交白名单前对该域名进行查询是否提交过
	 * @param  array $domain_name 提交的域名
	 * @return array              返回相关的状态提示及信息
	 */
	public function checkDomainName($domain_name){
		$domain_name['customer_id'] = Auth::user()->id;
		$status = $this->where($domain_name)->select('white_status')->first();
		if(!empty($status) ){
			if ($status->white_status == 0) {
				$return['code'] = 1;
				$return['msg'] = '该域名您已提交过,请勿重复提交';
			}else{
				$return['code'] = 0;
				$return['msg'] = '';
			}
		} else {
			$return['code'] = 0;
			$return['msg'] = '';
		}
		return $return;
	}

	/**
	 * 提交白名单前对客户的IP进行核验
	 * @param  array $white_ip IP地址
	 * @return array           返回核验结果的机器编号和状态提示及信息
	 */
	public function checkIp($white_ip){
		// 根据IP地址查找IP库中对应IP绑定机器编号，业务编号等信息
		$where['ip'] = $white_ip['white_ip'];
		$ip = DB::table('idc_ips')->where($where)->select('ip_status','own_business','mac_num')->first();
		if(!empty($ip)){// 查找到对应的IP相关数据后，根据业务状态和客户id进行查找对应的业务信息
			$business['client_id'] = Auth::user()->id;
			if($ip->ip_status != 0){//IP使用状态为1即子IP时根据业务编号进行查找
				if(isset($ip->own_business) && isset($ip->mac_num)){
					$business['business_number'] = $ip->own_business;
					$business['machine_number'] = $ip->mac_num;
				} elseif(isset($ip->own_business) && !isset($ip->mac_num)){
					$business['business_number'] = $ip->own_business;
				} elseif(!isset($ip->own_business) && isset($ip->mac_num)){
					$business['machine_number'] = $ip->mac_num;
				} else {
					$return['data'] = '';
					$return['code'] = 0;
					$return['msg'] = '您暂未购买此IP使用';
					return $return;
				}

			} else {//IP使用状态为未使用即0时直接返回
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '您暂未购买此IP使用';
				return $return;
			}
			//根据前面的条件进行查找IP绑定的机器编号
			$machine_number = DB::table('tz_business')->where($business)->whereIn('business_status',[0,1,2,3,4])->value('machine_number');
			if($machine_number){//存在机器编号返回机器编号
				$return['data'] = $machine_number;
				$return['code'] = 1;
				$return['msg'] = 'IP绑定的机器获取成功';
			} else {//不存在机器编号时直接返回
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '该IP暂未绑定机器无法';
			}
		} else {//IP库中未找到对应数据时直接返回
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = 'IP地址不存在';
		}
		return $return;
	}

	/**
	 * 取消白名单操作
	 * @param  array $id 对应的id
	 * @return array     返回相关的状态及提示信息
	 */
	public function cancelWhiteList($id){

		$whitelist = $this->find($id);
		if ($whitelist == null || $whitelist->customer_id != Auth::user()->id) {

			return [
				'data'	=> [],
				'msg'	=> '白名单不存在',
				'code'	=> 0,
			];
		}

		if ($whitelist->white_status != 0) {
			return [
				'data'	=> [],
				'msg'	=> '该申请已审核完毕,请勿重复提交',
				'code'	=> 0,
			];
		}


		$whitelist->white_status = 4;
		if (!$whitelist->save()) {
			return [
				'data'	=> [],
				'msg'	=> '取消申请失败',
				'code'	=> 0,
			];
		}
		return [
			'data'	=> [],
			'msg'	=> '取消申请成功',
			'code'	=> 1,
		];
	}

	/**
	 * 高防提交白名单申请
	 * @param  	array
	 * @return 	array     返回提交结果及提示信息
	 */
	public function insertWhiteListForDIP($par){
		//用正则查验下啥开头
		$pattern = '/^((http){1}|w{3}|\W)/i';//意思是以  http  | www  |  非单词字符即 a-z A-Z 0-9的字符/

		$res = preg_match($pattern,$par['domain_name'],$match);
		//不行就踢
		if( $res){
			return [
				'data'	=> [],
				'msg'	=> '域名格式错误,勿填 : http:// ; https ; www ; / ;',
				'code'	=> 0,
			];
		}



		//获取提交的业务编号对应业务信息
		$business = BusinessModel::where('business_number',$par['b_num'])->first();
		if($business == null ){
			return [
				'data'	=> [],
				'msg'	=> '业务不存在',
				'code'	=> 0,
			];
		}
		//不是在用的不给过
		if ($business->status != 1 && $business->status != 4) {
			return [
				'data'	=> [],
				'msg'	=> '业务非上架状态',
				'code'	=> 0,
			];
		}

		//获取高防ip信息
		$d_ip = StoreModel::find($business->ip_id);

		if ($d_ip == null) {
			return [
				'data'	=> [],
				'msg'	=> 'ip信息错误',
				'code'	=> 0,
			];
		}

		//检查之前的提交情况
		$checkWhiteList = $this->where('domain_name',$par['domain_name'])->get();

		if (!$checkWhiteList->isEmpty()) {
			foreach ($checkWhiteList as $k => $v) {

				//如果还是审核中,踢
				if ($v->white_status == 0) {
					return [
						'data'	=> [],
						'msg'	=> '该域名审核申请单正在审核中,请勿重复提交',
						'code'	=> 0,
					];
				}
				//如果已经是这个机房白名单的,踢
				if ($v->white_status == 1 && $v->white_ip == $d_ip->ip) {
					return [
						'data'	=> [],
						'msg'	=> '该域名已在白名单',
						'code'	=> 0,
					];
				}
				//如果是黑名单
				if ($v->white_status == 3) {
					return [
						'data'	=> [],
						'msg'	=> '该域名已被拉黑',
						'code'	=> 0,
					];
				}
			}
		}

		//获取对应的机房信息
		$machineroom = MachineRoom::find($d_ip->site);

		if ($machineroom == null) {
			return [
				'data'	=> [],
				'msg'	=> '机房信息错误',
				'code'	=> 0,
			];
		}
		//判断是否存在白名单接口
		if (!$machineroom->white_list_add|| !$machineroom->white_list_key) {
			return [
				'data'	=> [],
				'msg'	=> '机房未配置白名单',
				'code'	=> 0,
			];
		}

		//拼起来,申请信息
		// $user = $this->abc;
		$user = Auth::user();
		$white_number = create_number();
		$submit = $user->nickname?$user->nickname:$user->email;
		$submit = $submit?$submit:$user->name;

		$insert_data['submit_note']	= isset($par['submit_note'])?$par['submit_note']:'';
		$insert_data['binding_machine']	= '高防业务:'.$par['b_num'];
		$insert_data['record_number']	= $par['record_number'];
		$insert_data['domain_name']	= $par['domain_name'];
		$insert_data['white_ip']		= $d_ip->ip;
		$insert_data['white_number'] 	= $white_number;
		$insert_data['customer_id'] 	= $user->id;
		$insert_data['customer_name'] 	= $submit;
		$insert_data['submit_id'] 	= $user->id;
		$insert_data['submit_name'] 	= $submit;
		$insert_data['submit'] 		= 1;
		$insert_data['white_status'] 	= 0;

		$res = $this->create($insert_data);
		if ($res) {
			return [
				'data'	=> [],
				'msg'	=> '提交申请成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '提交申请失败',
				'code'	=> 0,
			];
		}
	}


	/**
	 *获取用户所有正在使用的业务里的IP
	 * @param  array $id 对应的id
	 * @return array     返回用户所有正在使用的业务里的IP
	 */
	public function getAllIP(){
		$ips = [];
		//获取用户信息
		$user = Auth::user();
		//获取用户订单内的使用中ip
		$orders = Order::where('customer_id' , $user->id)		//指定用户
				->leftJoin('tz_business as b','b.business_number','=','tz_orders.business_sn')
				->where('tz_orders.resource_type',4)		//类型为ip
				->where('b.remove_status' , 0)			//未下架
				->where('tz_orders.remove_status',0)		//未下架
				->whereIn('tz_orders.order_status',[0,1,2])	//订单正在使用
				->whereIn('b.business_status',[1,2])		//正在使用
				->get(['tz_orders.machine_sn as ip' , 'b.machine_number as m_num']);
		//怼到ips数组里去
		if (!$orders->isEmpty()) {
			foreach ($orders as $k => $v) {
				$ips[] = [
					'white_ip'		=> $v->ip,
					'description'		=> $v->m_num.' 编号机器的子IP',
					'binding_machine'	=> $v->m_num,
				];
			}
		}

		//获取用户业务里的主机ip,从使用中业务处找
		$business = Business::where('client_id' , $user->id)			//指定用户machine_number
					->leftJoin('idc_machine as b','b.machine_num','=','tz_business.machine_number')
					->leftJoin('idc_ips as c' , 'c.id' , '=' , 'b.ip_id')
					->whereIn('tz_business.business_type' , [1,2])	//业务类型为主机的
					->whereNull('b.deleted_at')
					->where('tz_business.remove_status' , 0)		//未下架
					->whereIn('tz_business.business_status' , [1,2])	//正在使用
					->get(['c.ip' ,'b.machine_num as m_num']);

		if (!$business->isEmpty()) {
			foreach ($business as $k => $v) {
				$ips[] = [
					'white_ip'		=> $v->ip,
					'description'		=> $v->m_num.' 编号机器的主IP',
					'binding_machine'	=> $v->m_num,
				];
			}
		}

		//获取用户高防业务里的IP
		$d_ip = BusinessModel::where('user_id' , $user->id)		//指定用户
					->leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
					->whereIn('tz_defenseip_business.status' , [1,4])		//正在使用
					->get(['b.ip' , 'tz_defenseip_business.business_number as b_num']);
		if(!$d_ip->isEmpty()){
			foreach ($d_ip as $k => $v) {
				$ips[] = [
					'white_ip'		=> $v->ip,
					'description'		=> '业务编号为 : '.$v->b_num.' 的高防IP',
					'binding_machine'	=> $v->b_num,
				];
			}
		}
		if(count($ips) > 0){
			return [
				'data'	=> $ips,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '无使用中IP',
				'code'	=> 1,
			];
		}
	}

}
