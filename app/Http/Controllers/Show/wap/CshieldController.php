<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class CshieldController extends Controller
{
    public function index()
    {
        return view("wap/c_shield",[
            "page" => "c_shield"
        ]);
    }
}
