<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class EducationSolutionController extends Controller
{
    public function index()
    {
        return view("wap/education_solution",[
            "page" => "education_solution"
        ]);
    }
}
