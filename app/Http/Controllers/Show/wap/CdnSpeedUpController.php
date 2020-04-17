<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use App\Admin\Models\News\HelpCategoryModel;
use App\Admin\Models\News\HelpContentsModel;
use App\Admin\Models\News\HelpTagModel;

class CdnSpeedUpController extends Controller
{
	public function index($page)
	{
		$product = 'CDN加速';

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
		switch ($page) {
            case 'index':
                return view("wap/cdn/cdn_speed_up",[

					"help"			=> $help,
					"help_template"	=> 'wap.product.help',
					"help_id"		=> $help_id,
					"page" 			=> $page
				]);;
                break;
            case 'sca':
                return view("wap/cdn/staticContentAcceleration",[
					"page" 			=> $page
				]);
                break;
            case 'dda':
                return view("wap/cdn/downloadDeliveryAcceleration",[
					"page" 			=> $page
				]);
                break;
            case 'dsa':
                return view("wap/cdn/dynamicSiteAcceleration",[
					"page" 			=> $page
				]);
                break;
            case 'smvoda':
                return view("wap/cdn/vodAcceleration",[
					"page" 			=> $page
				]);
                break;
            case 'smlba':
                return view("wap/cdn/liveAcceleration",[
					"page" 			=> $page
				]);
                break;
        }
		// return view("wap/cdn_speed_up",[

		// 	"help"			=> $help,
		// 	"help_template"	=> 'wap.product.help',
		// 	"help_id"		=> $help_id,
		// 	"page" 			=> "cdn_speed_up"
		// ]);

	}
}
