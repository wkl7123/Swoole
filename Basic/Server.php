<?php
/**
 * Created by PhpStorm.
 * User: chenchaojie
 * Date: 2016/6/30
 * Time: 9:11
 */


$serv = new swoole_server("0.0.0.0", 9502); // 表示监听所有ip地址

$serv->set(array(
    'worker_num' => 3,    //worker process num
    'max_request' => 50,
    'dispatch_mode' => 3,
    ''
));

//  注册连接的事件句柄
$serv->on('connect', function ($serv, $fd) {
    echo "Client:connect.\n";
});

// 注册一个接收请求数据的事件句柄
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {

    echo 'length=:'.strlen($data)."work_id={$serv->worker_pid}\n";
    $serv->send($fd, $data);
});


$serv->on('close', function ($serv, $fd) {
    echo  "Client: close.\n";
});

$serv->on('managerStart', function($serv) {
    echo "manager start.";
    echo "work_id={$serv->worker_pid}\n";
});

$serv->on('workerStart', function($serv, $worker_id) {
    echo "worker start\n";
});

$serv->on('workerStop', function($serv, $work_id) {
    echo "worker stop\n";
});

$serv->on('connect', function($serv, $fd, $reactorId) {
    echo "connect\n";
});

// 启动9502端口的服务
$serv->start();
