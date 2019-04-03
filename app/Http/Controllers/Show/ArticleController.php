<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index($type)
    {
        $template = "http/article";
        return view($template,[
            "type" => $type
        ]);
    }
}
