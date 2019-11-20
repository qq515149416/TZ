<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($directory,$p)
    {
        return view("http/page",["directory" => $directory,"p"=>$p]);
    }
}
