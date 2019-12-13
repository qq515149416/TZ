<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;


class ServerHostingController extends Controller
{
	public function index()
	{
		$product = '服务器托管';

		$category_model = new HelpCategoryModel();
		$help_arr = $category_model->getIdByProduct($product);
		//dd($help_arr);
		if (count($help_arr) > 0) {
		
			$category_id = [];
			for ($i=0; $i < count($help_arr); $i++) { 
				$category_id = array_merge($category_id , $help_arr[$i]['id_arr']);
			}
			$help = HelpContentsModel::whereIn('category_id', $category_id)
							->where('state' , 1)
							 ->inRandomOrder()
							->take(5)
							->get();
			$help_id = $category_id[0];
		}else{
			$help = HelpContentsModel::where('state' , 1)
							 ->inRandomOrder()
							->take(5)
							->get();
			$help_id = 0;
		}
		return view("wap/server_hosting",[

			"help"			=> $help,
			"help_template"	=> 'wap.product.help',
			"help_id"		=> $help_id,
			"page" 			=> "server_hosting"
		]);
	}
}
