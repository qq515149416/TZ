<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class MediaSolutionController extends Controller
{
    public function index()
    {
        return view("wap/media_solution",[
            "page" => "media_solution"
        ]);
    }
}
