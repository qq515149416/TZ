<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class MobileappSolutionController extends Controller
{
    public function index()
    {
        return view("wap/mobileapp_solution",[
            "page" => "mobileapp_solution"
        ]);
    }
}
