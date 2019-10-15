<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HelpCenterHomeController extends Controller
{
    public function index()
    {
        return view("wap/help_center_home",[
            "page" => "help_center_home"
        ]);
    }
}
