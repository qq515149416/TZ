<?php 
 
 
namespace App\Http\Models\Customer; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 
 
use App\Http\Models\DefenseIp\OrderModel as DipModel;
use App\Http\Models\Customer\PayOrder;
use App\Http\Models\DefenseIp\BusinessModel as DipBusinessModel;
use App\Http\Controllers\DefenseIp\ApiController as DipSetApi;
use App\Http\Models\DefenseIp\XADefenseDataModel;
use App\Http\Models\Customer\Order;
use App\Http\Models\Customer\WhiteListModel;
class ApiOut extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_api'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['user_id', 'state','api_key','api_secret']; 
 


 	//为啥不用魔术方法,因为laravel 的model类$this是有定义的,不能自己定义东西
	/** 
	 *  检查签名方法
	 * @param $apiKey -> 就是key, $par -> 要组成签名的元素,传过来的参数, $hash ->客户端传来的签名字符串
	 * @return 验签失败 ->false ; 验签成功 ->签名用户的id
	 */ 
	public function checkSign($apiKey , $par , $hash){ 
		//获取对应秘钥信息
 		$apply = $this->where('api_key' , $apiKey)
 				->where('state' , 1)
 				->select([ 'api_key' , 'api_secret' , 'user_id'])
 				->first();
 		//如果没有
 		if (!$apply) {
 			return false;
 		}

 		$apply = $apply->toArray();	//转数组
 		//生成签名参数数组
 		$par['apiKey'] = $apiKey;
 		$sign_arr = $par;
 		//排序数组
 		ksort($sign_arr);
 		//生成字符串
 		$sign_str = '';
 		foreach ($sign_arr as $k => $v) {
 			$sign_str.= $k.'='.$v.'&';
 		}
 		//去掉字符串最后一个&字符
 		$sign_str = substr($sign_str,0,-1);
 		//接上SECRET
 		$sign_str.= $apply['api_secret'];
 		//加密字符串生成签名
 		$sign_str = md5($sign_str);
 		//dd($sign_str);
 		if($sign_str != $hash){
 			return false;
 		}else{
 			return $apply['user_id'];
 		}
	}


	/** 
	 *  外部调用购买高防ip
	 */ 
	public function buyDIP($apiKey , $timestamp , $hash, $packageId , $buyTime ){ 
		//取出要做成签名的元素
		$par = [
			'timestamp'	=> $timestamp,
			'packageId'	=> $packageId,
			'buyTime '	=> $buyTime,
		];

		$check_sign = $this->checkSign($apiKey , $par , $hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key',
				'code'	=> 0,
			];	
		}
		
		//找出所购买的套餐
		$package = DB::table('tz_defenseip_package')->select(['site','protection_value','sell_status','channel_price'])->whereNull('deleted_at')->where('id',$package_id)->first();

		if($package == null){
			return [
				'data'	=> [],
				'msg'	=> '套餐不存在!',
				'code'	=> 0,
			];
		}
		if ($package->sell_status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '套餐已下架!',
				'code'	=> 0,
			];
		}
		//查询购买的套餐库存ip是否足够
		$check_ip = DB::table('tz_defenseip_store')
				->select(['id','ip'])
				->where('site',$package->site)
				->where('protection_value',$package->protection_value)
				->where('status',0)
				->whereNull('deleted_at')
				->first();
		
		if($check_ip == null){
			return [
				'data'	=> [],
				'msg'	=> '该套餐IP库存不足!',
				'code'	=> 0,
			];
		}
		$customer = DB::table('tz_users')->where('id',$check_sign)->select(['name' , 'email' ,'nickname','salesman_id','money'])->first();
		if(!$customer){
			return [
				'data'	=> [],
				'msg'	=> '客户信息获取失败!',
				'code'	=> 0,
			];
		}
		//生成待审核业务信息
		$time = time();
		$data['order_sn'] 		= 'GN_api_'.$time.'_'.substr(md5($check_sign.'tz'),0,4);
		$data['business_sn']		= 'G_api_'.$time.'_'.substr(md5($check_sign.'tz'),0,4);
		$data['customer_id']		= $check_sign;
		$data['customer_name']		= $customer->nickname?:$customer->name?:$customer->email;
		//获取用户的所属业务员
		$admin_user = DB::table('admin_users')->select('name')->where('id',$customer->salesman_id)->first();

		if ($customer->salesman_id == null || $admin_user == null) {
			return [
				'data'	=> [],
				'msg'	=> '请绑定业务员后购买!',
				'code'	=> 0,
			];
		}else{
			$data['business_id']		= $customer->salesman_id;
		}
		$data['business_name']		= $admin_user->name;
		$data['resource_type']		= 11;
		$data['order_type']		= 1;
		$data['price']			= $package->channel_price;
		$data['machine_sn']		= $package_id;
		$data['duration']		= $buy_time;
		$data['payable_money']		= bcmul($data['price'],$data['duration'],2);
		$data['order_status']		= 0;
		$data['order_note']		= '渠道api购买';

		if ($customer->money < $data['payable_money']) {
			return [
				'data'	=> [],
				'msg'	=> '余额不足!',
				'code'	=> 0,
			];
		}

		DB::beginTransaction();

		$order_model = new DipModel();
		$insert = $order_model->create($data);	//生成待审核业务

		if(!$insert){
			return [
				'data'	=> [],
				'msg'	=> '创建订单失败!',
				'code'	=> 0,
			];
		}
		$pay_model = new PayOrder();
		$pay_res = $pay_model->payOrderByBalance([$insert->id] , 0 , $check_sign);
		if($pay_res['code'] != 1){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '支付失败!',
				'code'	=> 0,
			];
		}else{
			DB::commit();
			return [
				'data'	=> [],
				'msg'	=> '购买成功!',
				'code'	=> 1,
			];
		}
	}


	/** 
	 *  外部调用购买高防ip
	 */ 
	public function renewDIP($apiKey , $timestamp , $hash, $businessNumber , $renewTime ){ 
		//取出要做成签名的元素
		$par = [
			'timestamp'		=> $timestamp,
			'businessNumber'	=> $businessNumber,
			'renewTime '		=> $renewTime,
		];

		$check_sign = $this->checkSign($apiKey , $par , $hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key',
				'code'	=> 0,
			];	
		}
		
		//找出续费业务
		$business = DB::table('tz_defenseip_business')->select(['price','status','business_number','ip_id','package_id'])
								->whereNull('deleted_at')
								->where('business_number',$businessNumber)
								->where('user_id',$check_sign)
								->first();
		if($business == null){
			return [
				'data'	=> [],
				'msg'	=> '业务不存在!',
				'code'	=> 0,
			];
		}
		if ($business->status != 1) {
			return [
				'data'	=> [],
				'msg'	=> '业务非使用中状态!',
				'code'	=> 0,
			];
		}

		$customer = DB::table('tz_users')->where('id',$check_sign)->select(['name' , 'email' ,'nickname','salesman_id','money'])->first();
		if(!$customer){
			return [
				'data'	=> [],
				'msg'	=> '客户信息获取失败!',
				'code'	=> 0,
			];
		}

		//生成订单信息
		$data['order_sn'] 		= 'GO_api_'.time().'_'.substr(md5($check_sign.'tz'),0,4);
		$data['business_sn']		= $business->business_number;
		$data['customer_id']		= $check_sign;
		$data['customer_name']		= $customer->nickname?:$customer->name?:$customer->email;
		//获取用户的所属业务员
		$admin_user = DB::table('admin_users')->select('name')->where('id',$customer->salesman_id)->first();

		if ($customer->salesman_id == null || $admin_user == null) {
			return [
				'data'	=> [],
				'msg'	=> '请绑定业务员后购买!',
				'code'	=> 0,
			];
		}else{
			$data['business_id']		= $customer->salesman_id;
		}
		$data['business_name']		= $admin_user->name;
		$data['resource_type']		= 11;
		$data['resource']		= DB::table('tz_defenseip_store')->where('id',$business->ip_id)->value('ip');
		$data['order_type']		= 2;
		$data['price']			= $business->price;
		$data['machine_sn']		= $business->package_id;
		$data['duration']		= $renewTime;
		$data['payable_money']		= bcmul($data['price'],$data['duration'],2);
		$data['order_status']		= 0;
		$data['order_note']		= '渠道api续费';
		

		if ($customer->money < $data['payable_money']) {
			return [
				'data'	=> [],
				'msg'	=> '余额不足!',
				'code'	=> 0,
			];
		}

	
		DB::beginTransaction();

		$order_model = new DipModel();
		$insert = $order_model->create($data);	//生成待审核业务

		if(!$insert){
			return [
				'data'	=> [],
				'msg'	=> '创建订单失败!',
				'code'	=> 0,
			];
		}
		$pay_model = new PayOrder();
		$pay_res = $pay_model->payOrderByBalance([$insert->id] , 0 , $check_sign);
		if($pay_res['code'] != 1){
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '支付失败!',
				'code'	=> 0,
			];
		}else{
			DB::commit();
			return [
				'data'	=> [],
				'msg'	=> '续费成功!',
				'code'	=> 1,
			];
		}
	}

	/** 
	 *  客户展示自己已购买的高防套餐
	 * @param $apiKey -> 就是key, $timestamp -> 时间戳, $hash ->客户端传来的签名字符串
	 * @return 
	 */ 
	public function showDIP($apiKey , $timestamp , $hash){ 
		$par = [
			'timestamp'	=> $timestamp,
		];
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}

		$dip_business = DB::table('tz_defenseip_business as a')
							->leftJoin('tz_defenseip_package as c' , 'c.id' , '=' , 'a.package_id')
							->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'c.site')
							->leftJoin('tz_defenseip_store as d' , 'd.id' , '=' , 'a.ip_id')
							->where('a.user_id' , $check_sign)
							->whereNull('a.deleted_at')
							->select(['a.business_number as businessNumber' , 'a.target_ip as targetIp' , 'a.price' , 'a.status' , 'a.end_at as endAt' , 'a.start_time as startTime' , 'a.extra_protection as extraProtection' , 'b.machine_room_name as machineRoomName' , 'c.name as packageName' , 'c.protection_value as protectionValue' , 'd.ip' ])
							->get();
		if(!$dip_business->isEmpty()){
			$status = [ 0 => '预留状态' ,  1 => '正在使用' , 2 => '申请下架' , 3 => '已下架' , 4 => '试用' , 5 => '待审核' ,];
			foreach ($dip_business as $k => $v) {
				$v->useStatus = $status[$v->status];
			}
			return [
				'data'	=> $dip_business,
				'msg'	=> '查询成功!',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '无已购套餐!',
				'code'	=> 1,
			];
		}
		
	}

	/** 
	 *  客户展示自己已购买的高防套餐 详情
	 * @param $apiKey -> 就是key, $timestamp -> 时间戳, $hash ->客户端传来的签名字符串
	 * @return 
	 */ 
	public function showDIPDetail($apiKey , $timestamp , $hash , $businessNumber){ 
		$par = [
			'timestamp'		=> $timestamp,
			'businessNumber'	=> $businessNumber,
		];
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}
		
		$dip_business = DB::table('tz_defenseip_business as a')
							->leftJoin('tz_defenseip_package as c' , 'c.id' , '=' , 'a.package_id')
							->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'c.site')
							->leftJoin('tz_defenseip_store as d' , 'd.id' , '=' , 'a.ip_id')
							->where('a.user_id' , $check_sign)
							->where('a.business_number' , $businessNumber)
							->whereNull('a.deleted_at')
							->select(['a.business_number as businessNumber' , 'a.target_ip as targetIp' , 'a.price' , 'a.status' , 'a.end_at as endAt' , 'a.start_time as startTime' , 'a.extra_protection as extraProtection' , 'b.machine_room_name as machineRoomName' , 'c.name as packageName' , 'c.protection_value as protectionValue' , 'd.ip' ])
							->first();

		if($dip_business){
			$status = [ 0 => '预留状态' ,  1 => '正在使用' , 2 => '申请下架' , 3 => '已下架' , 4 => '试用' , 5 => '待审核' ,];

			$dip_business->useStatus = $status[$dip_business->status];

			return [
				'data'	=> $dip_business,
				'msg'	=> '查询成功!',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '查询失败!',
				'code'	=> 1,
			];
		}
		
	}


	/** 
	 *  客户搜索自己已购买的高防套餐
	 * @param $apiKey -> 就是key, $timestamp -> 时间戳, $hash ->客户端传来的签名字符串
	 * @return 
	 */ 
	public function searchDIP($apiKey , $timestamp , $hash , $ip){ 
		$par = [
			'timestamp'	=> $timestamp,
			'ip'		=> $ip,
		];
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}

		$dip_business = DB::table('tz_defenseip_business as a')
							->leftJoin('tz_defenseip_package as c' , 'c.id' , '=' , 'a.package_id')
							->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'c.site')
							->leftJoin('tz_defenseip_store as d' , 'd.id' , '=' , 'a.ip_id')
							->where('a.user_id' , $check_sign)
							->where('d.ip' , 'like' ,'%'.$ip.'%')
							->whereNull('a.deleted_at')
							->select(['a.business_number as businessNumber' , 'a.target_ip as targetIp' , 'a.price' , 'a.status' , 'a.end_at as endAt' , 'a.start_time as startTime' , 'a.extra_protection as extraProtection' , 'b.machine_room_name as machineRoomName' , 'c.name as packageName' , 'c.protection_value as protectionValue' , 'd.ip' ])
							->get();
		if(!$dip_business->isEmpty()){
			$status = [ 0 => '预留状态' ,  1 => '正在使用' , 2 => '申请下架' , 3 => '已下架' , 4 => '试用' , 5 => '待审核' ,];
			foreach ($dip_business as $k => $v) {
				$v->useStatus = $status[$v->status];
			}
			return [
				'data'	=> $dip_business,
				'msg'	=> '查询成功!',
				'code'	=> 1,
			];
		}else{
			return [
				'data'	=> [],
				'msg'	=> '无数据!',
				'code'	=> 1,
			];
		}	
	}

	/** 
	 *  展示高防套餐id
	 */ 
	public function showDIPPackage($apiKey , $timestamp , $hash){ 
		$par = [
			'timestamp'	=> $timestamp,
		];
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}
 		

 		$pack = DB::table('tz_defenseip_package as a')->leftJoin('idc_machineroom as b' , 'b.id' , '=' , 'a.site')
 							->where('a.sell_status' , 1)
 							->whereNull('a.deleted_at')
 							->select(['a.id as packageId' , 'a.name' , 'a.site' ,'a.description' ,'a.protection_value as protectionValue' ,'a.channel_price as channelPrice','b.machine_room_name as machineRoomName'])
 							->get();
 		foreach ($pack as $k => $v) {
 			$pack[$k]->stock = DB::table('tz_defenseip_store')->where('site' , $v->site)
 								->where('protection_value' , $v->protectionValue)
 								->where('status' , 0)
 								->whereNull('deleted_at')
 								->count('id');
 		}
 		return [
			'data'	=> $pack,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}


	/** 
	 *  设置高防的目标ip
	 */ 
	public function setDIPTarget($apiKey , $timestamp , $hash , $businessNumber , $targetIp){ 
		$targetIp = trim($targetIp);
		$par = [
			'timestamp'		=> $timestamp,
			'businessNumber'	=> $businessNumber,
			'targetIp'		=> trim($targetIp),
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}
 		$business_model = new DipBusinessModel();

 		$business = $business_model->where('business_number' , $businessNumber)
 						->where('user_id' , $check_sign)
 						->first();
 		if (!$business) {
 			return [
				'data'	=> [],
				'msg'	=> '业务不存在!',
				'code'	=> 0,
			];
 		}
 		if ($business->status != 1) {
 			return [
				'data'	=> [],
				'msg'	=> '业务并非使用中状态!',
				'code'	=> 0,
			];
 		}
 		$d_ip = DB::table('tz_defenseip_store')->where('id', $business->ip_id)->value('ip');

		if(!$d_ip){
			return [
				'data'	=> [],
				'msg'	=> '高防ip查询失败!',
				'code'	=> 0,
			];
		}
		DB::beginTransaction();

		$business->target_ip = $targetIp;

		if (!$business->save()) {
			return [
				'data'	=> [],
				'msg'	=> '绑定IP失败',
				'code'	=> 0,
			];
		}

 		$api_model 	= new DipSetApi();

		$apiData 	= json_decode($api_model->createTarget($d_ip, $targetIp), true); //使用api接口更新目标IP地址
		$apiData2	= json_decode($api_model->updateTarget($d_ip, $targetIp), true); //使用api接口更新目标IP地址
		
		if ($apiData['code'] == 0 || $apiData2['code'] == 0) {
			DB::commit();
			return [
				'data'	=> [],
				'msg'	=> '绑定IP成功',
				'code'	=> 1,
			];
		}else{
			DB::rollBack();
			return [
				'data'	=> [],
				'msg'	=> '绑定IP失败',
				'code'	=> 0,
			];
		}	
	}



	/** 
	 *  获取高防流量图
	 */ 
	public function showDIPFlow($apiKey , $timestamp , $hash , $startTime , $endTime , $ip)
	{
		$ip = trim($ip);
		$par = [
			'timestamp'		=> $timestamp,
			'startTime'		=> $startTime,
			'endTime'		=> $endTime,
			'ip'			=> $ip,
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}

		$now = date('Y-m-d H:i:s',time());
		
		//查看ip是否属于客户
		$check1 = DB::table('tz_orders')->where('order_status',1)
						->where('end_time' , '>' ,$now)
						->where('resource' , $ip)
						->where('customer_id' ,$check_sign)
						->exists();
		$check2 = DB::table('tz_orders')->where('order_status',1)
						->where('end_time' , '>' ,$now)
						->where('machine_sn' , $ip)
						->where('customer_id' ,$check_sign)
						->exists();
		if (!$check1 && !$check2) {
			return [
				'data'	=> [],
				'msg'	=> 'ip不属于您,无法查看!',
				'code'	=> 0,
			];
		}
		// dd($ip);
		$xa_model = new XADefenseDataModel();
		$res = $xa_model->getByIp($ip , $startTime , $endTime);

		if (!$res) {
			return [
				'data'	=> [],
				'msg'	=> '无流量数据 !',
				'code'	=> 0,
			];
		}else{
			return [
				'data'	=> $res,
				'msg'	=> '获取流量数据成功 !',
				'code'	=> 1,
			];
		}
	}
	

	/** 
	 *  获取所有使用中的ip
	 */ 
	public function showAllIp($apiKey , $timestamp , $hash)
	{
		$par = [
			'timestamp'		=> $timestamp,
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}
		//获取用户订单内的使用中ip
		$orders = Order::where('customer_id' , $check_sign)		//指定用户
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
					'ip'			=> $v->ip,
					'description'		=> $v->m_num.' 编号机器的子IP',
					'bindingMachine'	=> $v->m_num,
				];
			}
		}

		//获取用户业务里的主机ip,从使用中业务处找
		$business = Business::where('client_id' , $check_sign)			//指定用户machine_number
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
					'ip'			=> $v->ip,
					'description'		=> $v->m_num.' 编号机器的主IP',
					'bindingMachine'	=> $v->m_num,
				];
			}
		}

		//获取用户高防业务里的IP
		$d_ip = DipBusinessModel::where('user_id' , $check_sign)		//指定用户
					->leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
					->whereIn('tz_defenseip_business.status' , [1,4])		//正在使用
					->get(['b.ip' , 'tz_defenseip_business.business_number as b_num']);
		if(!$d_ip->isEmpty()){
			foreach ($d_ip as $k => $v) {
				$ips[] = [
					'ip'			=> $v->ip,
					'description'		=> '业务编号为 : '.$v->b_num.' 的高防IP',
					'bindingMachine'	=> $v->b_num,
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

	/** 
	 *  提交白名单申请
	 */ 
	public function setWhiteList($apiKey , $timestamp , $hash, $ip , $domainName , $recordNumber , $submitNote)
	{
		$par = [
			'timestamp'		=> $timestamp,
			'ip'			=> $ip,
			'domainName'		=> $domainName,
			'recordNumber'		=> $recordNumber,
			'submitNote'		=> $submitNote,
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}
		$white_model = new WhiteListModel();

		$check_black = $white_model->where('domain_name' , $domainName)
						->where('white_status' , 3)
						->exists();
		if ($check_black) {
			return [
				'data'	=> [],
				'msg'	=> '该域名已被拉黑!',
				'code'	=> 0,
			];
		}
		$check_already = $white_model->where('white_ip' , $ip)
						->where('domain_name' , $domainName)
						->whereIn('white_status' , [0,1])
						->exists();
		if ($check_already) {
			return [
				'data'	=> [],
				'msg'	=> '审核中或已通过审核,请勿重复提交!',
				'code'	=> 0,
			];
		}
		//获取用户订单内的使用中ip
		$check_orders = Order::where('customer_id' , $check_sign)		//指定用户
				->leftJoin('tz_business as b','b.business_number','=','tz_orders.business_sn')
				->where('tz_orders.machine_sn' , $ip)
				->where('tz_orders.resource_type',4)		//类型为ip
				->where('b.remove_status' , 0)			//未下架
				->where('tz_orders.remove_status',0)		//未下架
				->whereIn('tz_orders.order_status',[0,1,2])	//订单正在使用
				->whereIn('b.business_status',[1,2])		//正在使用
				->select(['b.machine_number'])
				->first();
		if(!$check_orders){	//如果订单里没有的话
			//用户业务里的主机ip,从使用中业务处找
			$check_business = Business::where('client_id' , $check_sign)			//指定用户machine_number
				->leftJoin('idc_machine as b','b.machine_num','=','tz_business.machine_number')
				->leftJoin('idc_ips as c' , 'c.id' , '=' , 'b.ip_id')
				->where('c.ip',$ip)
				->whereIn('tz_business.business_type' , [1,2])	//业务类型为主机的
				->whereNull('b.deleted_at')
				->where('tz_business.remove_status' , 0)		//未下架
				->whereIn('tz_business.business_status' , [1,2])	//正在使用
				->select(['tz_business.machine_number'])
				->first();
			if(!$check_business){	//如果主机ip里没有的话,去高防找
				//用户高防业务里的IP里找
				$check_d_ip = DipBusinessModel::where('user_id' , $check_sign)		//指定用户
					->leftJoin('tz_defenseip_store as b' , 'b.id' , '=' , 'tz_defenseip_business.ip_id')
					->where('b.ip',$ip)
					->whereIn('tz_defenseip_business.status' , [1,4])		//正在使用
					->select('tz_defenseip_business.business_number')
					->first();
				if(!$check_d_ip){		//如果高防里也没有那就不是了
					return [
						'data'	=> [],
						'msg'	=> 'ip不属于您,无法申请白名单',
						'code'	=> 0,
					];
				}else{
					$binding_machine = $check_d_ip->business_number;
				}
			}else{	//如果主机ip里有的话
				$binding_machine = $check_business->machine_number;
			}
		}else{	//如果订单里有的话
			$binding_machine = $check_orders->machine_number;
		}

		$pattern = '/^((http){1}|w{3}|\W)/i';//意思是以  http  | www  |  非单词字符即 a-z A-Z 0-9的字符/

		$res = preg_match($pattern,$domainName,$match);

		if( $res){
			return [
				'data'	=> [],
				'msg'	=> '域名格式错误,开头勿填 : http:// ; https ; www ; / ;',
				'code'	=> 0,
			];
		}
		$customer = DB::table('tz_users')->where('id' , $check_sign)->select(['name' , 'email' , 'nickname'])->first();
		$customer_name = $customer->nickname?:$customer->name?:$customer->email;
		if (!$customer) {
			return [
				'data'	=> [],
				'msg'	=> '账号信息获取失败',
				'code'	=> 0,
			];
		}
		
		$insert_data['domain_name']	= $domainName;
		$insert_data['record_number']	= $recordNumber;
		$insert_data['submit_note']	= $submitNote;
		$insert_data['white_ip']		= $ip;
		$insert_data['binding_machine']	= $binding_machine;
		$insert_data['white_number'] 	= create_number();
		$insert_data['customer_id'] 	= $check_sign;
		$insert_data['customer_name'] 	= $customer_name;
		$insert_data['submit_id'] 	= $check_sign;
		$insert_data['submit_name'] 	= $customer_name;
		$insert_data['submit'] 		= 1;
		$insert_data['white_status'] 	= 0;

		
		$row = $white_model->create($insert_data);
		if(!$row){
			return [
				'data'	=> [],
				'msg'	=> '白名单信息提交失败，请确认后重新提交',
				'code'	=> 0,
			];

		} else {
			return [
				'data'	=> [],
				'msg'	=> '白名单信息提交成功，请耐心等待审核',
				'code'	=> 1,
			];

		}
	}

	/** 
	 *  获取所有白名单申请
	 */ 
	public function showWhiteList($apiKey , $timestamp , $hash)
	{
		$par = [
			'timestamp'		=> $timestamp,
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}

		$white_model = new WhiteListModel();

		$white_list_list = $white_model->where('customer_id' , $check_sign)
						->select(['white_number as whiteNumber' , 'white_ip as ip' , 'domain_name as domainName' , 'record_number as recordNumber' , 'binding_machine as belong' , 'submit' ,'submit_note as submitNote' , 'check_number as checkNumber' , 'check_time as checkTime' , 'check_note as checkNote' , 'white_status as whiteStatus'])
						->get();
		if ($white_list_list->isEmpty()) {
			return [
				'data'	=> [],
				'msg'	=> '无申请!',
				'code'	=> 0,
			];
		}
		$status = [ 0 => '审核中' , 1 => '审核通过' , 2 => '审核不通过' , 3 => '黑名单' , 4 => '取消' ];
		$submit = [ 1 => '客户自行提交' , 2 => '工作人员提交' ];
		foreach ($white_list_list as $k => $v) {
			$v->whiteStatus = $status[$v->whiteStatus];
			$v->submit = $submit[$v->submit];
		}

		return [
			'data'	=> $white_list_list,
			'msg'	=> '获取成功!',
			'code'	=> 1,
		];
	}
	

	/** 
	 *  展示可购买叠加包
	 */ 
	public function showOverlay($apiKey , $timestamp , $hash )
	{
		$par = [
			'timestamp'		=> $timestamp,
		];
	
		$check_sign = $this->checkSign($apiKey,$par,$hash);

		if (!$check_sign) {
			return [
				'data'	=> [],
				'msg'	=> '非法的API Key!',
				'code'	=> 0,
			];
		}

		$on_sale = DB::table('tz_overlay as a')->leftJoin('idc_machineroom as b', 'b.id' , '=' , 'a.site')
				->whereNull('a.deleted_at')
				->where('a.sell_status' , 1)
				->get(['a.name' , 'a.description' , 'a.protection_value as protectionValue' , 'a.channel_price as channelPrice' , 'a.validity_period as validityPeriod']);
		dd($on_sale);
		
		//查看ip是否属于客户
		
		if (!$res) {
			return [
				'data'	=> [],
				'msg'	=> '无流量数据 !',
				'code'	=> 0,
			];
		}else{
			return [
				'data'	=> $res,
				'msg'	=> '获取流量数据成功 !',
				'code'	=> 1,
			];
		}
	}
	


}