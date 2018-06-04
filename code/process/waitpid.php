<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/4
 * Time: 下午5:18
 */


$childs = array();

// Fork10个子进程
for ($i = 0; $i < 10; $i++) {
    $pid = pcntl_fork();
    if ($pid == -1)
        die('Could not fork');

    if ($pid) {
        echo "parent \n";
        $childs[] = $pid;
    } else {
// Sleep $i+1 (s). 子进程可以得到$i参数
        sleep($i + 1);

// 子进程需要exit,防止子进程也进入for循环
        exit();
    }
}

while (count($childs) > 0) {
    foreach ($childs as $key => $pid) {
        $res = pcntl_waitpid($pid, $status, WNOHANG);

//-1代表error, 大于0代表子进程已退出,返回的是子进程的pid,非阻塞时0代表没取到退出子进程
        if ($res == -1 || $res > 0)
            unset($childs[$key]);
    }

    sleep(1);
}