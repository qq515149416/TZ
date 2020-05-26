<?php

namespace App\Admin\Requests\Waf;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WafRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * 规则.
	 *
	 * @return array
	 */
	public function rules()
	{
		$path_info = Request()->getPathInfo();
		$arr = explode('/',$path_info);
		$method = $arr[count($arr)-1];
		$return = [];
		$par = $this->only(['edit_id']);
		
		switch ($method) {
			
			case 'insert':
				$return = [
	
					'name'				=> 'required', 
					'description'			=> 'required', 
					'https_switch'			=> 'required|in:0,1', 
					'web_switch'			=> 'required|in:0,1', 
					'cc_switch'			=> 'required|in:0,1', 
					'ip_switch'			=> 'required|in:0,1', 
					'price'				=> 'required|numeric', 
					'domain_num'			=> 'required|integer', 
					'sell_status'			=> 'in:0,1', 
				];
				break;
			case 'del':
				$return = [
					'del_id'				=> 'required|exists:tz_waf_package,id', 
			
				];
				break;
			case 'edit':
				$return = [
					'edit_id'				=> 'required|exists:tz_waf_package,id', 
					'sell_status'			=> 'in:0,1', 
			
				];
				break;
			case 'show':
				$return = [
					'sell_status'			=> 'required|in:0,1,*',
				];
				break;
			case 'examine':
				$return = [
					'business_id'			=> 'required|exists:tz_waf_business,id', 
					'res'				=> 'required|in:3,4',
				];
				break;
			case 'renewByAdmin':
				$return = [
					'business_id'			=> 'required|exists:tz_waf_business,id',	
					'buy_time'			=> 'required|integer',
					'start_time'			=> 'integer',
				];
				break;
			case 'buyNowByAdmin':
				$return = [
					'package_id'			=> 'required|exists:tz_waf_package,id', 
					'price'				=> 'numeric',
					'user_id'				=> 'required|exists:tz_users,id',
				];
				break;
			case 'showBusiness':
				$return = [
					'user_id'				=> 'required|exists:tz_users,id', 
				];
				break;
			case 'editDomain':
			case 'insertDomain':
				$return = [
					'business_id'			=> 'required|exists:tz_waf_business,id', 
					'domain_name'			=> 'required',
					'source_ip'			=> 'required|ip',
					'source_http_port'		=> 'required',
					'http'				=> 'required|boolean',
					'https'				=> 'required|boolean',
					'public_key'			=> 'required_if:https,1',
					'private_key'			=> 'required_if:https,1',
					'enc_https'			=> 'required_if:https,1|boolean',
					'redirect_https'			=> 'required_if:https,1|boolean',
					'proxy'				=> 'required|in:1,0',
					'proxy_ip'			=> 'required_if:proxy,1|ip'
				];
				break;
			
			case 'showDomainProtection':
			case 'showDomainWebProtection':	
			case 'showDomainCCProtection':
			case 'showDomain':
			case 'delDomain':
			case 'showDomainIPRule':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
				];
				break;
			case 'insertDomainIPRule':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
					'rule_action' 			=> 'required|in:allow,deny', 
					'ip'				=> 'required|ip'
				];
				break;
			case 'delDomainIPRule':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
					'ip'				=> 'required|ip'
				];
				break;
			case 'editDomainWebProtection':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
					'white_request_bypass'		=> 'required|boolean',		//正常请求放行
					'sql_check'			=> 'required|boolean',		//SQL注入攻击防护
					'command_inject_check'		=> 'required|boolean',		//命令注入防护
					// 'file_traversal_check_time'	=> '数字',
					'virtual_patch_check'		=> 'required|boolean',		//虚拟补丁防护
					// 'upload_check_rule'		=> 'required_if:upload_check,1',	//上传文件白名单后缀 ,格式:'(.jpg|.png)$'
					'white_request_log'		=> 'required|boolean',		//正常请求日志记录
					'webshell_check'			=> 'required|boolean',		//webshell防护
					// 'file_traversal_check_count'	=> '数字',
					'black_attack_ip'			=> 'required|boolean',		//恶意IP加入黑名单
					'upload_check'			=> 'required|boolean',		//上传攻击防护开关
					'attack_request_log'		=> 'required|boolean',		//攻击请求日志记录
					'xss_check'			=> 'required|boolean',		//XSS攻击防护
					// 'file_traversal_check'		=> 'required|boolean',		//文件遍历检查,暂时不开
					//'file_traversal_check_ratio'	=> '0.7',
					//'file_traversal_black_time'	=> '3600',
					'sensitive_file_check'		=> 'required|boolean',		//敏感文件防泄漏
					'anomaly_request_log'		=> 'required|boolean',		//异常请求日志记录
					'directory_traversal_check'	=> 'required|boolean',		//目录穿越防护
					'owasp_protection_mode'	=> 'required|boolean',		//模式,防护模式:true, 观察模式:false
				];
				break;
			case 'editDomainCCProtection':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
					'count'				=> 'required|integer',		//cc攻击次数
					'domain_qps'			=> 'required|integer',		//正常情况域名qps,域名QPS超出该值时将自动切换为人机识别防护模式
					'ip_qps'				=> 'required|integer',		//单IP QPS数
					'black_ip_time'			=> 'required|integer',		//CC攻击单位时间(秒)
					// 'attack_ip_expire_qps'		=> 'required|integer',
					'bot_check'			=> 'required|boolean',		//智能人际识别防护
					// 'attack_count'			=> 'required|integer',
					'ip_expire_qps'			=> 'required|integer',		//单IP 延迟QPS数
					// 'attack_ip_qps'			=> 'required|integer',
					// 'attack_black_ip_time'		=> 'required|integer',
					'all_request_bot_check'		=> 'required|boolean',		//强制人际识别防护,开启后所有请求将进行人机识别防护，建议紧急情况下开启
				];
				break;
			case 'editDomainProtection':
				$return = [
					'domain_name'			=> 'required|exists:tz_waf_domain,domain_name', 
					//'custom_protection'		=> 'required|boolean',		//自定义规则防护开关
					'owasp_protection'		=> 'required|boolean',		//web防护开关
					//'attack_ip_protection'		=> 'required|boolean',		
					'cc_protection'			=> 'required|boolean',		//cc防护开关
					'ip_config'			=> 'required|boolean',		//IP黑白名单
					//'page_custom'			=> 'required|boolean',		//拦截页面自定义
					// 'geoip'			=> '',
					//'geo_protection'			=> 'required|boolean',		//地区封禁		
				];

				break;
	 			
			default:
	
				break;
		}

		return $return;
	}

	public function messages()
	{

		return  [
			'name.required'				=> '请填写套餐名称',
			'description.required'			=> '请填写套餐描述',
			'https_switch.required'			=> '请选择可否配置https',
			'https_switch.in'				=> '选项不存在',
			'web_switch.required'			=> '请选择可否开启web防护',
			'web_switch.in'				=> '选项不存在',
			'cc_switch.required'			=> '请选择可否开启cc防护',
			'cc_switch.in'				=> '选项不存在',
			'ip_switch.required'			=> '请选择可否开启ip黑白名单功能',
			'ip_switch.in'				=> '选项不存在',
			'price.required'				=> '请填写价格',
			'price.numeric'				=> '价格格式错误',
			'domain_num.required'			=> '请填写可添加域名数量',
			'domain_num.integer'			=> '域名数量格式错误',
			'edit_id.required'			=> '请选择更新的套餐',
			'edit_id.exists'				=> '套餐不存在',
			'del_id.required'				=> '请选择删除的套餐',
			'del_id.exists'				=> '套餐不存在',
			'sell_status.required'			=> '请选择查看套餐状态',
			'sell_status.in'				=> '请选择查看套餐状态',

			'package_id.required'			=> '请选择套餐',
			'package_id.exists'			=> '套餐不存在',
			'user_id.required'			=> '请选择用户',
			'user_id.exists'				=> '用户不存在',

			'business_id.required'			=> '请选择业务',
			'business_id.exists'			=> '业务不存在',
			'res.required'				=> '请选择审核结果',
			'res.in'					=> '只能选择通过或不通过',

			'buy_time.required'			=> '请填写购买时长',
			'buy_time.integer'			=> '购买时长需为整数',
			'start_time.integer'			=> '业务计费开始时间格式错误',

			'domain_name.required'			=> '请填写需配置域名',
			'source_ip.required'			=> '服务器ip必须填写',
			'source_ip.ip'				=> '服务器ip格式错误',

			'source_http_port.required'		=> '端口必须填写',
			'http.required'				=> '请选择协议类型',
			'https.required'				=> '请选择协议类型',
			'http.boolean'				=> '协议类型错误',
			'https.boolean'				=> '协议类型错误',

			'public_key.required_if'			=> '请输入公钥',
			'private_key.required_if'			=> '请输入私钥',

			'enc_https.required_if'			=> '是否开启私钥AES加密',
			'enc_https.boolean'			=> '是否开启私钥AES加密',
			'redirect_https.required_if'		=> '是否开启http强制跳转https',
			'redirect_https.boolean'			=> '是否开启http强制跳转https',

			'proxy.required'				=> 'WAF是否存在代理',
			'proxy.boolean'				=> 'WAF是否存在代理',
			'proxy_ip.required_if'			=> '代理地址不能为空',
			'proxy_ip.ip'				=> '代理地址格式错误',

			'domain_name.required'			=> '请选择域名',
			'domain_name.exists'			=> '域名不存在',

			'rule_action.required' 			=> '请选择允许阻断或放行',
			'rule_action.in' 				=> '请选择允许阻断或放行',
			'ip.required' 				=> '请填写ip',
			'ip.ip' 					=> 'ip格式错误',

			'white_request_bypass.required'		=> '正常请求放行 是否开启?',
			'white_request_bypass.boolean'		=> '参数格式错误',
			
			'sql_check.required'			=> 'SQL注入攻击防护 是否开启?',
			'sql_check.boolean'			=> '参数格式错误',

			'command_inject_check.required'	=> '命令注入防护 是否开启?',
			'command_inject_check.boolean'		=> '参数格式错误',

			'virtual_patch_check.required'		=> '虚拟补丁防护 是否开启?',
			'virtual_patch_check.boolean'		=> '参数格式错误',

			'webshell_check.required'		=> 'webshell防护 是否开启?',
			'webshell_check.boolean'		=> '参数格式错误',

			'white_request_log.required'		=> '正常请求日志记录 是否开启?',
			'white_request_log.boolean'		=> '参数格式错误',

			'black_attack_ip.required'		=> '恶意IP加入黑名单 是否开启?',
			'black_attack_ip.boolean'			=> '参数格式错误',

			'upload_check.required'			=> '上传攻击防护开关 是否开启?',
			'upload_check.boolean'			=> '参数格式错误',

			'attack_request_log.required'		=> '攻击请求日志记录 是否开启?',
			'attack_request_log.boolean'		=> '参数格式错误',

			'xss_check.required'			=> 'XSS攻击防护 是否开启?',
			'xss_check.boolean'			=> '参数格式错误',

			'sensitive_file_check.required'		=> '敏感文件防泄漏 是否开启?',
			'sensitive_file_check.boolean'		=> '参数格式错误',

			'anomaly_request_log.required'		=> '异常请求日志记录 是否开启?',
			'anomaly_request_log.boolean'		=> '参数格式错误',

			'directory_traversal_check.required'	=> '目录穿越防护 是否开启?',
			'directory_traversal_check.boolean'	=> '参数格式错误',

			'owasp_protection_mode.required'	=> '模式,防护模式:true, 观察模式:false ?',
			'owasp_protection_mode.boolean'	=> '参数格式错误',
			
			'count.required'				=> '请填写cc攻击次数',
			'count.integer'				=> '参数格式错误',

			'domain_qps.required'			=> '请填写正常情况域名qps',
			'domain_qps.integer'			=> '参数格式错误',

			'ip_qps.required'			=> '请填写单IP QPS数',
			'ip_qps.integer'				=> '参数格式错误',

			'black_ip_time.required'			=> '请填写CC攻击单位时间(秒)',
			'black_ip_time.integer'			=> '参数格式错误',

			'bot_check.required'			=> '智能人际识别防护 是否开启',
			'bot_check.boolean'			=> '参数格式错误',

			'ip_expire_qps.required'			=> '请填写 单IP 延迟QPS数',
			'ip_expire_qps.integer'			=> '参数格式错误',

			'all_request_bot_check.required'		=> '强制人际识别防护 是否开启',
			'all_request_bot_check.boolean'		=> '参数格式错误',

			'custom_protection.required'		=> '自定义规则防护 是否开启',
			'custom_protection.boolean'		=> '参数格式错误',

			'owasp_protection.required'		=> 'web防护 是否开启',
			'owasp_protection.boolean'		=> '参数格式错误',

			'ip_config.required'			=> 'IP黑白名单 是否开启',
			'ip_config.boolean'			=> '参数格式错误',

			'cc_protection.required'			=> 'cc防护 是否开启',
			'cc_protection.boolean'			=> '参数格式错误',

			'page_custom.required'			=> '拦截页面自定义 是否开启',
			'page_custom.boolean'			=> '参数格式错误',

			'geo_protection.required'		=> '地区封禁 是否开启',
			'geo_protection.boolean'			=> '参数格式错误',		
		];
	}

	/**
	 * 重新定义数据字段返回的提示信息
	 */
	public function failedValidation(Validator $validator) {
		$msg = $validator->errors()->first();
		header('Content-type:application/json');
        header('Cache-control:no-cache');
        exit('{"code": 0,"data":[],"msg":"'.$msg.'"}'); 
	}
}
