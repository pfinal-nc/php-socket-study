<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/5/31
 * Time: 下午2:52
 */
set_time_limit(0);
$ip = "127.0.0.1";
$port = 1935;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "socket_create() 失败的原因是:" . socket_strerror($sock) . "\n";
}

if (($ret = socket_bind($sock, $ip, $port)) < 0) {
    echo "socket_bind() 失败的原因是:" . socket_strerror($ret) . "\n";
}

if (($ret = socket_listen($sock, 4)) < 0) {
    echo "socket_listen() 失败的原因是:" . socket_strerror($ret) . "\n";
}

$count = 0;

do {

    if (($msgsock = socket_accept($sock)) < 0) {
        echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
        break;
    } else {
        $msg ="测试成功！\n";
        socket_write($msgsock, $msg, strlen($msg));
        echo "测试成功了啊\n";
        $buf = socket_read($msgsock,8192);
        $talkback = "收到的信息:$buf\n";
        echo $talkback;
        if(++$count >= 5){
            break;
        }
    }
    socket_close($msgsock);
} while (true);
socket_close($msgsock);