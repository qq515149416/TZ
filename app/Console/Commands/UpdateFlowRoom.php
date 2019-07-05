<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use XS;
use XSDocument;
use Illuminate\Support\Facades\DB;

/**
 * 用于平滑更新xunsearch的索引，解决某些数据因修改而搜索不到的问题
 */
class UpdateFlowRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:update-flow-room';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将前期的支付流水绑定机房id';

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
        $this->updateFlowRoom();
    }


    /**
     * 进行索引的更新
     * @return [type] [description]
     */
    public function updateFlowRoom(){
        $flows = DB::table('tz_orders_flow')->get(['id','business_number','room_id']);
        foreach ($flows as $key => $value) {
            if($value->room_id == 0){
                $business = DB::table('tz_business')->where(['business_number'=>$value->business_number])->value('resource_detail');
                if($business != Null){
                    $room_id = json_decode($business)->machineroom_id;
                    
                } else {
                    $room_id = DB::table('tz_defenseip_business as dp')
                            ->join('tz_defenseip_package as p','dp.package_id','=','p.id')
                            ->where(['dp.business_number'=>$value->business_number])
                            ->value('p.site');  
                }
                if($room_id != 0){
                    DB::table('tz_orders_flow')->where(['id'=>$value->id])->update(['room_id'=>$room_id]);
                }
                
            }
        }
    }

}
