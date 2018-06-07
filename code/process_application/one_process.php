<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/7
 * Time: 下午3:00
 */
$con = new PDO('mysql:host=127.0.0.1;dbname=process' , 'root' , 'root123456');
$tb_name = 'test_tb';
$num              = 50;
$sex_range          = array("男" , "女" , "两性" , "未知" , "male" , "female" , "both" , "unknow");
$sex_range_count = count($sex_range);
$unit_num          = 10000;
$p_list          = array();
$sql = 'insert into ' . $tb_name . ' (name , sex , height) values ';
$p_num = ceil($num / $unit_num);
$is_main_process = true;


for ($i = 1; $i <= $num; ++$i)
{
    // name
    $name = 'ab'.rand(10 , 999999);
    // sex
    shuffle($sex_range);

    $sex = $sex_range[rand(0 , $sex_range_count - 1)];
    // height
    $height = rand(50 , 175);

    $sql .= '("' . $name . '" , "' . $sex . '" , ' . $height . ') ,';
}


$sql = mb_substr($sql , 0 , -1);

$s_time = microtime(true);

if (!$con->query($sql)) {
    exit('插入失败' . PHP_EOL);
}

$e_time = microtime(true);
$duration = $e_time - $s_time;

echo '插入 ' . ($num / 10000) . 'W 条数据花费时间：' . $duration . ' s' . PHP_EOL;