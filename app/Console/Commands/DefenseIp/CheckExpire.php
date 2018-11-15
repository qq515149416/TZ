<?php

namespace App\Console\Commands\DefenseIp;

use App\Http\Models\DefenseIp\BusinessModel;
use App\Http\Models\DefenseIp\StoreModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Exceptions\Handler;

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

        $this->getEndBusiness();

        $this->info('END');//输出结束
    }





    /**
     * 获取过期业务数据
     */
    protected function getEndBusiness()
    {
        $nowTime = Carbon::now();  //获取当前时间
        $endData = BusinessModel::where('end_at', '<', $nowTime)//条件为当前时间大于结束时间时
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


    /**
     * 获取时间
     */
    protected function getNowTime()
    {
        return Carbon::now();
    }


}
