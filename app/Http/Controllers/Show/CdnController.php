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
            case 'dd':
                return view("http/downloadDelivery");
                break;
            case 'dsa':
                return view("http/dynamicSiteAccelerator");
                break;
            case 'smlba':
                return view("http/liveBroadcastAcceleration");
                break;
            case 'smvoda':
                return view("http/vodAcceleration");
                break;
        }
    }
}