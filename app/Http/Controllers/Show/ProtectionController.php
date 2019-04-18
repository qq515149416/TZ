<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class ProtectionController extends Controller
{
    public function index($page)
    {
        switch ($page) {
            case 'index':
                return view("http/protection");
                break;
            case 'high-defense-ip':
                return view("http/highDefenseIp");
                break;
            case 'high-defense-cdn':
                return view("http/highDefenseCdn");
                break;
            case 'c-shield':
                return view("http/cShield");
                break;
        }
    }
}
