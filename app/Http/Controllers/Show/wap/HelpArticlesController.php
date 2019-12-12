<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;


class HelpArticlesController extends Controller
{
	public function index($id)
	{
		$content_model = new HelpContentsModel();
		$content = $content_model->find($id);
		if ($content == null) {
			return redirect('/wap/help_center')->with('help_tip', '文章不存在');
		}
		$content = $content->toArray();
	
		$pre_id = $content_model->where('category_id' , $content['category_id']['id'])->where('id','<',$id)->max('id');

		if ($pre_id == null) {
			$pre = [
				'title'	=> '没有了',
				'id'	=> $id,
			];
		}else{
			$pre = [
				'title'	=> $content_model->where('id',$pre_id)->value('title'),
				'id'	=> $pre_id,
			];
		}

		$next_id = $content_model->where('category_id' , $content['category_id']['id'])->where('id','>',$id)->min('id' );
		
		if ($next_id == null) {
			$next = [
				'title'	=> '没有了',
				'id'	=> $id,
			];
		}else{
			$next = [
				'title'	=> $content_model->where('id',$next_id)->value('title'),
				'id'	=> $next_id,
			];
		}

		$pre_next = [
			'pre'	=> $pre,
			'next'	=> $next,
		];

		return view("wap/help_articles",[
			"page" 		=> "help_articles",
			'pre_next'	=> $pre_next,
			"content"	=> $content,
		]);
	}
}