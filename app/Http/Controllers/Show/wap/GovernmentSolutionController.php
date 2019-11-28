<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class GovernmentSolutionController extends Controller
{
    public function index()
    {
        return view("wap/government_solution",[
            "page" => "government_solution"
        ]);
    }
}
