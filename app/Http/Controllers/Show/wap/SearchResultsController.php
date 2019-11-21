<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class SearchResultsController extends Controller
{
    public function index()
    {
        return view("wap/search_results",[
            "page" => "search_results"
        ]);
    }
}