<?php

// +----------------------------------------------------------------------
// | Author: kiri <420541662@qq.com>
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 by cmd
// +----------------------------------------------------------------------
// | Description: 处理新闻消息的模型
// +----------------------------------------------------------------------
// | @DateTime: 2018-08-01 14:21:37
// +----------------------------------------------------------------------
namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
class  News extends Model
{
   use SoftDeletes;
   
	protected $table = 'tz_news';
	protected $table2 = 'tz_news_type';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['tid', 'title','content','created_at','updated_at','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','list_order'];
	// 测试

	/**
	* 查询文章表的数据
	* @return 将数据及相关的信息返回到控制器
	*/
	public function index(){
		// 用模型进行数据查询
		$index = $this->all(['id','tid','title','content','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','created_at','updated_at','list_order']);

		if(!$index->isEmpty()){
		// 判断存在数据就对部分需要转换的数据进行数据转换的操作
			$status 	= [0=>'不显示',1=>'显示'];		
			$type = json_decode(json_encode($this->get_news_type() ),true);
			$type = $type['data'];
			$type_arr = [];
			foreach ($type as $k=> $v) {
				$type_arr[$v['tid']] = $v['type_name'];
			}
			
			foreach($index as $key=>$value) {
			// 对应的字段的数据转换
			// return 123;
				switch ($value['tid']) {
					case '0':
						$index[$key]['type_name'] 	= '无此种类';
						break;
					default:
						$index[$key]['type_name'] 	= $type_arr[$value['tid']];
						break;
				}
				
				$index[$key]['top_status'] 	= $status[$value['top_status']];
				$index[$key]['home_status'] 	= $status[$value['home_status']];
				
			}

			$return['data'] = $index;
			$return['code'] = 1;
			$return['msg'] = '获取信息成功！！';
		} else {
			$return['data'] = [];
			$return['code'] = 1;
			$return['msg'] = '暂无数据';
		}
		// 返回
		return $return;
	}


	/**
	* 对文章信息进行添加处理
	* @param  array $data 要添加的数据
	* @return array      返回的信息和状态
	*/
	public function insert($data){

		if($data){
			// 存在数据就用model进行数据写入操作
			// $fill = $this->fill($data);
		
			$row = $this->create($data);

			if($row != false){
			// 插入数据成功
				$return['data'] = $row->id;
				$return['code'] = 1;
				$return['msg'] = '消息发布成功!!';

			} else {
			// 插入数据失败
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '消息发布失败!!';
			}
		} else {
			// 未有数据传递
			$return['data'] = '';
			$return['code'] = 0;
			$return['msg'] = '请检查您要新增的信息是否正确!!';
		}
		return $return;

	}
  	 /**
	 * 对要修改的信息进行处理
	 * @param  array $data 要修改的数据
	 * @return array       返回信息和状态
	 */
	public function edit($data){
		if($data && $data['id']+0) {
			$edit = $this->find($data['id']);
			$edit->tid 		= $data['tid'];
			$edit->title 		= $data['title'];
			$edit->content 		= $data['content'];
			$edit->top_status 	= $data['top_status'];
			$edit->home_status 	= $data['home_status'];
			$edit->seoKeywords 	= $data['seoKeywords'];
			$edit->seoTitle 		= $data['seoTitle'];
			$edit->seoDescription 	= $data['seoDescription'];
			$edit->digest 		= $data['digest'];
			// $edit->list_order  	= $data['list_order'];
			$row = $edit->save();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '修改文章信息成功！！';
			} else {
				$return['code']	= 0;
				$return['msg'] 	= '修改文章信息失败！！';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '请确保信息正确';
		}
		return $return;
	}
	/**
	 * 删除文章信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function dele($id) {
		if($id) {
			$row = $this->where('id',$id)->delete();
			if($row != false){
				$return['code'] 	= 1;
				$return['msg'] 	= '删除文章信息成功';
			} else {
				$return['code'] 	= 0;
				$return['msg'] 	= '删除文章信息失败';
			}
		} else {
			$return['code'] 	= 0;
			$return['msg'] 	= '无法删除文章信息';
		}

		return $return;
	}

	/**
	* 获取文章的信息
	* @return array 返回相关的信息和数据
	*/
	public function get_news_type($id='') {
		if($id){
			$type = DB::table('tz_news_type')->find($id,['name']);
			return $type;
		} else {
			$result = DB::table('tz_news_type')->select('id as tid','name as type_name')->get();
			if($result) {
				$return['data'] = $result;
				$return['code'] = 1;
				$return['msg'] = '文章类型获取成功!!';
			} else {
				$return['data'] = '';
				$return['code'] = 0;
				$return['msg'] = '文章类型获取失败!!';
			}

			return $return;
		}
	}

	public function putImages($images){
		if($images->isValid()){
			// 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
			$clientName = $images -> getClientOriginalName();
			$tmpName = $images ->getFileName(); 
			// 这个表示的是缓存在tmp文件夹下的文件的绝对路径(这里要注意,如果我使用接下来的move方法之后, getRealPath() 就找不到文件的路径了.因为文件已经被移走了.所以这里道出了文件上传的原理,将文件上传的某个临时目录中,然后使用Php的函数将文件移动到指定的文件夹.)
			$realPath = $images -> getRealPath(); 
			// 上传文件的后缀.
			$entension = $images -> getClientOriginalExtension(); 
			// 大家对mimeType应该不陌生了. 我得到的结果是 image/jpeg.(这里要注意一点,以前我们使用 mime_content_type() ,在php5.3 之后,开始使用 fileinfo 来获取文件的mime类型.所以要加入 php_fileinfo的php拓展.windows下是 php_fileinfo.dll,在php.ini文件中将 extension=php_fileinfo.dll前面的分号去掉即可.当然要重启服务器. )
			$mimeTye = $images -> getMimeType();
			// (第一种)最后我们使用
			//$path = $images -> move('storage/uploads');
			// 如果你这样写的话,默认是会放置在 我们 public/storage/uploads/php79DB.tmp 
			// 貌似不是我们希望的,如果我们希望将其放置在app的storage目录下的uploads目录中,并且需要改名的话..
			//(第二种)
			$user_id = Admin::user()->id;
			$newName = md5(date("Y-m-d H:i:s").$clientName.'_'.$user_id).".".$entension;
			$path = $images -> move(app_path().'/../public/upload/images',$newName);
			// 这里app_path()就是app文件夹所在的路径.$newName 可以是你通过某种算法获得的文件的名称.主要是不能重复产生冲突即可. 比如 $newName = md5(date("Y-m-d H:i:s").$clientName).".".$entension;
			// 利用日期和客户端文件名结合 使用md5 算法加密得到结果.不要忘记在后面加上文件原始的拓展名.
			// 将$path入库
			
			if(Db::table('images')->insert(['file_path'=>$path])){
				return Redirect::to('file_list');
			}
		}
	}
}
