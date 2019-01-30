<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($p)
    {
        // dump($p);
        return view("http/page",["p"=>$p]);
    }
}
