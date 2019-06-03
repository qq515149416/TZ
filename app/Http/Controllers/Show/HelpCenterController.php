<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class HelpCenterController extends Controller
{
    public function index()
    {
        return view("http/helpCenter");
    }
}
