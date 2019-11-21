<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class LoginRegisteredMenuController extends Controller
{
    public function index()
    {
        return view("wap/login_register_menu",[
            "page" => "login_register_menu"
        ]);
    }
}