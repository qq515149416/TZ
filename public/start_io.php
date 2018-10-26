<?php
use Workerman\Worker;
use PHPSocketIO\SocketIO;

require __DIR__.'/../vendor/autoload.php';

$io = new SocketIO(8120);

$io->on('connection',function($socket)use($io){
	// 后台发送到前台
    $socket->on('admin_to_client',function($message)use($io){
        $io->emit('to_id:'.$message['to_id'].'work_num:'.$message['work_number'],$message["answer_content"]);
    });
    //前台发送到后台
    $socket->on('client_to_admin',function($message)use($io){
    	$io->emit('work_num:'.$message['work_number'],$message["answer_content"]);
    });
});

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
