<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class OverseasController extends Controller
{
    public function index($page="")
    {
        if(!$page || $page=="index") {
            return view("http/overseas");
        } else {
            return view("http/overseas_product",[
                "page" => $page
            ]);
        }
    }
}
