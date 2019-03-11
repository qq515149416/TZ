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
     *  01?!010@$%203**
     */
    public function test()
    {
        $InfoM = new InfoController();
        dump($InfoM->showList());


//        dump(StoreModel::find(2));
//        die();
//
//        $setM = new SetController();
//        $setM->setTarget();


//        return '123';
//        dump($InfoM->statistics());
//        $InfoM->statistics();
//        $g = new ApiController();
//        dump($g->updateTarget('1.1.1.1','2.2.2.2'));
    }


}
