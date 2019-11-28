<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class GameSolutionController extends Controller
{
    public function index()
    {
        return view("wap/game_solution",[
            "page" => "game_solution"
        ]);
    }
}
