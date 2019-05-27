<?php


namespace App\Admin\Models\DefenseIp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Admin\Models\DefenseIp\OrderModel; //后台高防ip的订单模型
use App\Admin\Models\Business\OrdersModel; //后台的订单支付模型
use App\Admin\Models\DefenseIp\BusinessModel;

use App\Admin\Models\DefenseIp\OverlayBelongModel; //后台的订单支付模型
use Carbon\Carbon;
use App\Http\Controllers\DefenseIp\ApiController;

class OverlayModel extends Model
{

	use SoftDeletes;
	

	protected $table = 'tz_overlay'; //表
	protected $primaryKey = 'id'; //主键
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['name', 'description','site','protection_value','price','validity_period','sell_status'];
	protected $time_limit = 60;//两次购买的时间限制

	/**
	 *
	 */
	public function insert($par){
		return $this->create($par);
	}
	
	public function del($del_id){
		$overlay = $this->find($del_id);
		if($overlay == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$del_res = $overlay->delete();
		if($del_res){
			return [
				'data'	=> [],
				'msg'	=> '删除成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '删除失败',
				'code'	=> 0,
			];
		}
	}

	public function edit($par){
		$overlay = $this->find($par['edit_id']);
		if($overlay == null){
			return [
				'data'	=> [],
				'msg'	=> '不存在',
				'code'	=> 0,
			];
		}
		$edit_res = $overlay->update($par);

		if($edit_res){
			return [
				'data'	=> [],
				'msg'	=> '编辑成功',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '编辑失败',
				'code'	=> 0,
			];
		}
	}

	public function show($par){
		if($par['site'] == '*'){
			if ($par['sell_status'] == '*') {
				$overlay = $this->get();
			}else{
				$overlay = $this->where('sell_status',$par['sell_status'])->get();
			}
			
		}else{
			if ($par['sell_status'] == '*') {
				$overlay = $this->where('site',$par['site'])->get();
			}else{
				$overlay = $this->where('site',$par['site'])->where('sell_status',$par['sell_status'])->get();
			}
		}
		
		if($overlay->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无此机房叠加包',
				'code'	=> 1,
			];
		}else{
			foreach ($overlay as $k => $v) {
				$v = $this->trans($v);
			}
			return [
				'data'	=> $overlay,
				'msg'	=> '获取成功',
				'code'	=> 1,
			];
		}
	}

	public function trans($overlay){
		switch ($overlay->sell_status) {
			case '0':
				$overlay->sell_status = '下架中';
				break;
			case '1':
				$overlay->sell_status = '上架中';
				break;
			default:
				$overlay->sell_status = '未知状态';
				break;
		}
		$overlay->machine_room_name = DB::table('idc_machineroom')->where('id',$overlay->site)->value('machine_room_name');
		return $overlay;
	}

	protected function checkAdminUser($customer_id){
		$admin_user_id 	= Admin::user()->id;
		$customer = DB::table('tz_users')->where('id',$customer_id)->first();
		if ($customer == null) {
			return [
				'data'	=> [],
				'msg'	=> '客户信息获取失败',
				'code'	=> 0,
			];
		}
		if($admin_user_id != $customer->salesman_id)
		{
			return [
				'data'	=> [],
				'msg'	=> '该客户不属于您',
				'code'	=> 0,
			];
		}
		return [
			'data'	=> $customer,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	public function buyNowByAdmin($par){
		$admin_user_id 	= Admin::user()->id;
		$checkAdminUser = $this->checkAdminUser($par['user_id']);
		if ($checkAdminUser['code'] != 1) {
			return $checkAdminUser;
		}else{
			$customer = $checkAdminUser['data'];
			if ($customer->name == null) {
				$customer->name = $customer->email;
			}
		}
		$pay_model = new OrdersModel();

		$check_time_limit = $pay_model->where('customer_id',$par['user_id'])->max('created_at');
		
		if ($check_time_limit != null) {
			$check_time = strtotime($check_time_limit);
			if (bcsub(time(),$check_time,0) < $this->time_limit) {
				return [
					'data'	=> [],
					'msg'	=> $this->time_limit .'秒内只能创建一次订单',
					'code'	=> 0,
				];
			}
		}

		DB::beginTransaction();

		$overlay = $this->find($par['overlay_id']);
		if($overlay == null){
			return [
				'data'	=> [],
				'msg'	=> '叠加包信息获取失败',
				'code'	=> 0,
			];
		}
		if ($overlay->sell_status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '该叠加包未上架',
				'code'	=> 0,
			];
		}

		$order_model = new OrderModel();
		//检测有没有填写自定义价格,没有的话就用默认的原价,有的话就按自定义的付款
		if (!isset($par['price'])) {
			$par['price'] = $overlay->price;
		}
		
		$order = [
			'order_sn'		=> 'DJB_'.time().'_admin_'.$admin_user_id,
			'business_sn'		=> '叠加包',
			'customer_id'		=> $par['user_id'],
			'customer_name'	=> $customer->name,
			'business_id'		=> $admin_user_id,
			'business_name'	=> DB::table('admin_users')->where('id',$admin_user_id)->value('name'),
			'resource_type'		=> 12,
			'order_type'		=> 1,
			'machine_sn'		=> $par['overlay_id'],
			'resource'		=> $overlay->name,
			'price'			=> $par['price'],
			'duration'		=> $par['buy_num'],
			'payable_money'	=> bcmul($par['price'], $par['buy_num'],2),
			'order_status'		=> 0,
		];
		$make_order = $order_model->create($order);
		if(!$make_order){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '订单创建失败',
				'code'	=> 0,
			];
		}

		
		$pay_res = $pay_model->payOrderByBalance([$make_order->id],0);

		if($pay_res['code'] != 1){
			DB::rollBack();
			return $pay_res;
		}
		
		DB::commit();
		return [
			'data'	=> [],
			'msg'	=> '购买成功',
			'code'	=> 1,
		];
	}

