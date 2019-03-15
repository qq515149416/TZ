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
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Storage;

class  Upload extends Model
{
   // use SoftDeletes;
   
	protected $table = 'tz_upload';

	
	protected $fillable = ['name', 'path','type','describe'];
	// 测试

	public function putImages($images){

		DB::beginTransaction();

		$path_arr = [];
		for ($i=0; $i < count($images); $i++) { 
			if($images[$i]->isValid()){
				// 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
				$clientName = $images[$i] -> getClientOriginalName();
				$tmpName = $images[$i] ->getFileName(); 
				// 这个表示的是缓存在tmp文件夹下的文件的绝对路径(这里要注意,如果我使用接下来的move方法之后, getRealPath() 就找不到文件的路径了.因为文件已经被移走了.所以这里道出了文件上传的原理,将文件上传的某个临时目录中,然后使用Php的函数将文件移动到指定的文件夹.)
				$realPath = $images[$i] -> getRealPath(); 
				// 上传文件的后缀.
				$entension = $images[$i] -> getClientOriginalExtension(); 
				// 大家对mimeType应该不陌生了. 我得到的结果是 image/jpeg.(这里要注意一点,以前我们使用 mime_content_type() ,在php5.3 之后,开始使用 fileinfo 来获取文件的mime类型.所以要加入 php_fileinfo的php拓展.windows下是 php_fileinfo.dll,在php.ini文件中将 extension=php_fileinfo.dll前面的分号去掉即可.当然要重启服务器. )
				$mimeTye = $images[$i] -> getMimeType();
				// (第一种)最后我们使用
				//$path = $images[$i] -> move('storage/uploads');
				// 如果你这样写的话,默认是会放置在 我们 public/storage/uploads/php79DB.tmp 
				// 貌似不是我们希望的,如果我们希望将其放置在app的storage目录下的uploads目录中,并且需要改名的话..
				//(第二种)
				$user_id = Admin::user()->id;
				$newName = md5(date("Y-m-d H:i:s").$clientName.'_'.$user_id).".".$entension;
				// $path = $images[$i] -> move(app_path().'/../public/upload/images',$newName);
				$path = $images[$i] -> move(base_path().'/public/upload/images',$newName);
				
				// 这里app_path()就是app文件夹所在的路径.$newName 可以是你通过某种算法获得的文件的名称.主要是不能重复产生冲突即可. 比如 $newName = md5(date("Y-m-d H:i:s").$clientName).".".$entension;
				// 利用日期和客户端文件名结合 使用md5 算法加密得到结果.不要忘记在后面加上文件原始的拓展名.
				// 将$path入库

				$data = [
					'name'		=> $newName,
					'path'		=> $path,
					'type'		=> 1,
					'describe'	=> '文章上传图片',
				];

				if(!Db::table('tz_upload')->insert($data)){
					DB::rollBack();
					return [
						'data'	=> [],
						'msg'	=> '入库失败',
						'code'	=> 0,
					];
				}
				$path_arr[] = realpath($path);
			}
		}
		DB::commit();
		return [
			'data'	=> $path_arr,
			'msg'	=> '上传成功',
			'code'	=> 1,
		];
	}

	public function showImages(){
		$images = $this->where('type',1)->get();
		if($images->isEmpty()){
			return [
				'data'	=> [],
				'msg'	=> '库内无已上传文件',
				'code'	=> 1,
			];
		}
		
		return [
			'data'	=> $images,
			'msg'	=> '获取成功',
			'code'	=> 1,
		];
	}

	public function del($file_id){
		$file = $this->find($file_id);
		if($file == null){
			return [
				'data'	=> [],
				'msg'	=> '无此id',
				'code'	=> 0,
			];
		}
		switch ($file->type) {
			case '1':			//如果是图片
				$path = str_replace($file->name, '', $file->path);

				$disk = Storage::disk('public');
				
		        		// 取出文件
		        		$file = $disk->get('/upload/images/'.$file->name);
		        		dd($file);
				break;
			
			default:
				return [
					'data'	=> [],
					'msg'	=> '暂时无法删除',
					'code'	=> 0,
				];
				break;
		}
	}
}
