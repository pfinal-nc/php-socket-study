<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/5/31
 * Time: 下午1:20
 */
$sock = stream_socket_server("tcp://127.0.0.1:80", $errno, $errstr);
var_dump($sock);exit;
$pids = [];

for ($i=0; $i<10; $i++) {

    $pid = pcntl_fork();
    $pids[] = $pid;

    if ($pid == 0) {
        for ( ; ; ) {
            $conn = stream_socket_accept($sock,$errno, $errstr);

            $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";

            fwrite($conn, $write_buffer);

            fclose($conn);
        }

        exit(0);
    }

}

foreach ($pids as $pid) {
    pcntl_waitpid($pid, $status);
}