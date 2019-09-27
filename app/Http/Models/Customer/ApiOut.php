<?php 
 
 
namespace App\Http\Models\Customer; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB; 
 
use App\Http\Models\DefenseIp\OrderModel as DipModel;
use App\Http\Models\Customer\PayOrder;

class ApiOut extends Model 
{ 
	use SoftDeletes; 
	 
 
	protected $table = 'tz_api'; //表 
	protected $primaryKey = 'id'; //主键 
	public $timestamps = true; 
	protected $dates = ['deleted_at']; 
	protected $fillable = ['user_id', 'state','api_key','api_secret']; 
 
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
	public function buyDIP($apiKey , $timestamp , $hash, $package_id , $buy_time ){ 
		//取出要做成签名的元素
		$par = [
			'timestamp'	=> $timestamp,
			'package_id'	=> $package_id,
			'buy_time '	=> $buy_time,
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
}