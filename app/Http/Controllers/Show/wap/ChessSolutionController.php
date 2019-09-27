<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class ChessSolutionController extends Controller
{
    public function index()
    {
        return view("wap/chess_solution",[
            "page" => "chess_solution"
        ]);
    }
}
