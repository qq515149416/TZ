<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class CloudHostingController extends Controller
{
    public function index()
    {
        return view("wap/cloud_hosting",[
            "page" => "cloud_hosting"
        ]);
    }
}
