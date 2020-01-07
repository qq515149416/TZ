<?php

namespace App\Http\Controllers\User\Show;

use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    public function index()
    {
        return view("user_admin/detail",[
            "page" => "detail"
        ]);
    }
}
