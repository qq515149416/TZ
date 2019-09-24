<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HighSecurityIPController extends Controller
{
    public function index()
    {
        return view("wap/high_security_IP",[
            "page" => "high_security_IP"
        ]);
    }
}
