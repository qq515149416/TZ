<?php

namespace App\Http\Controllers\Show\wap;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class DeploymentSolutionController extends Controller
{
    public function index()
    {
        return view("wap/deployment_solution",[
            "page" => "deployment_solution"
        ]);
    }
}
