<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Http\Models\News\News;


class NewDetailController extends Controller
{
	public function index($id)
	{
		$news_model = new News();
		$news = News::whereNull('deleted_at')->find($id);

		if($news == null){
			return redirect('wap/company/news')->with('tip', '文章不存在');
		}
		
		$pre_news_id = $news_model->whereNull('deleted_at')->where('id','<',$id)->max('id');
		if ($pre_news_id == null) {
			$pre = [
				'title'	=> '没有了',
				'id'	=> $id,
			];
		}else{
			$pre = [
				'title'	=> $news_model->where('id',$pre_news_id)->value('title'),
				'id'	=> $pre_news_id,
			];
		}

		$next_news_id = $news_model->whereNull('deleted_at')->where('id','>',$id)->min('id');
		if ($next_news_id == null) {
			$next = [
				'title'	=> '没有了',
				'id'	=> $id,
			];
		}else{
			$next = [
				'title'	=> $news_model->where('id',$next_news_id)->value('title'),
				'id'	=> $next_news_id,
			];
		}

		$pre_next = [
			'pre'	=> $pre,
			'next'	=> $next,
		];
		return view("wap/new_detail",[
			"page" 		=> "new_detail",
			'news'		=> $news,
			'pre_next'	=> $pre_next,
		]);
	}
}
