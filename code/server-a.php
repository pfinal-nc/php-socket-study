<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/5/31
 * Time: 上午11:37
 */

$sock = stream_socket_server("tcp://127.0.0.1:80", $errno, $errstr);

for ( ; ; ) {
    $conn = stream_socket_accept($sock);

    $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";

    fwrite($conn, $write_buffer);

    fclose($conn);
}

/**
 * 需要注意的是，这里不能使用socket_accept，
 * 因为stream_socket_server和socket_create创建的不是同一种资源，
 * stream_socket_server创建的是stream资源，
 * 这也是为什么可以用fwrite、fread、fclose操作该资源的原因.
 * 而socket_create创建的是socket资源，而不是stream资源，
 * 所以socket_create创建的资源只能用socket_write、socket_read、socket_close来操作.
 */