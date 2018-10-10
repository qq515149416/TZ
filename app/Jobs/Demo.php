<?php
/**
 * 任务队列  样式
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class Demo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     * 创建任务
     *
     * @return void
     */
    public function __construct($podcast)
    {
        //
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        DB::table('test')->insert(
            ['key' => 'john@example.com', 'value' => 7]
        );
    }
}
