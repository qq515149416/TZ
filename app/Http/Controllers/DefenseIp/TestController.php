<?php

namespace App\Http\Controllers\DefenseIp;

use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{




    /**
     * 测试方法
     */
    public function test()
    {
//        $InfoM = new InfoController();

        dump(StoreModel::find(1)->get()->toArray());
        die();

        $setM = new SetController();

        $setM->setTarget();

//        dump($InfoM->statistics());
//        $InfoM->statistics();
//        $g = new ApiController();
//        dump($g->updateTarget('1.1.1.1','2.2.2.2'));
    }




}
