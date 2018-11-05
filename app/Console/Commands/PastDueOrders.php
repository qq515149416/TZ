<?php

namespace App\Console\Commands;

use App\Http\Models\Pay\AliRecharge;
use Illuminate\Console\Command;

/**
 * 将过期业务修改为过期续续费状态
 *
 * Class OverdueAlterStatus
 * @package App\Console\Commands
 */
class PastDueOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:check-trade-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测充值订单中未付款的订单，并将过期的清理掉';

    /**
     * Create a new command instance.
     * 创建
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 执行
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info($this->delPastOrder());  //删除过期订单

    }


    /**
     * 
     *
     *
     *
     */
    public function delPastOrder()
    {
        $model = new AliRecharge(); //实例化

        $pastTime = bcsub(time(),'86400');
        $pastTime = date('Y-m-d H:i:s',$pastTime);
        
        $data = $model
            ->where(
                'created_at', '<', $pastTime  //当 创建时间小于 过期时间时
            )
            ->where([
                'trade_status' => 0
            ])
            ->delete();

        return $data;  //返回修改个数
    }

}
