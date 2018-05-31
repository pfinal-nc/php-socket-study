<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/5/31
 * Time: 下午1:16
 */

$pid = pcntl_fork();

if ($pid) {
    //父进程
    echo "This is parent process\n";
    sleep(30);
} elseif ($pid == 0) {
    //子进程
    echo "This is child process\n";
} else {
    die("fork failed\n");
}