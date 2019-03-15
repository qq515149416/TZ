<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ServerRentController extends Controller
{
    public function index()
    {
        return view("http/serverRent");
    }
}
