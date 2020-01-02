<?php

namespace App\Http\Controllers\User\Show;

use App\Http\Controllers\Controller;

class ServerController extends Controller
{
    public function index()
    {
        return view("user_admin/server",[
            "page" => "server"
        ]);
    }
}
