<?php

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//var_dump($sock); 正确返回一个Socket资源

socket_bind($sock, "127.0.0.1", 8080); //绑定连接地址到socket

socket_listen($sock); //监听一个socket

while (true) {
    $conn = socket_accept($sock);
    $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";
    socket_write($conn, $write_buffer);
    socket_close($conn);
}
