<?php

namespace App\Admin\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Business\OrdersModel;
use Illuminate\Http\Request;
use App\Admin\Requests\Business\OrdersRequest;
// use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

/**
 * 
 */
class WechatController extends Controller
{
	use ModelForm;
	protected $access_token = '';

	public function __construct(Request $request){

		if( !Cache::has('access_token') ){
			$APPID 	= config('wechat.wechat_appid');
			$APPSECRET 	= config('wechat.wechat_appsecret');
			$ac_token_url 	= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
			$access_token 	= $this->executeCurl($ac_token_url);
			$access_token 	= json_decode($access_token,true);
			if(isset($access_token['errcode'])){
				return $access_token['errmsg'];
			}
			//过期时间还没弄
			Cache::put('access_token', $access_token['access_token'], 1);
		}
		$check = Cache::get('access_token');

		dd($check);
		
		dd($res);
	}

	public function test(Request $request){
		// $res = $request->session()->get('access_token');
		Cache::put('test','666', 1);
		
	}

	public function test2(Request $request){
		$res = Cache::get('test');
		dd($res);
	}

	/**
	 * 执行CURL
	 */
	protected function executeCurl($url)
	{
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL, $url);//设置url属性
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //内容作为变量储存
		curl_setopt($ch, CURLOPT_HEADER, 0);  //关闭获取头部信息
		$output = curl_exec($ch);//获取数据
		curl_close($ch);//关闭curl
		return $output;
	}
}