	public function showBelong($par){
		$belong_model = new OverlayBelongModel();
		switch ($par['status']) {
			case '*':
				$overlay = $belong_model
					->where('tz_overlay_belong.user_id',$par['user_id'])
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			case '1':
				$overlay = $belong_model
					->where('tz_overlay_belong.status',1)
					->where('tz_overlay_belong.user_id',$par['user_id'])
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			case '0':
				$overlay = $belong_model
					->where('tz_overlay_belong.status',0)
					->where('tz_overlay_belong.user_id',$par['user_id'])
					->leftJoin('tz_overlay as b','b.id', '=' , 'tz_overlay_belong.overlay_id')
					->select(['tz_overlay_belong.*','b.name','b.protection_value','b.validity_period'])
					->get();
				break;
			default:
				return [
					'data'	=> [],
					'msg'	=> '无此状态',
					'code'	=> 0,
				];
				break;
		}
		if($overlay->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '无叠加包',
				'code'	=> 0,
			];
		}
		foreach ($overlay as $k => $v) {
			$v = $this->transBelong($v);
		}
		
		return [
			'data'	=> $overlay,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	protected function transBelong($overlay){
		switch ($overlay->status) {
			case '2':
				$overlay->status = '已使用完毕';
				break;
			case '1':
				$overlay->status = '生效中';
				break;
			case '0':
				$overlay->status = '未使用';
				break;
			default:
				$overlay->status = '未知状态';
				break;
		}
		return $overlay;
	}

	public function useOverlayToDIP($par){
		//获取业务信息
		$business_model = new BusinessModel();
		$business = $business_model->where('business_number',$par['business_number'])->first();
		if($business == null){
			return [
				'data'	=> [],
				'msg'	=> '获取业务信息失败',
				'code'	=> 0,
			];
		}
		if ($business->status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '正式使用中业务才能使用叠加包',
				'code'	=> 0,
			];
		}
		//获取叠加包归属信息
		$belong = OverlayBelongModel::find($par['belong_id']);
		if ($belong == null) {
			return [
				'data'	=> [],
				'msg'	=> '获取叠加包信息失败',
				'code'	=> 0,
			];
		}
		if ($belong->status != 0) {
			return [
				'data'	=> [],
				'msg'	=> '该叠加包已使用',
				'code'	=> 0,
			];
		}
		if($belong->user_id != $business->user_id){
			return [
				'data'	=> [],
				'msg'	=> '叠加包只能给自身业务使用',
				'code'	=> 0,
			];
		}

		//判断是否所属客户
		$checkAdminUser = $this->checkAdminUser($belong->user_id);
		if($checkAdminUser['code'] != 1){
			return $checkAdminUser;
		}

		//获取高防ip业务所在机房
		$d_ip = DB::table('tz_defenseip_store')->whereNull('deleted_at')->where('id',$business->ip_id)->first();
		if ($d_ip == null) {
			return [
				'data'	=> [],
				'msg'	=> '高防ip信息获取失败',
				'code'	=> 0,
			];
		}
		$d_ip_site = $d_ip->site;
		
		//获取叠加包信息
		$overlay = $this->withTrashed()->find($belong->overlay_id);
		if($overlay->site != $d_ip_site){
			return [
				'data'	=> [],
				'msg'	=> '叠加包与业务机房不匹配',
				'code'	=> 0,
			];
		}

		// $now = date("Y-m-d H:i:s");
		//现在的时间戳
		$now 		= time();
		//计算使用时长,  有效天数 X 24小时 X 3600秒
		$use_time 	= $overlay->validity_period*24*3600;
		//结束的时间
		$end_time 	= bcadd($now, $use_time,0);

		$belong_update_info = [
			'status'			=> 1,
			'use_time'		=> date("Y-m-d H:i:s",$now),
			'target_business'	=> $par['business_number'],
			'end_time'		=> date("Y-m-d H:i:s",$end_time),
		];
		DB::beginTransaction();

		$belong_update_res = $belong->update($belong_update_info);

		if(!$belong_update_res){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新叠加包状态失败',
				'code'	=> 0,
			];
		}

