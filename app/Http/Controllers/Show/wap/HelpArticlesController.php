<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class HelpArticlesController extends Controller
{
    public function index()
    {
        return view("wap/help_articles",[
            "page" => "help_articles"
        ]);
    }
}