<?php

namespace App\Admin\Controllers\Hr;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Hr\Account;
use App\Admin\Requests\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    use ModelForm;

    public function test(){
    	return 123;
    }
}
