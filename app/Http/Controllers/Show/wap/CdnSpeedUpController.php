<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class CdnSpeedUpController extends Controller
{
    public function index()
    {
        return view("wap/cdn_speed_up",[
            "page" => "cdn_speed_up"
        ]);
    }
}
