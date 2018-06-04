<?php
/**
 * 写日志
 */
function worker()
{
    $pid = pcntl_fork();
    if ($pid == -1) {
        exit('创建紫子进程失败');
    }
    if ($pid == 0) {
        for ($i = 0; $i < 50; $i++) {
            file_put_contents("log", "hello {$i}\n", FILE_APPEND);
            sleep(1);
        }
    }
}

/**
 * 子进程
 */
function children()
{
    $sid = posix_setsid(); //获取子进程
    echo $sid;
    for ($i = 0; $i < 2; $i++) {
        worker();
    }
    //sleep(100);
    if ($sid == -1) {
        exit('创建子进程失败');
    }
    //sleep(100);
    pcntl_wait($status);
}

$pid = pcntl_fork();
if ($pid == -1) {
    exit('创建子进程失败');
}

if ($pid == 0) {
    children();
} else {
    exit('parent exit');
}