<?php

return [

	/*
	|--------------------------------------------------------------------------
	| 微信支付配置信息
	|--------------------------------------------------------------------------
	|
	|   
	|
	|
	|
	*/

		'app_id' 		=> env('WECHAT_APP_ID'),			// 微信公众号 APPID
		'mch_id' 	=> env('WECHAT_MCH_ID'),			// 微信商户号
		'key' 		=> env('WECHAT_KEY'),				// 微信支付签名秘钥
		'cert_client' 	=> env('WECHAT_CERT_PATH'),				// 客户端证书路径，退款时需要用到
		'cert_key' 	=> env('WECHAT_KEY_PATH'),				// 客户端秘钥路径，退款时需要用到
		'tz_url'        	=> env('APP_URL'),				// 官网
];
