<?php

namespace App\Admin\Controllers\Work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{


	
	protected $huizhou_key;         //三个地方的白名单key
	protected $hengyang_key;
	protected $xian_key; 

	/**
	 * 加载配置文件中 各地的白名单数据库key
	 */
	public function __construct()
	{
		$this->huizhou_key	= config('white_list.huizhou_key');  //加载配置文件中的API用户名
		$this->hengyang_key	= config('white_list.hengyang_key');  //加载配置文件中的API密码
		$this->xian_key	     	= config('white_list.xian_key');  //加载配置文件中的API地址
	}


	/**
	 *  添加白名单
	 */
	public function createWhiteList($domain,$room_id)
	{
		switch ($room_id) {
			//惠州机房
			case '37':	//数据库里的机房对应id
				$url 	= 'http://qy.tzidc.com/domain.php?domain='.$domain.'&key='.$this->huizhou_key;	//一次正常域名
				$url2 	= 'http://qy.tzidc.com/domain.php?domain=.'.$domain.'&key='.$this->huizhou_key;	//一次域名前加个 ' . ' 
				break;
			//衡阳机房
			case '38':	//数据库里的机房对应id
				$url 	= 'http://qy.zeisp.com/domain.php/domain.php?domain='.$domain.'&key='.$this->huizhou_key;
				$url2 	= 'http://qy.zeisp.com/domain.php/domain.php?domain=.'.$domain.'&key='.$this->huizhou_key;
				break;
			//西安机房
			case '39':	//数据库里的机房对应id
				$url 	= 'http://xa.tzidc.com/domain.php?domain='.$domain.'&key='.$this->huizhou_key;
				$url2 	= 'http://xa.tzidc.com/domain.php?domain=.'.$domain.'&key='.$this->huizhou_key;
				break;
			default:
				return [
					'data'	=> '',
					'msg'	=> '机房暂无白名单库',
					'code'	=> 0,
				];
				break;
		}

		$res = $this->executeCurl($url);
		$res2 = $this->executeCurl($url2);
		if($res&&$res2){
			$return = [
				'data'	=> '',
				'msg'	=> '域名添加通行证成功',
				'code'	=> 1,
			];
			
		}else{
			$return = [
				'data'	=> '',
				'msg'	=> '域名添加通行证失败',
				'code'	=> 0,
			];
		}
		return $return;
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
