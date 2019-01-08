<?php

namespace App\Admin\Controllers\Others;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Others\Contacts;
use App\Admin\Requests\Test;
use App\Admin\Requests\Idc\OaContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use XS;
use XSDocument;


class ContactsController extends Controller
{
    use ModelForm;
    private function filter($arr,$state){
        $this->state = $state;
        return array_filter($arr,function($var) {
            return $var->resource_type == $this->state;
        });
    }
    /**
     * 测试
     */
    public function test() {
    	$model = new contactsmodel();
    	$result = $model->test();
    	echo $result;
    }

    /**
     * 测试
     */
    public function rulestest(Test $request){
  			// return $request->all();
  			print_r($request->get('title'));
  		if($request->isMethod('post')){

	        // $test = $request->get('title');

	        // echo('<pre>');var_dump($test);die('</pre>');
	        echo 123;

	    }else{

	        echo 'this request method is GET';

	    }
	   // echo 123;
  			// dump($request);
    }

    /**
     * 测试
     */
    public function vi(Request $request) {
        $index = new Contacts();
        $index->test();
     //    // dd(json_encode(DB::table('tz_orders')->first()));
     //    DB::table('test')->insert(['test'=>json_encode(DB::table('tz_orders')->first())]);
     //    // dd(json_encode(DB::table('test')->first()));
     //    $a = [1,2,3,4,5,6];
     //    dump((object)$a);
     //    dd(json_encode((object)$a));
     //    dd(DB::table('test')->first());
     //    dd(json_decode(DB::table('test')->first()->test));
    	// return view('show/test');
    }
    public function vtest(Request $request) {
        $search = $request->only('search');
        $xs = new XS('ip');
        $index = $xs->index;
        $doc = DB::table('idc_ips')->select('id','ip')->get();
        $document = new \XSDocument($doc);
        //修改成功时更新文档主键值一样时会替换数据
        $index->update($document);
        $index->flushIndex();
        dd($xs);
        dd($search);
    }

    /**
     * 用于查询系统联系人（业务员）的信息
     * @return json 返回相关的信息
     */
    public function index() {
        $index = new Contacts();
        $contacts = $index->index();
        return tz_ajax_echo($contacts['data'],$contacts['msg'],$contacts['code']);
    }

    /**
     * 新增联系人表的信息
     * @param  OaContracts $request 进行字段验证
     * @param  array $data 前台传输过来的信息
     * @return json               将相关的信息进行json返回
     */
    public function insert(OaContacts $request){
        // 符合判断的方式正确继续进行，获取提交信息
        $data = $request->only(['contactname','admin_user_id','qq','mobile','email','rank','site']);
        // 实例化model
        $create = new Contacts();
        // 数据进行model层处理
        $result = $create->insert($data);
        // 返回信息
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 查找要修改的数据
     * @param  Request $request 接收传递的参数
     * @return json            返回相关的数据或信息提示
     */
    public function edit(Request $request) {
        // 获取传递的参数
        $id = $request->get('contacts_id');
        $edit = new Contacts();
        // 将参数传递到对应的model的方法并进行接收结果
        $result = $edit->edit($id);
        // 返回相关数据和信息提示
        return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 修改联系人表的信息
     * @param  OaContracts $request 进行字段验证
     * @param  array $data 前台传输过来的信息
     * @return json               将相关的信息进行json返回
     */
    public function doEdit(OaContacts $request){
        // 符合判断的方式正确继续进行，获取提交信息
        $data = $request->only(['id','contactname','admin_user_id','qq','mobile','email','rank','site']);
        // 实例化model
        $create = new Contacts();
        // 数据进行model层处理
        $result = $create->doEdit($data);
        // 返回信息
        return tz_ajax_echo($result,$result['msg'],$result['code']);
    }


    /**
     * 删除操作
     * @param  Request $request 操作删除的条件
     * @return json           相关的信息返回
     */
    public function deleted(Request $request){
        // 获取传递的参数
        $id = $request->get('delete_id');
        // echo $id;
        $edit = new Contacts();
        // 将参数传递到对应的model的方法并进行接收结果
        $result = $edit->dele($id);
        // 返回相关数据和信息提示
        return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 获取账户信息
     * @return [type] [description]
     */
    public function admin(){
        $admin = DB::table('admin_users')->select('id','name')->get();
        if(!$admin->isEmpty()){
            $return['data'] = $admin;
            $return['code'] = 1;
            $return['msg'] = '获取账户成功';
        } else {
            $return['data'] = [];
            $return['code'] = 0;
            $return['msg'] = '获取用户失败';
        }
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }
}
