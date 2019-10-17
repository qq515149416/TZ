<?php
/**
 * 检测是否登录 中间件
 */

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Customer\ApiOut; 

class CheckApi
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$par = $request->all();
		if ( !isset($par['apiKey']) || !isset($par['hash']) || !isset($par['timestamp']) ) {
			return tz_ajax_echo(null,'非法参数',3);
		}
		$apiKey = $par['apiKey'];
		$hash = $par['hash'];
		unset($par['apiKey']);
		unset($par['hash']);
		$check = $this->checkSign($apiKey,$par,$hash);
		if ($check == false) {
			return tz_ajax_echo(null,'非法的API Key',0);
		}
		$mid_params = [ 'check_sign' => $check];

		$request->attributes->add($mid_params);
		return $next($request);
	}


	/** 
	 *  检查签名方法
	 * @param $apiKey -> 就是key, $par -> 要组成签名的元素,传过来的参数, $hash ->客户端传来的签名字符串
	 * @return 验签失败 ->false ; 验签成功 ->签名用户的id
	 */ 
	public function checkSign($apiKey , $par , $hash){ 
		//获取对应秘钥信息
 		$apply = ApiOut::where('api_key' , $apiKey)
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
}
