<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/6
 * Time: 上午10:07
 */
$servsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  // 创建一个socket

if (false == $servsock) {
    $errcode = socket_last_error();
    fwrite(STDERR, "socket 创建失败: " . socket_strerror($errcode));
    exit(-1);
}

if (!socket_bind($servsock, '127.0.0.1', 8888))    // 绑定ip地址及端口
{
    $errcode = socket_last_error();
    fwrite(STDERR, "socket bind fail: " . socket_strerror($errcode));
    exit(-1);
}

if (!socket_listen($servsock, 128))      // 允许多少个客户端来排队连接
{
    $errcode = socket_last_error();
    fwrite(STDERR, "socket listen fail: " . socket_strerror($errcode));
    exit(-1);
}

//循环去响应客户端连接
while (true)
{
    $connsock = socket_accept($servsock);  //响应客户端连接

    if ($connsock)
    {
        socket_getpeername($connsock, $addr, $port);  //获取连接过来的客户端ip地址和端口
        echo "client connect server: ip = $addr, port = $port" . PHP_EOL;

        while (true)
        {
            $data = socket_read($connsock, 1024);  //从客户端读取数据

            if ($data === '')
            {
                //客户端关闭
                socket_close($connsock);
                echo "client close" . PHP_EOL;
                break;
            }
            else
            {
                echo 'read from client:' . $data;
                $data = strtoupper($data);  //小写转大写
                socket_write($connsock, $data);  //回写给客户端
            }
        }
    }
}

socket_close($servsock);