<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HighSecurityController extends Controller
{
    public function index()
    {
        return view("wap/high_security",[
            "page" => "high_security"
        ]);
    }
}
