<?php
use Workerman\Worker;
use Workerman\Protocols\Websocket;

require_once __DIR__ . '/workerman353/Autoloader.php';
require_once __DIR__ . '/global.php';

set_error_handler('myException'); 

date_default_timezone_set("PRC");

if (isset($argv[1]) && $argv[1] == 'start') {
    define('DEBUG_MODE', true);
    echo date("Y/m/d H:i:s") . " Game run in debug mode.\n";
} else {
    define('DEBUG_MODE', false);
    echo date("Y/m/d H:i:s") . " Game run in normal mode.\n";
}

// 创建一个Worker监听端口，使用websocket协议通讯
$ws_worker = new Worker("websocket://" . IP_ADDRESS . ":" . PORT);

// 启动4个进程对外提供服务, windows下无效
$ws_worker->count = 1;

// 当服务器启动时
$ws_worker->onWorkerStart = function($ws_worker)
{
    if($ws_worker->id === 0)
    {
        global $GAME;
        $GAME->onWorkerStart($ws_worker);
    }
};

// 当收到客户端连接请求时
$ws_worker->onConnect = function($connection)
{
    global $GAME;
    $GAME->onConnect($connection);
};

// 当收到客户端发送信息时
$ws_worker->onMessage = function($connection, $data)
{
    global $GAME;
    $GAME->onMessage($connection, $data);
};

$ws_worker->onError = function($connection, $code, $msg)
{
    echo "error $code $msg\n";
};

Worker::runAll();

function myException($errno,$errstr,$errfile,$errline)  
{  
    echo "\nERROR: ". $errstr . ' FOUND IN FILE ' .$errfile . ' AT LINE ' . $errline . '.';
} 
