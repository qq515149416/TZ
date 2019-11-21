<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HelpCenterController extends Controller
{
    public function index()
    {
        return view("wap/help_center",[
            "page" => "help_center"
        ]);
    }
}