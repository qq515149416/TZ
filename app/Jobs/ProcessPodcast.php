<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * 创建任务实例
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Execute the job.
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
        //

    }
}
