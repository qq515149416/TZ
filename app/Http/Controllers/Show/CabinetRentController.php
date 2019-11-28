<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class CabinetRentController extends Controller
{
    public function index($page) {
        switch ($page) {
            case 'huizhou':
                return view("http/cabinetRent/huizhou");
                break;
            case 'hengyang':
                return view("http/cabinetRent/hengyang");
                break;
            case 'xian':
                return view("http/cabinetRent/xian");
                break;
        }
    }
}