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
class UpdateRelevence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:update-relevence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新业务类型表的业务号';

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
        $this->updateRelevence();
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
    public function updateRelevence(){
        //业务
        $business = DB::table('tz_business')->get(['business_number','created_at']);
        if(!empty($business)){
            foreach($business as $key => $value){
                $relevence = DB::table('tz_business_relevance')->where(['type'=>1,'business_id'=>$value->business_number])->first();
                if(empty($relevence)){
                    $row = DB::table('tz_business_relevance')->insert(['type'=>1,'business_id'=>$value->business_number,'created_at'=>$value->created_at]);
                }
            }
        }
        $relevance = DB::table('tz_business_relevance')->where(['type'=>1])->get(['id','business_id']);
        if(!empty($relevance)){
            foreach($relevance as $keys =>$values){
                $bb = DB::table('tz_business')->where(['business_number'=>$values->business_id])->first();
                if(empty($bb)){
                    $row = DB::table('tz_business_relevance')->where(['id'=>$values->id])->update(['deleted_at'=>date('Y-m-d H:i:s',time())]);
                }   
            }
        }
    }

}
