<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/6
 * Time: 上午11:29
 */
$pid = pcntl_fork();

if ($pid < 0) {
    exit('fork error.');
} else if ($pid > 0) {
    // 主进程退出
    exit();
}

// 最关键的一步来了，执行setsid函数！
if (!posix_setsid()) {
    exit('setsid error.');
}
$pid = pcntl_fork();
if ($pid < 0) {
    exit('fork error');
} else if ($pid > 0) {
    // 主进程退出
    exit;
}

// 子进程继续执行

// 啦啦啦，啦啦啦，啦啦啦，已经变成daemon啦，开心
@cli_set_process_title('testtesttest');
// 睡眠1000000，防止进程执行完毕挂了
for( $i = 1; $i <= 1000; $i++ ){
    sleep( 1 );
    echo "test".PHP_EOL;
}