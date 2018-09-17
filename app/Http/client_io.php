<?php
use Workerman\Worker;
use PHPSocketIO\SocketIO;

require dirname(dirname(__DIR__)).'\vendor\autoload.php';

$io = new SocketIO(9120);

$io->on('connection',function($socket)use($io){
    
    $socket->on('send message',function($message)use($io){
        $io->emit('work_num'.$message['work_num'],$message["content"]);   
    });
});

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
