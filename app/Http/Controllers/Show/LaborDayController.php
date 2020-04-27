<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class LaborDayController extends Controller
{
    public function index()
    {
        return view("http/labor_day");
    }
}
