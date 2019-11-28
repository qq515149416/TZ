<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        return view("http/test");
    }
}
