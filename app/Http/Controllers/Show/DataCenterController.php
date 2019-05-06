<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class DataCenterController extends Controller
{
    public function index()
    {
        return view("http/datacenter");
    }
}
