<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index($page)
    {
        return view("http/program",[
            "page" => $page
        ]);
    }
}
