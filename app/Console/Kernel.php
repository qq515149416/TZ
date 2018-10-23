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

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

//        $schedule->command('demo:demo')->everyMinute();  //Demo

        $schedule->command('business:send-email-notice')->dailyAt('13:00');   //每天 13:00 定时向所有用户发送准备到期续费提醒邮件
//        $schedule->command('business:send-email-notice')->dailyAt('13:00');   //每隔8小时 自动对过期业务修改状态为到期



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
