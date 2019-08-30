<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class ServerHireController extends Controller
{
    public function index()
    {
        return view("wap/server_hire",[
            "page" => "server_hire"
        ]);
    }
}
