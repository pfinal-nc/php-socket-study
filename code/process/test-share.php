<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/6
 * Time: 上午10:57
 */

$number = 1;
$pid = pcntl_fork();

if ($pid > 0) {
    $number += 1;
    echo "我是父亲，number+1 : { $number }" . PHP_EOL;

} else if (0 == $pid) {
    $number += 2;
    echo "我是儿子，number+2 : { $number }" . PHP_EOL;

} else {
    echo "fork失败" . PHP_EOL;
}