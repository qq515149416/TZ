<?php


namespace App\Http\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class  News extends Model
{

	protected $table = 'tz_news'; //表

	protected $primaryKey = 'id'; //主键

	protected $fillable = ['tid', 'title','content','created_at','updated_at','top_status','home_status','seoKeywords','seoTitle','seoDescription','digest','list_order'];

	/**
	* 按类型获取文章消息列表
	* @param  $tid 		文章消息类型的id
	* @return 将数据及相关的信息返回到控制器
	*/

	public function getNewsList($tid,$home_status)
	{
		if($home_status == 1){
			$news_top 	= $this->select('id','title','created_at','digest')->where('tid',$tid)->where('top_status',1)->where('home_status',1)->orderBy('created_at','desc')->get();
			$news_notop 	= $this->select('id','title','created_at','digest')->where('tid',$tid)->where('top_status',0)->where('home_status',1)->orderBy('created_at','desc')->get();
		}else{
			$news_top 	= $this->select('id','title','created_at','digest')->where('tid',$tid)->where('top_status',1)->orderBy('created_at','desc')->get();
			$news_notop 	= $this->select('id','title','created_at','digest')->where('tid',$tid)->where('top_status',0)->orderBy('created_at','desc')->get();
		}
		
		if(count($news_top) == 0 && count($news_notop) == 0){
			$news = false;
		}else{
			$news['top']	= $news_top;
			$news['notop']	= $news_notop;
		}
		
		return $news;
	}


	/**
	* 按类型获取文章消息列表
	* @param  $id 		文章消息的id
	* @return 将数据及相关的信息返回到控制器
	*/
	public function getNewsDetails($id)
	{
		$news = $this->find($id);
		return $news;
	}
}