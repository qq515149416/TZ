<?php


namespace App\Admin\Controllers\Waf;

use App\Admin\Models\Waf\WafPackageModel;
use App\Admin\Models\Waf\WafBusinessModel;
use App\Admin\Models\Waf\WafDomainModel;
use App\Admin\Controllers\Waf\ApiController;

use App\Admin\Requests\Waf\WafRequest;

use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WafController extends Controller
{
	
	/**
	 *  创建套餐
	 */
	public function insert(WafRequest $request){
		$par = $request->only(['name', 'description','https_switch','web_switch','cc_switch','ip_switch','domain_num','price']);

		$model = new WafPackageModel();

		$res = $model->insert($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}
	
	/**
	 *  删除套餐
	 */
	public function del(WafRequest $request){
		$par = $request->only(['del_id']);

		$model = new WafPackageModel();

		$res = $model->del($par['del_id']);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  编辑套餐
	 */
	public function edit(WafRequest $request){
		$par = $request->only(['name', 'description','sell_status','edit_id']);

		$model = new WafPackageModel();

		$res = $model->edit($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  展示套餐
	 */
	public function show(WafRequest $request){
		$par = $request->only(['sell_status']);

		$model = new WafPackageModel();

		$res = $model->show($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  后台工作人员为客户购买防火墙套餐
	 */
	public function buyNowByAdmin(WafRequest $request){
		$par = $request->only(['package_id','price','user_id']);

		$model = new WafBusinessModel();

		$res = $model->buyNowByAdmin($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}

	/**
	 *  获取待审核 防火墙 接口 
	 */
	public function showExamine(WafRequest $request){

		$model = new WafBusinessModel();

		$makeOrder = $model->showExamine();
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	 *  审核 防火墙 接口  /  选取审核中业务后,转为试用业务
	 */
	public function examine(WafRequest $request){
		$par = $request->only(['business_id','res']);
		$model = new WafBusinessModel();

		$business_id = $par['business_id'];
		$res = $par['res'];
		$makeOrder = $model->examine($business_id,$res);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	 *  续费 防火墙业务 接口  /  选取业务后,生成订单信息 
	 */
	public function renewByAdmin(WafRequest $request){
		$par = $request->only(['business_id','buy_time','start_time']);
		$model = new WafBusinessModel();

		$business_id = $par['business_id'];
		$buy_time = $par['buy_time'];
		
		if(isset($par['start_time'])){
			$start_time = date("Y-m-d H:i",$par['start_time']) ;
		}else{
			$start_time = 'no';
		}
	
		$makeOrder = $model->renew($business_id,$buy_time,$start_time);
		
		return tz_ajax_echo($makeOrder['data'],$makeOrder['msg'],$makeOrder['code']);
	}

	/**
	 *  展示客户所属业务
	 */
	public function showBusiness(WafRequest $request){
		$par = $request->only(['user_id']);

		$model = new WafBusinessModel();

		$res = $model->showBusiness($par);

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);	
	}


	//检查业务所属客户是否属于操作业务员
	//@return 行就code = 1 , data = $business(业务数组) , 不行就code = 0 , 
	public function checkAdmin($business_id)
	{
		$business_model = new WafBusinessModel();
		$business = $business_model
			->leftJoin('tz_waf_package as b','b.id', '=' , 'tz_waf_business.package_id')
			->whereIn('tz_waf_business.status',[1,4])//没下架,还在用的业务
			->where('tz_waf_business.id',$business_id)
			->select(['tz_waf_business.*','b.domain_num'])
			->first();
		if (!$business) {
			return [
				'data'	=> [],
				'msg'	=> '业务不存在或已下架',
				'code'	=> 0,
			];
		}
		
		$business = $business->toArray();

		//判断客户所属业务员
		$business_admin_user = DB::table('tz_users')->where('id',$business['user_id'])->value('salesman_id');
		if (Admin::user()->id != $business_admin_user) {
			return [
				'data'	=> [],
				'msg'	=> '客户不属于您',
				'code'	=> 0,
			];
		}
		return [
			'data'	=> $business,
			'msg'	=> '没问题',
			'code'	=> 1,
		];
	}

	//配置域名
	public function insertDomain(WafRequest $request)
	{	
		//获取域名和业务编号
		$par = $request->only(['business_id' , 'domain_name'  , 'source_http_port' , 'source_ip' , 'http' , 'https' , 'public_key' , 'private_key' , 'enc_https' , 'redirect_https' , 'proxy' , 'proxy_ip']);

		//整理下api传参
		$data = [
			"api_key"		=> '',
			"api_password"		=> '',
			"source_http_port"	=> $par['source_http_port'],	//端口
			"proxy"			=> 'false',			//WAF是否存在代理
			"proxy_ip"		=> "",				//代理地址
			"redirect_https"		=> 'false',			//HTTPS强制跳转
			"enc_https"		=> 'false',			//私钥AES加密
			"domain"		=> $par['domain_name'],	//域名
			"public_key"		=> '',				//公钥
			"private_key"		=> '',				//私钥
			"source_ip"		=> $par['source_ip'],		//服务器ip
			"http"			=> 'false',			//协议类型
			"https"			=> 'false',			//协议类型
		];	

		if ($par['http'] == 0 && $par['https'] == 0) {
			return tz_ajax_echo([],'请至少选择一项协议类型',0);
		}
		if ($par['http'] == 1) {
			$data['http']		= 'true';
		}
		if ($par['https'] == 1) {
			$data['https']		= 'true';
			$data['public_key']	= $par['public_key'];
			$data['private_key']	= $par['private_key'];
			if ($par['redirect_https'] == 1) {
				$data['redirect_https'] 	= 'true';
			}
			if ($par['enc_https'] == 1) {
				$data['enc_https'] 	= 'true';
			}
		}

		if ($par['proxy'] == 1) {
			$data['proxy'] 		= 'true';
			$data['proxy_ip'] 	= $par['proxy_ip'];
		}
		//入我们的库
	
		//先检查业务所属客户是否属于操作业务员
		$check_admin = $this->checkAdmin($par['business_id']);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}else{
			$business = $check_admin['data'];
		}

		//先查一下业务能配置多少个域名

		$domain_model = new WafDomainModel();

		//查看已配置域名数量
		$already_num = $domain_model->where('business_id' , $par['business_id'])->count();
		//判断是否超额
		if ($already_num >= $business['domain_num']) {
			return tz_ajax_echo([],'您所购买套餐可配置域名数量为'.$business['domain_num'].'个',0);
		}

		DB::beginTransaction();
		//入我们库
		$domain_data = [
			'business_id'	=> $par['business_id'],
			'domain_name'	=> $par['domain_name'],
		];
		$self_insert = $domain_model->insert($domain_data);

		if (!$self_insert) {
			return tz_ajax_echo([],'添加失败',0);
		}
		
		//入了我们库就配置域名去
		$api_controller = new ApiController();
		$res = $api_controller->insertDomain($data);

		if (!$res['result']) {
			DB::rollBack();
			return tz_ajax_echo([],$res['message'],0);
		}

		DB::commit();
		return tz_ajax_echo([],'配置域名成功',1);

	}

	//删除域名
	public function delDomain(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}

		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}
		DB::beginTransaction();

		$del_self = $domain_model->where('id',$domain_info->id)->delete();

		if ($del_self != 1) {
			return tz_ajax_echo([],'删除失败',0);
		}


		$api_controller = new ApiController();
		$res = $api_controller->delDomain($domain_info->domain_name);
		

		if (!$res['result']) {
			DB::rollBack();
			return tz_ajax_echo([],$res['message'],0);
		}

		DB::commit();
		return tz_ajax_echo([],'删除域名成功',1);
	}

	//编辑域名基本配置
	public function editDomain(WafRequest $request)
	{
		//获取域名和业务编号
		$par = $request->only(['business_id' , 'domain_name'  , 'source_http_port' , 'source_ip' , 'http' , 'https' , 'public_key' , 'private_key' , 'enc_https' , 'redirect_https' , 'proxy' , 'proxy_ip']);

		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}

		//先检查业务所属客户是否属于操作业务员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}

		//整理下api传参
		$data = [
			"api_key"		=> '',
			"api_password"		=> '',
			"source_http_port"	=> $par['source_http_port'],	//端口
			"proxy"			=> 'false',			//WAF是否存在代理
			"proxy_ip"		=> "",				//代理地址
			"redirect_https"		=> 'false',			//HTTPS强制跳转
			"enc_https"		=> 'false',			//私钥AES加密
			"domain"		=> $par['domain_name'],	//域名
			"public_key"		=> '',				//公钥
			"private_key"		=> '',				//私钥
			"source_ip"		=> $par['source_ip'],		//服务器ip
			"http"			=> 'false',			//协议类型
			"https"			=> 'false',			//协议类型
		];	

		if ($par['http'] == 0 && $par['https'] == 0) {
			return tz_ajax_echo([],'请至少选择一项协议类型',0);
		}
		if ($par['http'] == 1) {
			$data['http']		= 'true';
		}
		if ($par['https'] == 1) {
			$data['https']		= 'true';
			$data['public_key']	= $par['public_key'];
			$data['private_key']	= $par['private_key'];
			if ($par['redirect_https'] == 1) {
				$data['redirect_https'] 	= 'true';
			}
			if ($par['enc_https'] == 1) {
				$data['enc_https'] 	= 'true';
			}
		}

		if ($par['proxy'] == 1) {
			$data['proxy'] 		= 'true';
			$data['proxy_ip'] 	= $par['proxy_ip'];
		}
		//dd($data);
		//入了我们库就配置域名去
		$api_controller = new ApiController();
		$res = $api_controller->editDomain($data);

		if (!$res['result']) {
			return tz_ajax_echo([],$res['message'],0);
		}

		return tz_ajax_echo([],'编辑域名成功',1);
	}

	//查看域名基本配置
	public function showDomain(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		
		$res = $this->apiShow($par['domain_name'] , 'showDomain');

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}
	
	/**
	 *  检测是否允许开启某项服务
	 *	@param 	$service - 套餐服务 有: 1.web_switch (web防护) ; 2.cc_switch (cc防护) ; 3.ip_switch (ip黑白名单)
	 *			$business_id - 业务的id
	 */
	public function checkSwitch($business_id,$service)
	{
		$str = 'b.'.$service ;
		$business_model = new WafBusinessModel();
		$check_switch = $business_model->leftJoin('tz_waf_package as b' , 'b.id' , '=' , 'tz_waf_business.package_id')
						->whereIn('tz_waf_business.status',[1,4])
						->where('tz_waf_business.id' , $business_id)
						->select($str)
						->first();

		if ($check_switch->$service == 1) {
			return [
				'data'	=> [],
				'msg'	=> '验证通过',
				'code'	=> 1,
			];
			
		}else {
			switch ($service) {
				case 'web_switch':
					$msg = 'web防护';
					break;
				case 'cc_switch':
					$msg = 'cc防护';
					break;
				case 'ip_switch':
					$msg = 'ip黑白名单';
					break;
				default:
					$msg = '';
					break;
			}
			return [
				'data'	=> [],
				'msg'	=> '该业务所使用套餐未开通 '. $msg.' 该项服务,建议咨询客服人员',
				'code'	=> 0,
			];
		}
	}

	//获取域名防护配置
	public function showDomainProtection(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		
		$res = $this->apiShow($par['domain_name'] , 'showDomainProtection');

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 *  修改域名防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainProtection(WafRequest $request)
	{
		$par = $request->only([ 'domain_name'  , 'owasp_protection' , 'ip_config' , 'cc_protection' ]);
	
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}

		//先检查业务所属客户是否属于操作业务员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}

		//整理下api传参
		$data = [
			'api_key'		=> '',
			'api_password'		=> '',
			'domain'		=> $par['domain_name'],
			'custom_protection'	=> 'false',	//自定义规则防护开关
			'owasp_protection'	=> 'false',	//web防护开关
			'attack_ip_protection'	=> 'false',	
			'cc_protection'		=> 'false',	//cc防护开关
			'ip_config'		=> 'false',	//IP黑白名单
			'page_custom'		=> 'false',	//拦截页面自定义
			'geoip'			=> 'false',
			'geo_protection'		=> 'false',	//地区封禁
		];
		//判断是否有开通服务资格

		if ($par['owasp_protection'] == 1) {
			$check_owasp = $this->checkSwitch($domain_info->business_id , 'web_switch');
			if ($check_owasp['code'] != 1) {
				return tz_ajax_echo([],$check_owasp['msg'],0);
			}
			$data['owasp_protection'] = 'true';
		}
		if ($par['cc_protection'] == 1) {
			$check_cc = $this->checkSwitch($domain_info->business_id , 'cc_switch');
			if ($check_cc['code'] != 1) {
				return tz_ajax_echo([],$check_cc['msg'],0);
			}
			$data['cc_protection'] = 'true';
		}
		if ($par['ip_config'] == 1) {
			$check_ip = $this->checkSwitch($domain_info->business_id , 'ip_switch');
			if ($check_ip['code'] != 1) {
				return tz_ajax_echo([],$check_ip['msg'],0);
			}
			$data['ip_config'] = 'true';
		}

		$api_controller = new ApiController();
		$res = $api_controller->editDomainProtection($data);

		if (!$res['result']) {
			return tz_ajax_echo([],$res['message'],0);
		}

		return tz_ajax_echo([],'修改域名防护配置成功',1);
	}


	//获取CC攻击防护配置
	public function showDomainCCProtection(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		
		$res = $this->apiShow($par['domain_name'] , 'showDomainCCProtection');

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 *  修改CC攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainCCProtection(WafRequest $request)
	{
		$par = $request->only([ 'domain_name'  , 'count' , 'domain_qps' , 'ip_qps' , 'black_ip_time' , 'attack_ip_expire_qps' , 'bot_check' , 'attack_count' , 'ip_expire_qps' , 'attack_ip_qps'  , 'attack_black_ip_time' , 'all_request_bot_check' ]);
		
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}

		//先检查业务所属客户是否属于操作业务员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}

		//整理下api传参
		$data = [
			'api_key'		=> '',
			'api_password'		=> '',
			'domain'		=> $par['domain_name'],
			'count'			=> $par['count'],				//cc攻击次数
			'domain_qps'		=> $par['domain_qps'],			//正常情况域名qps,域名QPS超出该值时将自动切换为人机识别防护模式
			'ip_qps'			=> $par['ip_qps'],			//单IP QPS数
			'black_ip_time'		=> $par['black_ip_time'],			//CC攻击单位时间(秒)
			'attack_ip_expire_qps'	=> '5',
			'bot_check'		=> 'false',				//智能人际识别防护
			'attack_count'		=> '100',
			'ip_expire_qps'		=> $par['ip_expire_qps'],			//单IP 延迟QPS数
			'attack_ip_qps'		=> '5',
			'attack_black_ip_time'	=> '300',
			'all_request_bot_check'	=> 'false',				//强制人际识别防护,开启后所有请求将进行人机识别防护，建议紧急情况下开启
		];

		if ($par['bot_check'] == 1) {
			$data['bot_check'] = 'true';
		}
		if ($par['all_request_bot_check'] == 1) {
			$data['all_request_bot_check'] = 'true';
		}

		if (isset($par['attack_ip_expire_qps']) ) {
			$data['attack_ip_expire_qps'] = $par['attack_ip_expire_qps'];
		}
		if (isset($par['attack_count']) ) {
			$data['attack_count'] = $par['attack_count'];
		}
		if (isset($par['attack_ip_qps']) ) {
			$data['attack_ip_qps'] = $par['attack_ip_qps'];
		}
		if (isset($par['attack_black_ip_time']) ) {
			$data['attack_black_ip_time'] = $par['attack_black_ip_time'];
		}

		$api_controller = new ApiController();
		$res = $api_controller->editDomainCCProtection($data);

		if (!$res['result']) {
			return tz_ajax_echo([],$res['message'],0);
		}

		return tz_ajax_echo([],'修改CC攻击防护配置成功',1);

	}


	//获取Web攻击防护配置
	public function showDomainWebProtection(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		
		$res = $this->apiShow($par['domain_name'] , 'showDomainWebProtection');

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}

	/**
	 *  修改Web攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainWebProtection(WafRequest $request)
	{
		$par = $request->only([ 'domain_name'  , 'white_request_bypass' , 'sql_check' , 'command_inject_check' , 'file_traversal_check_time' , 'virtual_patch_check' , 'upload_check_rule' , 'white_request_log' , 'webshell_check' , 'file_traversal_check_count' , 'black_attack_ip' , 'upload_check' , 'attack_request_log' , 'xss_check' , 'file_traversal_check' , 'file_traversal_check_ratio' , 'file_traversal_black_time' , 'sensitive_file_check' , 'anomaly_request_log' , 'directory_traversal_check' , 'owasp_protection_mode']);
		
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}

		//先检查业务所属客户是否属于操作业务员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}

		//整理下api传参
		$data = [
			'api_key'			=> '',
			'api_password'			=> '',
			'domain'			=> $par['domain_name'],
			'white_request_bypass'		=> 'false',			//正常请求放行
			'sql_check'			=> 'false',			//SQL注入攻击防护
			'command_inject_check'		=> 'false',			//命令注入防护
			'file_traversal_check_time'	=> '60',
			'virtual_patch_check'		=> 'false',			//虚拟补丁防护
			'upload_check_rule'		=> '(.jpg|.png)$',		//上传文件白名单后缀
			'white_request_log'		=> 'false',			//正常请求日志记录
			'webshell_check'			=> 'false',			//webshell防护
			'file_traversal_check_count'	=> '60',
			'black_attack_ip'			=> 'false',			//恶意IP加入黑名单
			'upload_check'			=> 'false',			//上传攻击防护开关
			'attack_request_log'		=> 'false',			//攻击请求日志记录
			'xss_check'			=> 'false',			//XSS攻击防护
			'file_traversal_check'		=> 'false',			//文件遍历检查,暂时不开
			'file_traversal_check_ratio'	=> '0.7',
			'file_traversal_black_time'	=> '3600',
			'sensitive_file_check'		=> 'false',			//敏感文件防泄漏
			'anomaly_request_log'		=> 'false',			//异常请求日志记录
			'directory_traversal_check'	=> 'false',			//目录穿越防护
			'owasp_protection_mode'	=> 'false',			//模式,防护模式:true, 观察模式:false
		];
		foreach ($par as $k => $v) {
			if ($par[$k] == 1) {
				if ($k != 'file_traversal_check_time' && $k != 'file_traversal_check_count' && $k != 'file_traversal_check_ratio' && $k != 'file_traversal_black_time') {
					$data[$k] = 'true';
				}
			}	
		}
		if (isset($par['upload_check_rule']) ) {
			$data['upload_check_rule'] = $par['upload_check_rule'];
		}
		
		//dd($data);
	
		$api_controller = new ApiController();
		$res = $api_controller->editDomainWebProtection($data);

		if (!$res['result']) {
			return tz_ajax_echo([],$res['message'],0);
		}

		return tz_ajax_echo([],'修改Web攻击防护配置成功',1);

	}


	/**
	 *  创建IP黑白名单
	 *	@param 	
	 *			-
	 */
	public function insertDomainIPRule(WafRequest $request)
	{	
		
		$par = $request->only(['domain_name' , 'rule_action' , 'ip']);
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}
		//判断操作人员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}
		//判断是否有开通服务资格
		// $check_switch = $this->checkSwitch($domain_info->business_id , 'ip_switch');
		// if ($check_switch['code'] != 1) {
		// 	return tz_ajax_echo([],$check_switch['msg'],0);
		// }

		$api_controller = new ApiController();
		$res = $api_controller->insertDomainIPRule($domain_info->domain_name , $par['rule_action'], $par['ip']);

		if (!$res['result']) {
	
			return tz_ajax_echo([],$res['message'],0);
		}
		if ($par['rule_action'] == 'allow') {
			$msg = '添加ip白名单成功';
		}else{
			$msg = '添加ip黑名单成功';
		}
		return tz_ajax_echo($res['message'],$msg,1);

	}

	/**
	 *  删除IP黑白名单
	 *	@param 	
	 *			-
	 */
	public function delDomainIPRule(WafRequest $request)
	{

		$par = $request->only(['domain_name' , 'ip']);
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $par['domain_name'])->first();

		if (!$domain_info) {
			return tz_ajax_echo([],'此域名未入库',0);
		}
		//判断操作人员
		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return tz_ajax_echo([],$check_admin['msg'],0);
		}

		$api_controller = new ApiController();
		$res = $api_controller->delDomainIPRule($domain_info->domain_name , $par['ip']);

		if (!$res['result']) {
	
			return tz_ajax_echo([],$res['message'],0);
		}
	
		return tz_ajax_echo($res['message'],'删除ip成功',1);
	}


	//查看域名黑白名单情况
	public function showDomainIPRule(WafRequest $request)
	{
		$par = $request->only(['domain_name']);
		$domain_model = new WafDomainModel();
		
		$res = $this->apiShow($par['domain_name'] , 'showDomainIPRule');

		return tz_ajax_echo($res['data'],$res['msg'],$res['code']);
	}


	public function apiShow($domain_name , $meth)
	{
		$domain_model = new WafDomainModel();
		$domain_info = $domain_model->where('domain_name' , $domain_name)->first();

		if (!$domain_info) {
			return [
				'data'	=> [],
				'msg'	=> '此域名未入库',
				'code'	=> 0
			];
		}

		$check_admin = $this->checkAdmin($domain_info->business_id);
		if ($check_admin['code'] != 1) {
			return [
				'data'	=> [],
				'msg'	=> $check_admin['msg'],
				'code'	=> 0
			];
		}

		$api_controller = new ApiController();
		switch ($meth) {
			case 'showDomainWebProtection':
				$res = $api_controller->showDomainWebProtection($domain_info->domain_name);
				$msg = '获取Web攻击防护配置成功';
				break;
			case 'showDomainIPRule':
				$res = $api_controller->showDomainIPRule($domain_info->domain_name);
				$msg = '获取域名黑白名单情况成功';

				if ($res['result']) {
					$rule = ['deny' => '黑名单' , 'allow' => '白名单'];
					foreach ($res['message'] as $k => $v) {
						$res['message'][$k]['rule_action'] = $rule[$res['message'][$k]['rule_action']];
					}
				}
				break;
			case 'showDomain':
				$res = $api_controller->showDomain($domain_info->domain_name);
				$msg = '获取域名基本配置成功';
				break;
			case 'showDomainCCProtection':
				$res = $api_controller->showDomainCCProtection($domain_info->domain_name);
				$msg = '获取CC攻击防护配置配置成功';
				break;
			case 'showDomainProtection':
				$res = $api_controller->showDomainProtection($domain_info->domain_name);
				$msg = '获取域名防护配置成功';
				break;
			default:
				# code...
				break;
		}
		

		if (!$res['result']) {
			return [
				'data'	=> [],
				'msg'	=> $res['message'],
				'code'	=> 0
			];
		}
		// foreach ($res['message'] as $k => $v) {

		// 	// if ($v == "true") {
		// 	// 	$res['message'][$k] = 1;
		// 	// }
		// 	// if ($v == "false") {
		// 	// 	$res['message'][$k] = 0;
		// 	// }
		// }
		

		return [
			'data'	=> $res['message'],
			'msg'	=> $msg,
			'code'	=> 1,
		];
	}
}