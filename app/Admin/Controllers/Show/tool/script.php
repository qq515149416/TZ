<?php

namespace App\Admin\Controllers\Show\tool;

use App\Http\Controllers\Controller;
class script extends Controller
{
    protected function script()
    {
        return <<<SCRIPT
let myScript = document.querySelector('script[src*="tz_assets/bundle.js"]');
let script = document.createElement("script");
script.type="text/javascript";
script.src="/tz_assets/bundle.js";
document.body.replaceChild(script,myScript);
SCRIPT;
    }
}