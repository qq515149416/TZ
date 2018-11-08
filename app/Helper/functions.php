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
 * 模拟请求
 * @param  string $url          需要请求的url
 * @param  array/string $request_data 需要传递的值
 * @param  string $method       传输方式,默认为get
 * @return [type]               返回信息
 */
function simulation_request($url,$request_data,$method = 'get'){
	if(!$url){
		return '需传递访问的url';
	}

	if(!$request_data){
		return '需传递的数据';
	}
	$post_url = $url;//需要访问的url
	$post_data = $request_data;//需要传递的数据
	switch ($method) {
		case 'get':
			$init = curl_init();
			curl_setopt($init, CURLOPT_URL, $post_url);//url处理
			curl_setopt($init, CURLOPT_HEADER, 0);//header头
			curl_setopt($init, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($init, CURLOPT_SSL_VERIFYPEER, false);//跳过证书检查
			curl_setopt($init, CURLOPT_SSL_VERIFYHOST, false);//从证书检验算法是否存在
			$result = curl_exec($init);//运行curl
			curl_close($init);
			break;

		case 'post':
			$init = curl_init($post_url);//初始化
			curl_setopt($init,CURLOPT_CUSTOMREQUEST,'POST');//post提交方式
			curl_setopt($init,CURLOPT_POSTFIELDS,$post_data);//传输数据
			curl_setopt($init,CURLOPT_RETURNTRANSFER,true);//
			curl_setopt($init,CURLOPT_SSL_VERIFYPEER,FALSE);//跳过证书检查
			curl_setopt($init, CURLOPT_TIMEOUT, 60);//超时
			curl_setopt($init, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($post_data);
			));
			$result = curl_exec($init);//运行curl
			curl_close($init);
			break;

		default:
			
			break;
	}
	return $result;

}