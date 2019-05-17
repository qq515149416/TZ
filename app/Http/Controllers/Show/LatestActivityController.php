<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class LatestActivityController extends Controller
{
    public function index()
    {
        return view("http/latestActivity");
    }
}
