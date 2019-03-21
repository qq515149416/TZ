<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index($page)
    {
        return view("http/aboutUs",[
            "page" => $page
        ]);
    }
}
