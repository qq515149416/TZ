<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Admin\Models\Business\BusinessModel;
use App\Admin\Models\Business\OrdersModel;
use XS;
use XSDocument;

/**
 * 用于平滑更新xunsearch的索引，解决某些数据因修改而搜索不到的问题
 */
class UpdateXunsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:update-xunsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '平滑更新xunsearch的索引';

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
        $this->updateXunsearch();
    }

    /**
     * 进行索引的更新
     * @return [type] [description]
     */
    public function updateXunsearch(){
        //业务
        $business = new BusinessModel();
        $business_result = $business->where('business_status','>','-1')->where('business_status','<',5)->where('remove_status','<',4)->select('resource_detail','id','client_id','machine_number','business_number')->get();
        if(!$business_result->isEmpty()){
            $xunsearch = new XS('business');
            $index = $xunsearch->index;
            $index->beginRebuild();
            foreach($business_result as $business_key=>$business_value){
                $resource = json_decode($business_value->resource_detail);
                $doc['ip'] = isset($resource->ip)?strtolower($resource->ip):'';
                $doc['cpu'] = isset($resource->cpu)?strtolower($resource->cpu):'';
                $doc['memory'] = isset($resource->memory)?strtolower($resource->memory):'';
                $doc['harddisk'] = isset($resource->harddisk)?strtolower($resource->harddisk):'';
                $doc['id'] = strtolower($business_value->id);
                $doc['business_sn'] = strtolower($business_value->business_number);
                $doc['machine_number'] = strtolower($business_value->machine_number);
                $doc['client'] = strtolower($business_value->client_id);
                $document = new \XSDocument($doc);
                $index->add($document);
            }
            $index->endRebuild();
        }
        //相关资源
        $order = new OrdersModel();
        $order_result = $order->where('order_status','<',3)->where('remove_status','<',4)->where('resource_type','>',3)->select('id','machine_sn','business_sn','order_sn')->get();
        if(!$order_result->isEmpty()){
            $xunsearch = new XS('orders');
            $index = $xunsearch->index;
            $index->beginRebuild();
            foreach ($order_result as $order_key => $order_value) {
                $doc['id'] = strtolower($order_value->id);
                $doc['machine_sn'] = strtolower($order_value->machine_sn);
                $doc['business_sn'] = strtolower($order_value->business_sn);
                $doc['order_sn'] = strtolower($order_value->order_sn);
                $document = new \XSDocument($doc);
                $index->add($document);
            }
            $index->endRebuild();
        }
        
    }

}
