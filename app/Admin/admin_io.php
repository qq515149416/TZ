<?php
use Workerman\Worker;
use PHPSocketIO\SocketIO;

require dirname(dirname(__DIR__)).'\vendor\autoload.php';

$io = new SocketIO(8120);

$io->on('connection',function($socket)use($io){
    $socket->on('send message',function($message)use($io){
        $io->emit('to_id'.$message['to_id'],$message["content"]);     
    });
});

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
