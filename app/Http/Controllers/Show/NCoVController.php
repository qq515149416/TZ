<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class NCoVController extends Controller
{
    public function index()
    {
        return view("http/nCoV");
    }
}
