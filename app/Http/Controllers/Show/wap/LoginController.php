<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function index()
    {
        return view("wap/login",[
            "page" => "login"
        ]);
    }
}