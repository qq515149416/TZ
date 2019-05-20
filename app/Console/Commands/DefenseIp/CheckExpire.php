<?php

namespace App\Console\Commands\DefenseIp;

use App\Http\Controllers\DefenseIp\ApiController;
use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\DB;

class CheckExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'defense-ip:check-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '高防IP检测过期业务,并将相关资源修改状态';

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
        //
//        return 'su';
//        echo $this->getNowTime();


//        $this->info($this->updateStoreStatus(19,1));
//        $this->info($this->getEndBusiness());


        // $this->check();

        // $this->info('END');//输出结束
        $this->checkOrders();
    }


    /**
     * 检查过期业务  并将过期业务根据通过API控制器修改修改后台
     *
     */
    protected function check()
    {

        $apiC            = new ApiController();   //实例化
        $endData         = $this->getEndBusiness();// 获取过期业务数据
        $alterSucceedSum = 0;//修改成功计数
        $alterFalseSum   = 0;//修改失败技术

        //遍历操作
        foreach ($endData as $key => $value) {
            $apiMsg = json_decode($apiC->deleteTarget($value['ip']), true);//发送api请求并将返回信息转成数组
            $this->info($apiMsg['code']);

            //统计接口使用状态
            switch ($apiMsg['code']) {
                case 0:  //状态码:0  成功
                    $alterSucceedSum++;
                    break;
                case 1:   //状态码:1  失败
                    $alterFalseSum++;
                    break;
                default:  //未知
                    break;
            }
        }
        $this->info('修改成功数:' . $alterSucceedSum);
        $this->info('修改失败数:' . $alterFalseSum);
    }


    /**
     * 获取过期业务数据
     */
    /**
     * @return mixed
     */
    protected function getEndBusiness()
    {
        $nowTime = Carbon::now();  //获取当前时间
        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
        ->join('tz_defenseip_store', 'tz_defenseip_business.ip_id', '=', 'tz_defenseip_store.id')//关联数组
        ->get()->toArray();  //获取数据比并转换成数组形式
        return $endData;
    }


    /**
     * 修改高防IP资源状态
     *
     * @param $storeId //资源id
     * @param $statusCode //修改状态码
     * @return bool      //成功:返回影响行数    失败:false
     */
    protected function updateStoreStatus($storeId, $statusCode)
    {
        //模型错误抛出异常
        try {
            $storeData         = StoreModel::find($storeId); //查找业务数据
            $storeData->status = $statusCode; //修改状态字段
            return $storeData->save(); //保存并返回影响行数量
        } catch (\Exception $e) {
            return false;
        }
    }


//    /**
//     * 发送数据到API
//     */
//    protected function sendApi()
//    {
//
//        ApiController::class->
//
//    }

    /**
     * 获取时间
     */
    protected function getNowTime()
    {
        return Carbon::now();
    }

    protected function checkOrders(){
        $orders = DB::table('tz_orders')
                    ->whereNull('deleted_at')
                    ->where(['order_status'=>0,'resource_type'=>11])
                    ->select('id','created_at','business_sn')
                    ->get();
        if(!$orders->isEmpty()){
            foreach($orders as $key => $value){
                $business = DB::table('tz_defenseip_business')->where(['business_number'=>$value->business_sn])->select('id')->first();
                if(empty($business)){
                    if(time()-strtotime($value->created_at) > 3600){
                        $row = DB::table('tz_orders')->where(['id'=>$value->id])->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                    }
                }
            }
        }

    }


}