		//计算额外的叠加包流量峰值
		$after_extra_protection = bcadd($business->extra_protection, $overlay->protection_value,0);
		//计算业务该有的流量峰值
		
		$after_protection = bcadd($d_ip->protection_value, $after_extra_protection,0);
		
		$business_update_info = [
			'extra_protection'	=> $after_extra_protection,
		];
		$business_update_res = $business->update($business_update_info);

		if(!$business_update_res){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新业务额外防御峰值失败',
				'code'	=> 0,
			];
		}

		$api_model = new ApiController();

		//记得正式上线换回来
		$set_res = $api_model->setProtectionValue($d_ip->ip, $after_protection);

		//$set_res = $api_model->setProtectionValue('1.1.1.1', 0);
		if ($set_res != 'editok' && $set_res != 'ok') {
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '更新业务防御峰值失败',
				'code'	=> 0,
			];
		}

		DB::commit();
		return [
			'data'	=> [],
			'msg'	=> '使用成功',
			'code'	=> 1,
		];
	}

	/**
	 * 叠加包绑定对应的IDC业务
	 * @param  array $param --belong_id所属叠加包id,--order_id所需绑定叠加包的机器业务订单id
	 * @return [type]        [description]
	 */
	public function useOverlayToIDC($param){
		if(!isset($param['belong_id'])){//未设置流量包所属的id
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#101)无法确定需要绑定的叠加包';
			return $return;
		}

		if(!isset($param['order_id'])){//未设置需要绑定订单的id
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#102)无法确定你需要绑定叠加包的业务';
			return $return;
		}

		$belong = OverlayBelongModel::find($param['belong_id']);//查找流量包所属的数据

		if(empty($belong)){//不存在流量包所属数据
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#103)你需绑定的叠加包业务不存在';
			return $return;
		}

		if($belong->status != 0){//流量包已被使用
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#104)该叠加包已被使用,请重新选择';
			return $return;
		}

		$overlay = DB::table('tz_overlay')
					 ->where(['id'=>$belong->overlay_id])
					 ->select('id','site','protection_value','validity_period')
					 ->first();//查找对应的流量包的所对应的防护等参数
		
		if(empty($overlay)){//不存在
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#105)未找到对应的叠加套餐,请与管理员联系核实';
			return $return;
		}

		$idc_orders = DB::table('tz_orders')
						->join('tz_business','tz_orders.business_sn','=','tz_business.business_number')
						->where(['tz_orders.id'=>$param['order_id']])
						->select('tz_orders.machine_sn','tz_orders.order_sn','tz_orders.resource_type','tz_business.resource_detail','tz_orders.customer_id')
						->first();//查找对应要绑定的订单

		if(empty($idc_orders)){//不存在对应的要绑定的订单
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#106)没有找到需要绑定叠加包的业务';
			return $return;
		}

		if($idc_orders->customer_id != $belong->user_id){//订单与流量包所属客户不一致
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#107)叠加包与需要绑定叠加包的业务不属于同一客户';
			return $return;
		}

		$resource_detail = json_decode($idc_orders->resource_detail);

		if($resource_detail->machineroom_id != $overlay->site){//机房不一致
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#108)叠加包与需要绑定叠加包的所属机房不一致';
			return $return;
		}

		if($idc_orders->resource_type == 1 || $idc_orders->resource_type == 2){//租用/托管机器默认使用主IP
			$ip = $resource_detail->ip;
		} elseif ($idc_orders->resource_type == 4 ){//对应的IP资源
			$ip = $idc_orders->machine_sn;
		} else {//其他无IP的不给予绑定
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#109)请确定IP';
			return $return;
		}

		DB::beginTransaction();
		$update['use_time'] = date('Y-m-d H:i:s',time());
		$update['target_business'] = $idc_orders->order_sn;
		$update['status'] = 1;
		$use_time = $overlay->validity_period*24*3600;
		//结束的时间
		$update['end_time'] = date('Y-m-d H:i:s',bcadd(time(),$use_time,0));
		$belong_update = DB::table('tz_overlay_belong')->where(['id'=>$param['belong_id']])->update($update);//对应的订单号更新进流量包所属
		if($belong_update == 0){
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#110)叠加包绑定失败';
			return $return;
		}

		/**
		 * 将对应的IP根据对应的流量值进行api接口存入
		 * @var ApiController
		 */
		$api = new ApiController();

		$api_result = $api->setProtectionValue($ip, $overlay->protection_value);

		if($api_result != 'editok' && $api_result != 'ok') {//存入失败
			DB::rollBack();
			$return['data'] = [];
			$return['code'] = 0;
			$return['msg'] = '(#111)叠加包绑定失败';
			return $return;
		}

		DB::commit();
		$return['data'] = [];
		$return['code'] = 1;
		$return['msg'] = '叠加包绑定成功';
		return $return;

	}
}