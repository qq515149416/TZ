<?php

namespace App\Admin\Controllers\Show\tool;

use App\Http\Controllers\Controller;
class script extends Controller
{
    private function make_password( $length = 8 ) {
        // 密码字符集，可任意添加你需要的字符
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        // 在 $chars 中随机取 $length 个数组元素键名
        $keys = array_rand($chars, $length);
        $password = '';
        for($i = 0; $i < $length; $i++)
        {
            // 将 $length 个数组元素连接成字符串
            $password .= $chars[$keys[$i]];
        }
        return $password;
    }
    protected function script()
    {
        $version = $this->make_password();
        return <<<SCRIPT
let myScript = document.querySelector('script[src*="tz_assets/bundle.js"]');
let script = document.createElement("script");
script.type="text/javascript";
script.src="/tz_assets/bundle.js?version=$version";
document.body.replaceChild(script,myScript);
if(document.querySelectorAll('style').length) {
    document.querySelectorAll('style').forEach(function(item) {
        document.head.removeChild(item);
    });
}
SCRIPT;
    }
}
