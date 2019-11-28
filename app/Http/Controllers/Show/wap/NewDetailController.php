<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class NewDetailController extends Controller
{
    public function index()
    {
        return view("wap/new_detail",[
            "page" => "new_detail"
        ]);
    }
}
