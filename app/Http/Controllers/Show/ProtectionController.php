<?php

namespace App\Http\Controllers\Show;

use App\Http\Controllers\Controller;

use App\Http\Models\DefenseIp\PackageModel;

class ProtectionController extends Controller
{
    public function index($page)
    {
        switch ($page) {
            case 'index':
                return view("http/protection");
                break;
            case 'high-defense-ip':
                // $model = new PackageModel();

                // $list = $model->showPackage();
                // return view("http/highDefenseIp",[
                //     "data" => $list['data']
                // ]);
                return redirect()->action('Show\ProtectionController@gaofang');
                break;
            case 'high-defense-cdn':
                return view("http/highDefenseCdn");
                break;
            case 'c-shield':
                return view("http/cShield");
                break;
        }
    }
    public function gaofang()
    {
        $model = new PackageModel();

		$list = $model->showPackage();
        return view("http/highDefenseIp",[
            "data" => $list['data']
        ]);
    }
}
