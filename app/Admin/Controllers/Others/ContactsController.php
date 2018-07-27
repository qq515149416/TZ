<?php

namespace App\Admin\Controllers\Others;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Others\Contacts as contactsmodel;
use App\Admin\Requests\Test;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    use ModelForm;

    public function test() {
    	$model = new contactsmodel();
    	$result = $model->test();
    	echo $result;
    }

    /**
     * 用于查询系统联系人（业务员）的信息
     * @return json 返回相关的信息
     */
    public function index() {
    	$index = new contactsmodel();
    	$contacts = $index->index();
    	// print_r($data);
    	return tz_ajax_echo($contacts['data'],$contacts['msg'],$contacts['code']);
    }


    public function rulestest(Test $request){
    	// $request->all();
    	$errors = $validator->errors();

		echo $errors->first('title');
    }
}
