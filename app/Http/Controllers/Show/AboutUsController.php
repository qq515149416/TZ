<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index()
    {
        return view("http/aboutUs");
    }
}
