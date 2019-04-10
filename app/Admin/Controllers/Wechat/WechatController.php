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
		//判断通行证缓存是否存在

		if( !Cache::has('access_token') ){
			//获取公众号配置信息
			$APPID 		= config('wechat.wechat_appid');
			$APPSECRET 	= config('wechat.wechat_appsecret');
			//拼url获取通行证
			$ac_token_url 	= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
			$access_token 	= $this->executeCurl($ac_token_url);
			$access_token 	= json_decode($access_token,true);
			//判断返回信息
			if(isset($access_token['errcode'])){
				return [
					'data'	=> [],
					'msg'	=> $access_token['errmsg'],
					'code'	=> 0,
				];
			}
			//目前过期时间为7200秒,换算成分钟,因为缓存函数用的是分钟,-1是为了无缝衔接
			$expires_time = $access_token['expires_in']/60-1;
			//获取成功推到缓存里
			Cache::put('access_token', $access_token['access_token'], $expires_time);
		}

		//获取通行证
		$check = Cache::get('access_token');
		if($check == null){
			return [
				'data'	=> [],
				'msg'	=> '获取通行证失败',
				'code'	=> 0,
			];
		}
		//赋值
		$this->access_token = $check;
	}
	
	public function test(Request $request){
		$url 		= 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->access_token;
		$param 	= [
					'touser'		=> 'oAbLP50bLyG6jsaJH0oGOrNxJdKo',
					'template_id'	=> 'oxoFr5nVvldmXCeB0kScayuaRK6HuFwfAb1i1j_4AW4',
					'url'		=> 'www.baidu.com',
					'topcolor'	=> '#FF0000',
					'data'		=> [
								'user'	=> [
										'value'	=> 'a',
										'color'	=> '#173177',
									],
								'name'	=> [
										'value'	=> 'b',
										'color'	=> '#173177',
									],
								'price'	=> [
										'value'	=> '人民币 1000.00 元',
										'color'	=> '#173177',
									],
								'num'	=> [
										'value'	=> '1件',
										'color'	=> '#173177',
									],
								'allPrice'	=> [
										'value'	=> '人民币 1000.00 元',
										'color'	=> '#173177',
									],
								'buyTime'	=> [
										'value'	=> '2019-04-04 15:43:00',
										'color'	=> '#173177',
									],
							],
					];

		dd($this->request_post($url , json_encode($param)));	
	}
	public function buySuccess(Request $request){
		$touser = 'oAbLP50bLyG6jsaJH0oGOrNxJdKo';
		$data = [
				'user'	=> [
						'value'	=> 'a',
						'color'	=> '#173177',
					],
				'name'	=> [
						'value'	=> 'b',
						'color'	=> '#173177',
					],
				'price'	=> [
						'value'	=> '人民币 1000.00 元',
						'color'	=> '#173177',
					],
				'num'	=> [
						'value'	=> '1件',
						'color'	=> '#173177',
					],
				'allPrice'	=> [
						'value'	=> '人民币 1000.00 元',
						'color'	=> '#173177',
					],
				'buyTime'	=> [
						'value'	=> '2019-04-04 15:43:00',
						'color'	=> '#173177',
					],
			];
		$template_id = 'oxoFr5nVvldmXCeB0kScayuaRK6HuFwfAb1i1j_4AW4';
		$res = $this->templateMsg($touser,$template_id,$data,);
		dd($res);
	}

	protected function templateMsg($touser,$template_id,$data){
		$url 		= 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->access_token;
		$param 	= [
					'touser'		=> $touser,
					'template_id'	=> $template_id,
					'url'		=> 'www.baidu.com',
					'topcolor'	=> '#FF0000',
					'data'		=> $data,
					];

		$res = $this->request_post($url , json_encode($param));	
		$res = json_decode($res,true);
		if($res['errcode'] != 0){
			return false;
		}else{
			return true;
		}
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

	protected function request_post($url = '', $param = '') {
		if (empty($url) || empty($param)) {
			return false;
		}

		$postUrl = $url;
		$curlPost = $param;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);

		return $data;
	}
}
