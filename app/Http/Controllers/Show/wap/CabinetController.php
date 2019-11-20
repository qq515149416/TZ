<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class CabinetController extends Controller
{
    public function index()
    {
        return view("wap/cabinet",[
            "page" => "cabinet"
        ]);
    }
}
