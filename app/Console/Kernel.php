<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
//        \App\Console\Commands\Demo::class,  //测试用
        \App\Console\Commands\RenewalReminder::class,  //发送过期业务到客户邮箱
        \App\Console\Commands\OverdueAlterStatus::class,  //修改过期业务状态
        \App\Console\Commands\PastDueOrders::class,  //清理掉未付款的过期充值订单
        \App\Console\Commands\OverdueDJB::class,  //过期的流量叠加包修改状态并减去附加防御值
        \App\Console\Commands\UpdateXunsearch::class //更新迅搜索引文件
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

//        $schedule->command('demo:demo')->everyMinute();  //Demo

        $schedule->command('business:send-email-notice')->dailyAt('13:00');   //每天 13:00 定时向所有用户发送准备到期续费提醒邮件
        $schedule->command('business:update-xunsearch')->hourly();   ////每隔1小时  自动平滑自动更新迅搜索引
        $schedule->command('overlay:check-overlay-endtime')->hourly();   ////每隔1小时  检测已使用的叠加包的到期时间
        $schedule->command('business:update-xunsearch')->hourly(); //每隔一小时更新迅搜索引文件
//        $schedule->command('business:check-business-status')->hourly();            //每隔8小时 自动对过期业务修改状态为到期
//        $schedule->command('recharge:check-trade-status')->dailyAt('23:59');    //每天23:59 定时清理掉未付款的过期充值订单
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
