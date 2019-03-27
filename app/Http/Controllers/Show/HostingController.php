<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class HostingController extends Controller
{
    public function index()
    {
        return view("http/hosting");
    }
}
