<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class BandwidthRentController extends Controller
{
    public function index($page) {
        switch ($page) {
            case 'huizhou':
                return view("http/bandwidthRent/huizhou");
                break;
            case 'hengyang':
                return view("http/bandwidthRent/hengyang");
                break;
            case 'xian':
                return view("http/bandwidthRent/xian");
                break;
        }
    }
}