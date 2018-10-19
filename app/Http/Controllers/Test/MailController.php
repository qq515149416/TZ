<?php

namespace App\Http\Controllers\Test;

use App\Http\Models\TzUser;
use App\Mail\Deadline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{


    /**
     *
     */
    public function handle()
    {
        
        Redis::set('name', 'guwenjie');
        $values = Redis::get('name');
        dd($values);

        $res= Mail::to('568171152@qq.com')->queue(new Deadline());
        dump($res);
        dump('su');
    }





}