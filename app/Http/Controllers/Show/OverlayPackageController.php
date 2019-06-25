<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use App\Http\Models\DefenseIp\OverlayModel;

class OverlayPackageController extends Controller
{
    public function index()
    {
        return view("http/overlayPackage",[
            "overlay" => OverlayModel::where('sell_status',1)->get()
        ]);
    }
}
