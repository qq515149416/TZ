<?php
use Workerman\Worker;
use PHPSocketIO\SocketIO;

require __DIR__.'/../vendor/autoload.php';
$https_connection = array(
    'ssl' => array(
        'local_cert'  => __DIR__.'/server.crt',//证书
        'local_pk'    => __DIR__.'/server.key',//密钥
        'verify_peer' => false,
    )
);
$io = new SocketIO(8120,$https_connection);
$io->on('connection',function($socket)use($io){
	$socket->on('login',function($depart_id)use($socket){
		global $depart_map;
		$depart_id = (string)$depart_id;
		++$depart_map[$depart_id];//表示有多少部门连接
		$socket->join($depart_id);
		$socket->depart_id = $depart_id;
	});
	// 后台发送到前台
    $socket->on('admin_to_client',function($message)use($io){
        $io->emit('to_id:'.$message['to_id'].'work_num:'.$message['work_number'],$message);
    });
    //前台发送到后台
    $socket->on('client_to_admin',function($message)use($io){
    	$io->emit('work_num:'.$message['work_number'],$message);
    });
});

// 启动监听另一个端口，通过这个端口可以给任意相关部门推送信息
$io->on('workerStart',function(){
	// 监听一个https端口
	$listen_worker = new Worker('http://0.0.0.0:8121');
	$listen_worker->onMessage = function($http_connection, $data){
		global $depart_map; 
		$_POST = $_POST ? $_POST : $_GET;
		global $io;
		$to_department = @$_POST['process_department'];
		$io->to($to_department)->emit('new_work_order',$_POST);
	};
	$listen_worker->listen();//执行监听

});

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
