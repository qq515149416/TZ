<?php

namespace App\Http\Controllers\Test;

use App\Http\Models\TzUser;
use App\Mail\Deadline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{


    /**
     *
     */
    public function handle()
    {

        Mail::to('568171152@qq.com')
            ->send(new Deadline());
//        Demo::dispatch('123');
//        die();
//         return '123';
//        Redis::set('name', 'guwenjie');
//        $values = Redis::get('name');
//        dd($values);

//       $data = array('jj'=>31);

//        $data->21321 = '234';
//        $data[]=3123;

//        $m = new Deadline(1);
//        $res = Mail::to('568171152@qq.com')
//            ->queue($m);
//        dump($res);
//        dump('su');
//        return '242';
    }


}