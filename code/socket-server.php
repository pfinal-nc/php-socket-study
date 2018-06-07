<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, '127.0.0.1', 9090) or die('error');
socket_listen($socket, 5);
while (true) {
    $client = socket_accept($socket);   // 有人打电话进来
    $buf = socket_read($client, 1024);   // 一次读取1024的长度
    echo $buf;
    if (preg_match('/sleep/i', $buf)) {
        sleep(10);

        $html = 'HTTP/1.1 200 OK' . PHP_EOL
            . 'Content-Type: text/html;charset=utf-8' . PHP_EOL . PHP_EOL;
        socket_write($client, $html);
        socket_write($client, 'this is server,休克了10秒,模拟很繁忙的样子');
    } else {
        $html = 'HTTP/1.1 200 OK' . PHP_EOL
            . 'Content-Type: text/html;charset=utf-8' . PHP_EOL . PHP_EOL;
        socket_write($client, $html);
        socket_write($client, 'this is server');
    }

    socket_close($client);
}

socket_close($socket);