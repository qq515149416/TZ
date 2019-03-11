<?php

return [

	/*
	|--------------------------------------------------------------------------
	| 阿里支付配置信息
	|--------------------------------------------------------------------------
	|
	|   
	|
	|
	|
	*/

	'seller_id' 	=> env('SELLER_ID'),
	'domain_name' => env('APP_URL'),
	'private_key' 	=> env('ALI_PRIVATE_KEY'),
	'ali_public_key' 	=> env('ALI_PUBLIC_KEY'),
	'app_id' 	=> env('ALI_APP_ID'),
];
