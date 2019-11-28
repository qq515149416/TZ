<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

class SolutionController extends Controller
{
    public function index($page) {
        switch ($page) {
            case 'game':
                return view("http/solution/game");
                break;
            case 'chess':
                return view("http/solution/chess");
                break;
            case 'finance':
                return view("http/solution/finance");
                break;
            case 'streaming_media':
                return view("http/solution/streamingMedia");
                break;
            case 'mobile_app':
                return view("http/solution/mobileApp");
                break;
            case 'education_cloud':
                return view("http/solution/educationCloud");
                break;
            case 'government_cloud':
                return view("http/solution/governmentCloud");
                break;
            case 'website_deployment':
                return view("http/solution/websiteDeployment");
                break;
        }
    }
}
