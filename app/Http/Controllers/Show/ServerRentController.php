<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ServerRentController extends Controller
{
    public function index($page)
    {
        if($page=="index") {
            return view("http/serverRent");
        } else {
            return view("http/product",[
                "page" => $page
            ]);
        }
    }
}
