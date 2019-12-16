<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;
use App\Admin\Models\News\PromotionModel;

class LatestActivityController extends Controller
{
    public function index()
    {
        return view("http/latestActivity",[
            "data" => PromotionModel::all()
        ]);
    }
}
