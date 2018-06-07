<?php


/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/7
 * Time: 下午2:46
 */
include './PcntlTrait.php';
class PcntlImp
{
    use PcntlTrait;
}


$arr = [1,2,3,4,5,6,7,8,9,10];

$imp = new \PcntlImp();
$imp->worker(2);

$data = $imp->pcntl_call($arr, function($info){
    if (empty($info)){
        return [];
    }

    $ret = [];
    foreach ($info as $item) {
        $ret[] = $item * $item;
    }
    return $ret;
});

var_dump(count($data));