<?php

namespace App\Console\Commands;

use App\Admin\Models\Business\BusinessModel;
use Illuminate\Console\Command;

/**
 * 将过期业务修改为过期续续费状态
 *
 * Class OverdueAlterStatus
 * @package App\Console\Commands
 */
class OverdueAlterStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:check-business-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测业务中已经过期的业务，并修改业务状态';

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
        $this->info($this->selectOverdue());  //

    }


    /**
     * 查询已经过期的业务
     */
    public function selectOverdue()
    {
        $businessModel = new BusinessModel(); //实例化
//        $nowDate       = date('Y-m-d H:i:s');//当前日期

        $data = $businessModel
            ->where(
                'endding_time', '<', date('Y-m-d H:i:s')
            )
            ->get();

        return $data;
    }

    /**
     * 修改业务状态
     */
    public function alterStatus()
    {
        $businessModel = new BusinessModel(); //实例化



    }

}
