<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class FinancialSolutionController extends Controller
{
    public function index()
    {
        return view("wap/financial_solution",[
            "page" => "financial_solution"
        ]);
    }
}
