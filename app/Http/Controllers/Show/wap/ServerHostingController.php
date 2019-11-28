<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class ServerHostingController extends Controller
{
    public function index()
    {
        return view("wap/server_hosting",[
            "page" => "server_hosting"
        ]);
    }
}
