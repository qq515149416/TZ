<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 use App\Http\Requests\News\PromotionRequest;
 use App\Http\Models\News\PromotionModel;
/**
 * 促销活动控制器
 */
class PromotionController extends Controller
{

	public function getPro(PromotionRequest $request){
		$par = $request->only(['need']);

		$model = new PromotionModel();

		$return = $model->getPro($par['need']);

	}
  
}
