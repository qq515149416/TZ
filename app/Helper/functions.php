<?php
/**
 * Created by PhpStorm.
 * User: 568171152@qq.com ZhangJun
 * Date: 2018/7/26
 * Time: 16:00
 */


/**
 * AJAX 格式工具
 *
 * @author 张俊
 * @param array $data
 * @param string $info
 * @param int $code
 * @return mixed
 *
 * 前端对象输出（凡是通过ajax请求的接口都必须调用此函数输出）
 * 方法名: ajaxEcho
 * 参数：$data=[],$info="",$code=0
 * $data为要输出的数据，默认是空数组
 * $info提示信息，默认是空
 * $code错误代码，默认是0
 */
function tz_ajax_echo($data = [], $info = "", $code = 0)
{
    return response()->json(["code" => $code, "data" => $data, "msg" => $info]);
}

/**
 * 计算时间是否过期工具
 *
 * @author 张俊
 * @param $time   string|int 所判断的时间
 * @param $length  int 为时间计算过期的小时数
 * @return bool    true:未过期    false:已过期
 */
function tz_time_expire($time, $length)
{
    $deadline   = time();  //默认到期时间为现在时间
    $lengthTime = $length * 60 * 60; //小时换算成时间戳
    return ((strtotime($time) + $lengthTime) > $deadline) ? true : false; //三元运算符 判断是否过期
}

/**
 * 测试时间参数
 */
function tz_time_test()
{


}

/**
 * curl模拟请求
 * @param  [type]  $url   请求的url地址
 * @param  string  $params 需要传递的参数
 * @param  integer $return 是否返回
 * @param  array   $header 头部信息
 * @param  array   $cookie cookie
 * @param  array   $option 其他参数
 * @return [type]          [description]
 */
function curl($url, $params ='', $return = 1, $header = array(), $cookie = array(), $option = array())
{
	$ch = curl_init($url); // 初始化curl并设置链接
	// curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
	// 设置是否为post传递
	curl_setopt($ch, CURLOPT_POST, (bool)$params);
	// 对于https 设定为不验证证书和host
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, $return);//设置是否返回信息

	if($cookie)
	{
		$key = array_keys($cookie);
		curl_setopt($ch, $key[0]=='jar' ? CURLOPT_COOKIEJAR : CURLOPT_COOKIEFILE, $cookie['file']);
	}

	if($params)
	{
		if(is_array($params))
		{
			$params = http_build_query($params);
		}
		// POST 数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	}

	if($header)
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方
	}
	else
	{
		PHP_SAPI != 'cli' && isset($_SERVER['HTTP_USER_AGENT']) && curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	}

	foreach($option as $key => $val)
	{
		curl_setopt($ch, $key, $val);
	}

	$response = curl_exec($ch); // 执行并接收返回信息
	
	if(curl_errno($ch))
	{
		// 出错则显示错误信息
		exit(curl_error($ch));
	}

	if(! empty($option[CURLOPT_HEADER]))
	{
		// 获得响应结果里的：头大小
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		// 根据头大小去获取头信息内容
		$_EVN['CURL_HEADER'] = substr($response, 0, $header_size);
		$response = substr($response, $header_size);
	}

	curl_close($ch); // 关闭curl链接
	return $response;
}
