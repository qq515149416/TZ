<?php

namespace App\Admin\Controllers\Show;

use App\Http\Controllers\Controller;
class TestController extends Controller 
{
    public function index()
    {
        return view("show/test");
    }
}