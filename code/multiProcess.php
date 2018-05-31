<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/5/31
 * Time: 下午1:12
 */

$pid = pcntl_fork();
//var_dump($pid);exit;

if ($pid) {
    //父进程
    echo "This is parent process\n";
    pcntl_waitpid($pid, $status);
} elseif ($pid == 0) {
    //子进程
    echo "This is child process\n";
} else {
    die("fork failed\n");
}



