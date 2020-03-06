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
use Illuminate\Support\Facades\Artisan; 
use Encore\Admin\Facades\Admin;
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
    public function vi(Request $request) {
        
        $time = strtotime('2019-04-03');
        echo $time;
        // $date = date('Y-m-d H:i:s',$time);
        // echo $date;
        // $query_time = $this->queryTime($time);
        // $end_time = time();//结束时间等于当前时间
        // $month = date('Y-m',$end_time);//获取结束时间所属自然月
        // echo  $month.'-01 00:00:00'.'</br>';//获取结束时间所属自然月的第一天的零点为查询的开始时间
        // echo strtotime('2019-04-01 00:00:00').'</br>';
        // echo strtotime('2019-04-04 23:59:59').'</br>';
        // $new_business = DB::table('tz_business')
        //                    ->whereBetween('created_at',['2019-04-01 00:00:00','2019-04-04 23:59:59'])
        //                    ->whereNull('deleted_at')
        //                    ->whereBetween('business_status',[0,4])
        //                    ->whereBetween('remove_status',[0,3])
        //                    ->select('business_number','length','money','id','client_id','sales_id','business_type','machine_number','resource_detail','start_time','endding_time','business_status','remove_status','created_at')
        //                    ->get();
        // $client_name = DB::table('tz_users')->where(['id'=>1119])->select('name','email','nickname','msg_phone','msg_qq')->first();
        // dd($client_name);
        // dd($new_business);
        // DB::beginTransaction();
        // $conact = new Contacts();
        // $upodate = $conact->where(['id'=>4])->update(['qq'=>2773495296]);
        // echo $upodate;
        // if($upodate == true){
        //     echo 'hah3';
        // } else {
        //     echo 123;
        //     DB::commit();
        // }
        // $package = DB::table('tz_defenseip_package')->where(['site'=>50])->whereNull('deleted_at')->select('id','protection_value','name')->get()->toArray();
        
        // foreach($package as $key=>$value){
        //     unset($package[$key]);
        //     $package[$value->id] = $value->protection_value;
        //     $package['N'.$value->protection_value] = $value->name;
        // }
        // // dd($package);
        // $business = DB::table('tz_defenseip_business')->whereIn('package_id',array_keys($package))->whereNull('deleted_at')->where('status','!=',3)->get();
        // foreach($business as $b_k=>$b_v){
        //     $b_v->protection_value = $package[$b_v->package_id];
        //     $user = DB::table('tz_users')->where(['id'=>$b_v->user_id])->first();
        //     $b_v->name = $package['N'.$b_v->protection_value];
        //     $u = $user->email?$user->email:$user->name;
        //     $u = $u?$u:$user->nickname;
        //     $b_v->user =  $u;
        //     $status = [1=>'正在使用',2=>'申请下架',3=>'已下架',4=>'试用',5=>'待审核'];
        //     $b_v->status = $status[$b_v->status];
        //     $ip = DB::table('idc_ips')->where(['id'=>$b_v->ip_id])->value('ip');
        //     $b_v->ip_detail = $ip?$ip:'';
        // }
        // dd($business);
        // $ot = [];
        // $io = [];
        // $flow = DB::table('tz_orders_flow')->where('order_id','!=','')->where('order_id','like','[%')->whereNull('deleted_at')->select('order_id')->get();
        // $count = 0;
        // foreach($flow as $k=>$v){
        //     // echo $v->order_id.'</br>';
        //     // $flows = DB::table('tz_orders_flow')->where('order_id','=','')->where('order_id','like','[%')->get();
        //     $o = trim($v->order_id,'[]');
        //     $order_id = explode(',',$o);
        //     foreach($order_id as $kk=>$vv){
        //         $i = DB::table('tz_orders_flow')->where('order_id','!=','')->where('order_id','=',$vv)->whereNull('deleted_at')->select('id')->get();
        //         foreach($i as $ki=>$vi){
        //             $io['id'] = $vi->id;
        //             array_push($ot,$io);
        //         }
        //     }
        // }
        // dd($ot);
        // 
        // 
        // 
        // 1667
        // $or = [];
        // $order = [];
        // $orders = DB::table('tz_orders')
        //                 ->join('tz_orders_flow','tz_orders.serial_number','=','tz_orders_flow.serial_number')
        //                 ->where('tz_orders_flow.order_id','!=','')
        //                 ->where('tz_orders_flow.order_id','like','[%')
        //                 // ->whereNull('tz_orders.deleted_at')
        //                 // ->whereNotNull('tz_orders_flow.deleted_at')
        //                 ->select('tz_orders.id','tz_orders.customer_id','tz_orders.business_id','tz_orders.resource_type','tz_orders.machine_sn','tz_orders.duration','tz_orders.price','tz_orders.serial_number')
        //                 // ->groupBy('tz_orders.serial_number')
        //                 ->get();
        // $o = DB::table('tz_orders')->whereNull('serial_number')->whereNull('deleted_at')->get();                             
        // foreach($orders as $key=>$value){
        //     $order_flows = DB::table('tz_orders_flow')->where('order_id','=',$value->id)->whereNull('deleted_at')->select('id','order_id','pay_time','payable_money','actual_payment')->get();
        //     foreach($order_flows as $k=>$v){
        //         // $order['customer_id'] = $value->customer_id;
        //         // $order['business_id'] = $value->business_id;
        //         // $order['resource_type'] = $value->resource_type;
        //         $order['machine_sn'] = $value->machine_sn;
        //         $order['price'] = $value->price;
        //         $order['id'] = $v->id;
        //         if($value->price != 0){
        //             $order['month'] = intval(ceil(bcdiv($v->payable_money,$value->price)));
        //         } else {
        //             $order['month'] = $value->duration;
        //         }
                
        //         array_push($or,$order);
        //     }
        //     // $order_flows = DB::table('tz_orders_flow')->where('serial_number','=',$value->serial_number)->whereNull('deleted_at')->select('id','order_id','pay_time','payable_money','actual_payment')->get();
        //     // foreach($order_flows as $k=>$v){
        //     //     $order['customer_id'] = $value->customer_id;
        //     //     $order['business_id'] = $value->business_id;
        //     //     $order['resource_type'] = $value->resource_type;
        //     //     $order['machine_sn'] = $value->machine_sn;
        //     //     $order['price'] = $value->price;
        //     //     array_push($or,$order);
        //     // }
        // }
        // foreach($o as $keys=>$val){
        //     $order_flow = DB::table('tz_orders_flow')->where('order_id','=',$val->id)->whereNull('deleted_at')->select('id','order_id','pay_time','payable_money','actual_payment')->get();
        //     foreach($order_flow as $kt=>$vt){
        //         // $order['customer_id'] = $val->customer_id;
        //         // $order['business_id'] = $val->business_id;
        //         // $order['resource_type'] = $val->resource_type;
        //         $order['machine_sn'] = $val->machine_sn;
        //         $order['price'] = $val->price;
        //         $order['id'] = $vt->id;
        //         if($val->price != 0){
        //             // $order['month'] = bcdiv($v->payable_money,$value->price,0);
        //             $order['month'] = intval(ceil(bcdiv($vt->payable_money,$val->price)));
        //         } else {
        //             $order['month'] = $val->duration;
        //         }
                
        //         array_push($or,$order);
        //     }
        // }
        // dd($or);
        
        // dd($upodate);
        // foreach($new_business as $key => $value){
        //     dd($value->length);
        // }
        // dd($new_business->isEmpty());
        // dd($new_total);
        // $index = new Contacts();
        // $index->test();
     //    // dd(json_encode(DB::table('tz_orders')->first()));
     //    DB::table('test')->insert(['test'=>json_encode(DB::table('tz_orders')->first())]);
     //    // dd(json_encode(DB::table('test')->first()));
     //    $a = [1,2,3,4,5,6];
     //    dump((object)$a);
     //    dd(json_encode((object)$a));
     //    dd(DB::table('test')->first());
     //    dd(json_decode(DB::table('test')->first()->test));
    	// return view('show/test');
        // echo date('t',strtotime('2019-01')).'</br>'; 
        // echo date('t',strtotime('2019-01-31'.'+1 month')).'</br>';
        // echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-05-31').' +1 month')).'-1 day')).'</br>';
        // echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-05-31').' +2 month')).'-0 day')).'</br>';
        // $current_month = date('t',strtotime('2019-02'));//当前月的天数
        // $next_month = date('t',strtotime('2019-02'.'+1 month'));
        // echo $current_month.'</br>';
        // echo $next_month.'</br>';
        // $da = $current_month - $next_month;
        // echo $da.'</br>';
        // if($da < 0){
        //     if($current_month == 28 || $current_month == 29 || $current_month == 30){
        //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-01 10:00:02').'+1 month')).'-'.$da.' day')).'</br>';
        //     } else {
        //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-01 10:00:02').'+1 month')))).'</br>';
        //     }
           
        // } elseif($da > 0){
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-01 10:00:02').'+1 month')).'-'.$da.' day')).'</br>';
        // } elseif($da == 0){
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-01 10:00:02').'+1 month')).'-'.$da.' day')).'</br>';
        // }
        
        // $now_month = date('m',strtotime('2019-04-30 10:00:02'));//当前月份
        // $next_month = date('m',strtotime('2019-04-30 10:00:02'.'+1 month'));//下一月份
        // $now_day = date('d',strtotime('2019-04-30 10:00:02'));//当前时间的到期
        // $current_month_day = date('t',strtotime(date('Y-m',strtotime('2019-04-30 10:00:02'))));//当前月的天数
        // $next_month_day = date('t',strtotime(date('Y-m',strtotime('2019-04-30 10:00:02')).'+1 month'));//续费到期的天数
        // $day = $current_month_day - $next_month_day;
        // // if($now_month == '02' ){
        // //     if($now_day == $current_month_day){
        // //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-28 10:00:02').'+2 month')).'-'.$day.' day')).'</br>';
        // //     } else {
        // //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-28 10:00:02').'+2 month')))).'</br>';
        // //     }
            
        // //     echo 1;
        // // } elseif($day < 0){
        // //     if($now_day == $current_month_day){
        // //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-01 10:00:02').'+1 month')).'-'.$day.' day')).'</br>';
        // //         echo 123456;
        // //     } else {
        // //         echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-01 10:00:02').'+1 month')))).'</br>';
        // //         echo 7890213;
        // //     }
            
        // //     echo 2;
        // // } elseif($day > 0){
        // //     if($next_month == '02'){
        // //         if($now_day > $next_month_day){
        // //             $d =  $now_day - $next_month_day;
        // //             echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-01-29 10:00:02').'+1 month')).'-'.$d.' day')).'</br>';
        // //         } else {
        // //             echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-01-29 10:00:02').'+1 month')))).'</br>';
        // //         }
        // //         echo 5;
        // //     } else {//增加判断条件
        // //         if($now_day > $next_month_day){
        // //             echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-03-27 10:00:02').'+1 month')).'-'.$day.' day')).'</br>';
        // //         } else {
        // //             echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-03-27 10:00:02').'+1 month')))).'</br>';
        // //         }
                
        // //         echo 3;
        // //     }
                   
        // // } elseif($day == 0){
        // //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2020-01-31 10:00:02').'+1 month')).'-'.$day.' day')).'</br>';
        // //     echo 4;
        // // }
        // if($now_month == '02' && $now_day == $current_month_day){
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-02-28 10:00:02').'+2 month')).'-'.$day.' day')).'</br>';
        // } elseif($day < 0 && $now_day == $current_month_day){
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-30 10:00:02').'+1 month')).'-'.$day.' day')).'</br>';
        // } elseif($day > 0 && $next_month == '02' && $now_day > $next_month_day){
        //     $d =  $now_day - $next_month_day;
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-30 10:00:02').'+1 month')).'-'.$d.' day')).'</br>';
        // } elseif($day > 0 && $now_day > $next_month_day){
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-30 10:00:02').'+1 month')).'-'.$day.' day')).'</br>';
        // } else {
        //     echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2019-04-30 10:00:02').'+1 month')))).'</br>';
        // }
        // $current_month_day = date('t',strtotime('2020-01'));//当前月的天数
        // $next_month_day = date('t',strtotime('2020-01'.'+1 month'));//续费到期的天数
        // $now_day = date('d',strtotime('2020-01-29 10:00:02'));//当前时间的到期
        // // $o = $current_month_day - $now_day;
        // // $d = $next_month_day + $o;
        // echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',strtotime(date('2020-01-29 10:00:02').'+'.$next_month_day .' day')))).'</br>';
        // return DB::table('tz_news')->value('content');
        // $orders = DB::table('tz_orders')->whereNull('deleted_at')->select('id','customer_id','business_id','resource_type','machine_sn','resource','price','duration','created_at')->get();
        // if(!$orders->isEmpty()){
        //     foreach($orders as $orders_key => $orders_value){
        //         $resource_type = [1=>'租用主机',2=>'托管主机',3=>'租用机柜',4=>'IP',5=>'CPU',6=>'硬盘',7=>'内存',8=>'带宽',9=>'防护',10=>'cdn',11=>'高防IP'];
        //         $orders_value->type = $resource_type[$orders_value->resource_type];
        //     }
        // }
        // DB::table(jieshoude1)->whereOr('name',jieshou1de)->whereOr('nicakname')->whereOr('email');
        
        // global $where;
        // $where = '599912913@qq.com';
        // $table = 'tz_users';
        // // $dd = DB::table($table)->orWhere('name',$where)->when($where, function ($query, $where) {
        // //             return DB::table("tz_users")->first() && array_key_exists('nickname',DB::table("tz_users")->first());
        // //         }, function ($query) {
        // //             return $query->orWhere('nickname', '599912913@qq.com')->orWhere('email', '599912913@qq.com');
        // //         });
        // if($table == 'tz_users'){
        //     $or = "->orWhere('nickname',".$where.")
        //     ->orWhere('email',".$where.")";
        // }
        // echo $or;                 
        // $dd = DB::table($table)->orWhere('name',$where)
        //                    $or      
        //                   ->first();
        // // $dd = DB::table($table)->orWhere('name',$where)->orWhere('nickname', $where)->orWhere('email', $where)->first();
        // dd($dd);
        // && array_key_exists('nickname',$query->first())
        // global $where;
        
        // $this->where = '123';
       //  $oo = 'tz_users|599912913@qq.com';
       //  echo (substr($oo,0,stripos($oo,'|'))).'</br>';
       // echo (substr($oo,stripos($oo,'|')+1)).'</br>';
       //  global $where; 
       //  $where = '599912913@qq.com';
       //  $table = 'tz_users';
       //  // dd(in_array('e',Schema::getColumnListing($table)));
       //  $dd = DB::table($table)->orWhere('name',$where)->orWhere(function ($query) {
       //      if($query->first() && array_key_exists('nickname',$query->first())) {

       //          $query->orWhere('email', $GLOBALS['where'])
       //            ->orWhere('nickname', $GLOBALS['where']);
       //      }

       //  })->first();
       //  // $dd = DB::table($table)->orWhere('name',$where)->orWhere('nickname', $where)->orWhere('email', $where)->first();
       //  dd($dd);
        // dd($orders);
        // echo microtime().'</br>';
        // echo substr(microtime(),6,3).'</br>';
        // echo time().'</br>';
        // $time = [];
        // $a =0;
        // for ($i=0; $i < 100000; $i++) { 

        //     $time1 = mt_rand(10, 99).date('Ymd',time()).substr(microtime(),2,6);
        //     if(in_array($time1,$time)){
        //         echo $time1.'|'.$i.'</br>';
        //         $a++;
        //     }
        //     array_push($time,$time1);
        // }
        // echo $a.'</br>';
        // dd($time);
        // $orders = DB::table('tz_orders')
        //             ->whereNull('deleted_at')
        //             ->where(['order_status'=>0,'resource_type'=>11])
        //             ->select('id','created_at','business_sn')
        //             ->first();
        // $d = time() - strtotime($orders->created_at);
        // echo $d.'</br>';
        // dd($orders);
        // $str = ' '.','.'123456789,4567890123,4562130212,'.' ';
        // echo $str.'</br>';
        // dd(trim($str,' '.','));
        // $depart = DB::table('oa_staff')
        //                 ->join('idc_machineroom','oa_staff.department','=','idc_machineroom.list_order')
        //                 ->where(['admin_users_id'=>Admin::user()->id])
        //                 ->value('idc_machineroom.id');
        // dd($depart);
        // echo date('Y-m-d',strtotime('2019-01-30'.'+1 day'));
       // echo date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s',time())."-1 day"));
        // echo date('Y-m-d',strtotime('2019-01-30 10:10:03'."-7 day")).'</br>';
        // echo date('Y-m-d',strtotime(date('Y-m-01',time()).'-1 month')).'</br>';
        // echo date('Y-m-01',time()).'</br>';
        //echo date('Y-m-d',strtotime('2019-01-30')."+1 day");
        // echo date('Ymd',time()).substr(microtime(),2,6);
        // $flow = DB::table('tz_orders_flow')
        //             ->whereNull('deleted_at')
        //             ->whereBetween('pay_time',['2019-06-01','2019-06-06'])
        //             ->get(['order_id']);
        // $str = '';
        // foreach ($flow as $key => $value) {
        //    $str = trim($str.','.trim($value->order_id,'[]'),','); 
        // }
        // echo $str;
        // $a = array_unique(explode(',',$str));
        // // dd($flow);
        // dd($a);
        // $cc = get_headers('http://wpa.qq.com/pa?p=2:2773495294'.':41&r=' . time (),1);
        // // dd($cc);
        // dd($http_response_header);
        // foreach ($http_response_header as $key => $value) {
        //     dd(strpos($value,'Content-Length'));
        // }
        // $data = DB::table('tz_business')->where(['business_number'=>11111])->value('resource_detail');
        // dd($data);
        // return $data;
        // $xunsearch = new XS('orders');
        // $index = $xunsearch->index;
        // $doc['id'] = 1111111111;
        // $doc['machine_sn'] = 11111111111;
        // $doc['business_sn'] = 11111111111;
        // $doc['order_sn'] = 11111111;
        // $document = new \XSDocument($doc);
        // $result = $index->update($document);
        // dd($result);
        // $index->flushIndex();
    }

    private function clear() {
        if(!defined('STDIN'))  define('STDIN',  fopen('php://stdin',  'rb'));
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
        if(!defined('STDERR')) define('STDERR', fopen('php://stderr', 'wb'));
        Artisan::call("view:clear");
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
        // 清理视图缓存
        $this->clear();
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
        // 清理视图缓存
        $this->clear();
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
        // 清理视图缓存
        $this->clear();
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
