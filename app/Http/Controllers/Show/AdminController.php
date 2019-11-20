<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return response()->file(public_path("tz_assets/template.html"),[
            "Cache-Control" => "no-cache"

        ]);
    }
}
