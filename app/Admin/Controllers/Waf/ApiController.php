<?php

namespace App\Admin\Controllers\Waf;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

	protected $api_key;  //用户名
	protected $api_password; //密码

	/**
	 * 加载配置文件中 帐号密码
	 */
	public function __construct()
	{
		$this->api_key = config('tz_waf.api_key');  //加载配置文件中的API用户名
		$this->api_password = config('tz_waf.api_password');  //加载配置文件中的API密码
	}

	/**
	 * 执行CURL
	 */
	protected function executeCurl($url,$data=null,$questType)
	{


		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $questType);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
		);

		$result = curl_exec($ch);
		curl_close($ch);//关闭curl
		return $result;

	}



	/**
	 *  添加域名
	 *	@param 	
	 *	$data = [
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
			"https"			=> 'false'			//协议类型
		];		-
	 */
	public function insertDomain($data)
	{

		$data['api_key'] 		= $this->api_key;
		$data['api_password'] 	= $this->api_password;

		$url='https://api.jxwaf.com/api/waf_create_domain';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  删除域名
	 *	@param 	
	 *			-
	 */
	public function delDomain($domain_name)
	{

		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];

		$url='https://api.jxwaf.com/api/waf_del_domain';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  编辑域名
	 *	@param 	
	 *			-
	 */
	public function editDomain($data)
	{
		$data['api_key'] 		= $this->api_key;
		$data['api_password'] 	= $this->api_password;

		$url='https://api.jxwaf.com/api/waf_edit_domain';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  展示域名配置
	 *	@param 	
	 *			-
	 */
	public function showDomain($domain_name)
	{
		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];
		$url='https://api.jxwaf.com/api/waf_get_domain';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}


	/**
	 *  获取域名防护配置
	 *	@param 	
	 *			-
	 */
	public function showDomainProtection($domain_name)
	{
		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];
		$url='https://api.jxwaf.com/api/waf_get_protection';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  修改域名防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainProtection($data)
	{
		// $data = [
		// 	'api_key'		=> $this->api_key,
		// 	'api_password'		=> $this->api_password,
		// 	'domain'		=> 'www.baidu2.com',
		// 	'custom_protection'	=> 'false',	//自定义规则防护开关
		// 	'owasp_protection'	=> 'false',	//web防护开关
		// 	'attack_ip_protection'	=> 'false',	
		// 	'cc_protection'		=> 'false',	//cc防护开关
		// 	'ip_config'		=> 'false',	//IP黑白名单
		// 	'page_custom'		=> 'false',	//拦截页面自定义
		// 	'geoip'			=> 'false',
		// 	'geo_protection'		=> 'false',	//地区封禁
		// ];

		$data['api_key'] 		= $this->api_key;
		$data['api_password'] 	= $this->api_password;
		//dd($data);
		$url='https://api.jxwaf.com/api/waf_edit_protection';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  获取CC攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function showDomainCCProtection($domain_name)
	{

		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];

		$url='https://api.jxwaf.com/api/waf_get_cc_protection';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	/**
	 *  修改CC攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainCCProtection($data)
	{
		//示范
		// $data = [
		// 	'api_key'		=> $this->api_key,
		// 	'api_password'		=> $this->api_password,
		// 	'domain'		=> $domain_name,
		// 	'count'			=> '600',	//cc攻击次数
		// 	'domain_qps'		=> '2000',	//正常情况域名qps,域名QPS超出该值时将自动切换为人机识别防护模式
		// 	'ip_qps'			=> '10',		//单IP QPS数
		// 	'black_ip_time'		=> '60',		//CC攻击单位时间(秒)
		// 	'attack_ip_expire_qps'	=> '5',
		// 	'bot_check'		=> 'true',	//智能人际识别防护
		// 	'attack_count'		=> '100',
		// 	'ip_expire_qps'		=> '10',		//单IP 延迟QPS数
		// 	'attack_ip_qps'		=> '5',
		// 	'attack_black_ip_time'	=> '300',
		// 	'all_request_bot_check'	=> 'false',	//强制人际识别防护,开启后所有请求将进行人机识别防护，建议紧急情况下开启
		// ];

		$data['api_key'] 		= $this->api_key;
		$data['api_password'] 	= $this->api_password;

		$url='https://api.jxwaf.com/api/waf_edit_cc_protection';//可能是这个cc_protection
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;
	}
	
	/**
	 *  获取Web攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function showDomainWebProtection($domain_name)
	{

		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];
		
		$url='https://api.jxwaf.com/api/waf_get_owasp_check';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}
	
	/**
	 *  修改Web攻击防护配置
	 *	@param 	
	 *			-
	 */
	public function editDomainWebProtection($data)
	{
		//参数格式例子
		// $data = [
		// 	'api_key'			=> $this->api_key,
		// 	'api_password'			=> $this->api_password,
		// 	'domain'			=> $domain_name,
		// 	'white_request_bypass'		=> 'true',	//正常请求放行
		// 	'sql_check'			=> 'true',	//SQL注入攻击防护
		// 	'command_inject_check'		=> 'true',	//命令注入防护
		// 	'file_traversal_check_time'	=> '60',
		// 	'virtual_patch_check'		=> 'true',	//虚拟补丁防护
		// 	'upload_check_rule'		=> '(.jpg|.png)$',//上传文件白名单后缀
		// 	'white_request_log'		=> 'true',	//正常请求日志记录
		// 	'webshell_check'			=> 'true',	//webshell防护
		// 	'file_traversal_check_count'	=> '60',
		// 	'black_attack_ip'			=> 'true',	//恶意IP加入黑名单
		// 	'upload_check'			=> 'false',	//上传攻击防护开关
		// 	'attack_request_log'		=> 'true',	//攻击请求日志记录
		// 	'xss_check'			=> 'true',	//XSS攻击防护
		// 	'file_traversal_check'		=> 'false',	//文件遍历检查,暂时不开
		// 	'file_traversal_check_ratio'	=> '0.7',
		// 	'file_traversal_black_time'	=> '3600',
		// 	'sensitive_file_check'		=> 'true',	//敏感文件防泄漏
		// 	'anomaly_request_log'		=> 'true',	//异常请求日志记录
		// 	'directory_traversal_check'	=> 'true',	//目录穿越防护
		// 	'owasp_protection_mode'	=> 'true',	//模式,防护模式:true, 观察模式:false
		// ];
		$data['api_key'] 		= $this->api_key;
		$data['api_password'] 	= $this->api_password;

		$url='https://api.jxwaf.com/api/waf_edit_owasp_check';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;
	}

	/**
	 *  创建IP黑白名单
	 *	@param 	
	 *			-
	 */
	public function insertDomainIPRule($domain_name , $rule_action , $ip)
	{
		$data = [
			'api_key'			=> $this->api_key,
			'api_password'			=> $this->api_password,
			'domain'			=> $domain_name,
			'rule_action'			=> $rule_action,//(deny / allow)
			'ip'				=> $ip,	
		];

		$url='https://api.jxwaf.com/api/waf_create_ip_rule';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;
	}

	/**
	 *  删除IP黑白名单
	 *	@param 	
	 *			-
	 */
	public function delDomainIPRule($domain_name , $ip)
	{
		$data = [
			'api_key'			=> $this->api_key,
			'api_password'			=> $this->api_password,
			'domain'			=> $domain_name,
			'ip'				=> $ip,
			
		];

		$url='https://api.jxwaf.com/api/waf_del_ip_rule';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;
	}
	
	/**
	 *  查看IP黑白名单列表
	 *	@param 	
	 *			-
	 */
	public function showDomainIPRule($domain_name)
	{

		$data = [
			'api_key'	=> $this->api_key,
			'api_password'	=> $this->api_password,
			'domain'	=> $domain_name,
		];

		$url='https://api.jxwaf.com/api/waf_get_ip_rule_list';
		$res = $this->executeCurl($url,$data,'POST');
		$res = json_decode($res,true);
		if (!$res) {
			$res = [
				'result' 		=> false,
				'message'	=> '接口无响应',
			];
		}
		return $res;

	}

	


}
