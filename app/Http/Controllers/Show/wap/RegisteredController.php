<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class RegisteredController extends Controller
{
    public function index()
    {
        return view("wap/registered",[
            "page" => "registered"
        ]);
    }
}