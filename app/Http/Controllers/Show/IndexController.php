<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view("http/index");
    }
}
