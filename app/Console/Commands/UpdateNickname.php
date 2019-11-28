<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Models\Business\BusinessModel;
use App\Admin\Models\Business\OrdersModel;
use App\Admin\Models\Business\CustomerModel;
use XS;
use XSDocument;
use Illuminate\Support\Facades\DB;

/**
 * 用于平滑更新xunsearch的索引，解决某些数据因修改而搜索不到的问题
 */
class UpdateNickname extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:update-nickname';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新昵称';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateNickname();
        // $this->clea();
    }

    // public function clea(){
    //      $xunsearch = new XS('business');
    //     $index = $xunsearch->index;
    //     $index->clean();
    //     $xunsearch = new XS('orders');
    //         $index = $xunsearch->index;
    //     $index->clean();
    //      $xunsearch = new XS('customer');
    //         $index = $xunsearch->index;
    //     $index->clean();
    // }

    /**
     * 进行索引的更新
     * @return [type] [description]
     */
    public function updateNickname(){
        //客户信息
        $customer = new CustomerModel();
        $customer_result = $customer->select('name','email','nickname','msg_qq','msg_phone','id')->get();
        if(!$customer_result->isEmpty()){
            $xunsearch = new XS('customer');
            $index = $xunsearch->index;
            $index->beginRebuild();
            foreach ($customer_result as $customer_key => $customer_value) {
                if($customer_value->nickname == Null){
                    $row = DB::table('tz_users')->where(['id'=>$customer_value->id])->update(['nickname'=>$customer_value->email]);
                }
                $client = $customer->find($customer_value->id);
                $doc['id'] = strtolower($client->id);
                $doc['name'] = strtolower($client->name);
                $doc['email'] = strtolower($client->email);
                $doc['nickname'] = strtolower($client->email);
                $doc['msg_qq'] = strtolower($client->msg_qq);
                $doc['msg_phone'] = strtolower($client->msg_phone);
                $document = new \XSDocument($doc);
                $index->add($document);
            }
            $index->endRebuild();
        }
    }

}
