<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/6
 * Time: 下午12:53
 * 使用redis 和 多进程 处理消息队列
 */

$redis = new Redis();
//var_dump($redis);exit;
$redis->connect('127.0.0.1', 6379);
//echo "Server is running: " . $redis->ping();

$redis->set('key', 'TK');
$redis->set('number', '1');
$redis->setex('key', 5, 'TK'); //设置有效期为5秒的键值
$redis->psetex('key', 5000, 'TK'); //设置有效期为5000毫秒(同5秒)的键值
$redis->setnx('key', 'XK'); //若键值存在返回false 不存在返回true
$redis->delete('key'); //删除键值 可以传入数组 array('key1', 'key2')删除多个键
$redis->getSet('key', 'XK'); //将键key的值设置为XK， 并返回这个键值原来的值TK


$redis->lPush('list-key', 'A'); //插入链表头部/左侧，返回链表长度

var_dump($redis->lSize('list-key'));

$redis->sAdd('key' , 'TK');
var_dump($redis->sMembers('key'));

$redis->hSet('h', 'name', 'TK');
$redis->hMset('h', array('score' => '80', 'salary' => 2000));
var_dump($redis->hLen('h'));
var_dump($redis->hKeys('h'));
var_dump($redis->hVals('h'));
var_dump($redis->hGetAll('h'));
