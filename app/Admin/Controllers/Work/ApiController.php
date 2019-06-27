<?php

namespace App\Admin\Controllers\Work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Models\Idc\MachineRoom;

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
		
		$roomModel = new MachineRoom();
		$info = $roomModel->find($room_id);
		if($info == null){
			return [
				'data'	=> '',
				'msg'	=> '机房不存在',
				'code'	=> 0,
			];
		}
		if(trim($info->white_list_add) == '' || trim($info->white_list_key) == ''){
			return [
				'data'	=> '',
				'msg'	=> '机房暂无白名单接口,请设置',
				'code'	=> 0,
			];
		}
		$key 	= $info->white_list_key;
		$url 	= $info->white_list_add.'/domain.php?domain='.$domain.'&key='.$this->$key;
		$url2 	= $info->white_list_add.'/domain.php?domain=.'.$domain.'&key='.$this->$key;
		//真实环境用这个过白
		$res = $this->executeCurl($url);
		$res2 = $this->executeCurl($url2);
		// dd($url.'<br>'.$url2);
		//测试的用这一个
		// $res = true;
		// $res2 = true;

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
	 *  删除白名单接口
	 */
	public function delWhiteList($domain,$room_id)
	{
		
		$roomModel = new MachineRoom();
		$info = $roomModel->find($room_id);
		if($info == null){
			return [
				'data'	=> '',
				'msg'	=> '机房不存在',
				'code'	=> 0,
			];
		}
		if(trim($info->white_list_add) == '' || trim($info->white_list_key) == ''){
			return [
				'data'	=> '',
				'msg'	=> '机房暂无白名单接口,请设置',
				'code'	=> 0,
			];
		}
		$key 	= $info->white_list_key;
		$url 	= $info->white_list_add.'/deletedomain.php?domain='.$domain.'&key='.$this->$key;
		$url2 	= $info->white_list_add.'/deletedomain.php?domain=.'.$domain.'&key='.$this->$key;
		//真实环境用这个过白
		$res = $this->executeCurl($url);
		$res2 = $this->executeCurl($url2);
		// dd($url.'<br>'.$url2);
		//测试的用这一个
		// $res = true;
		// $res2 = true;

		if($res&&$res2){
			$return = [
				'data'	=> '',
				'msg'	=> '域名删除通行证成功',
				'code'	=> 1,
			];
			
		}else{
			$return = [
				'data'	=> '',
				'msg'	=> '域名删除通行证失败',
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
