<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class CdnController extends Controller
{
    public function index($page)
    {
        switch ($page) {
            case 'index':
                return view("http/cdn");
                break;
            case 'sca':
                return view("http/staticContentAcceleration");
                break;
            case 'dda':
                return view("http/downloadDeliveryAcceleration");
                break;
            case 'dsa':
                return view("http/dynamicSiteAcceleration");
                break;
            case 'smvoda':
                return view("http/vodAcceleration");
                break;
            case 'smlba':
                return view("http/liveAcceleration");
                break;
        }
    }
}