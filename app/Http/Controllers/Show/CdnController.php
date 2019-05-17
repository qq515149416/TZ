<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class CdnController extends Controller
{
    public function index($page)
    {
        switch ($page) {
            case 'index':
                return view("http/cdn/cdn");
                break;
            case 'sca':
                return view("http/cdn/staticContentAcceleration");
                break;
            case 'dda':
                return view("http/cdn/downloadDeliveryAcceleration");
                break;
            case 'dsa':
                return view("http/cdn/dynamicSiteAcceleration");
                break;
            case 'smvoda':
                return view("http/cdn/vodAcceleration");
                break;
            case 'smlba':
                return view("http/cdn/liveAcceleration");
                break;
        }
    }
}