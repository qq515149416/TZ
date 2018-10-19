<?php

namespace App\Http\Controllers\Test;

use App\Http\Models\TzUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class MailController extends Controller
{

    public function handle()
    {
        dump('su');
    }

}