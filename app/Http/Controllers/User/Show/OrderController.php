<?php

namespace App\Http\Controllers\User\Show;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view("user_admin/order",[
            "page" => "server_order"
        ]);
    }
}
