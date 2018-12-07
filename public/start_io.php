<?php
use Workerman\Worker;
use PHPSocketIO\SocketIO;

require __DIR__.'/../vendor/autoload.php';
$https_connection = array(
    // 'ssl' => array(
    //     'local_cert'  => __DIR__.'/server.crt',//证书
    //     'local_pk'    => __DIR__.'/server.key',//密钥
    //     'verify_peer' => false,
    // )
);
// ,$https_connection
$io = new SocketIO(8120,$https_connection);
// $io->on('connection',function($socket)use($io){
// 	// 后台发送到前台
//     $socket->on('admin_to_client',function($message)use($io){
//         $io->emit('to_id:'.$message['to_id'].'work_num:'.$message['work_number'],$message);
//     });
//     //前台发送到后台
//     $socket->on('client_to_admin',function($message)use($io){
//     	$io->emit('work_num:'.$message['work_number'],$message);
//     });
// });

$io->on('connection',function($socket){
	$socket->on('login',function($group)use($socket){//进行登录，加入对话分组
		$group = $group;
		$socket->join($group);
		$socket->group = $group;
    });
    $socket->on('leave',function($leave)use($socket){//进行退出，离开对话组
		$leave = $leave;
		$socket->leave($leave);
	});
});

// 启动监听另一个端口，通过这个端口可以给任意相关部门推送信息
$io->on('workerStart', function(){
	// 监听一个http端口
	$listen_worker = new Worker('http://0.0.0.0:8121');
	// 当http客户端发来数据时触发
	$listen_worker->onMessage = function($http_connection, $data){
		$_POST = $_POST ? $_POST : $_GET;
		if(!empty(@$_POST['work_order'])){//工单的推送
			global $io;
			$to_admin = 'depart'.@$_POST['work_order']['process_department'];//后台工单组
			$io->to($to_admin)->emit('new_work_order',$_POST['work_order']);//根据分组推送到后台
			if(@$_POST['work_order']['submitter']==1){
				$customer = 'customer'.@$_POST['work_order']['customer_id'];//前台工单组
				$io->to($customer)->emit('work_order',$_POST['work_order']);//根据分组推送到对应的客户
			}
		}
		if(!empty(@$_POST['work_chat'])){//工单沟通的推送
			global $io;
			$to_admin = 'work'.@$_POST['work_chat']['work_number'];//后台沟通组
			$io->to($to_admin)->emit('new_work_chat',$_POST['work_chat']);//将消息推送到对应的沟通组
			$customer = 'w'.@$_POST['work_chat']['work_number'].'c'.@$_POST['work_chat']['customer_id'];//前台沟通组
			$io->to($customer)->emit('work_chat',$_POST['work_chat']);//将消息推送到对应的沟通组
		}
		return $http_connection->send(' ');

	};
	$listen_worker->listen();//执行监听

});


if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
