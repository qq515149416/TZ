<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class CdnController extends Controller
{
    public function index($page)
    {
        return view("http/15cdn",[
            "page" => $page
        ]);
    }
}
