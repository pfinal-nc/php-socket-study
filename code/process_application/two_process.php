<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/7
 * Time: 下午3:33
 */
$num = 50 * 10000; // 插入的数量
$tb_name = 'test_tb';
$sex_range = array("男", "女", "两性", "未知", "male", "female", "both", "unknow");
$sex_range_count = count($sex_range);
$unit_num = 10000;       // 单次插入数量
$p_list = array();

// 创建的进程数
$p_num = ceil($num / $unit_num);
$is_main_process = true;
// 用于统计总耗时的插入日志文件
$file = '/Users/nancheng/www/php-socket-study/code/process_application/insert.log';

// 清空插入日志（以便重新计算插入耗费时间）

$fs = fopen($file, 'w');
fwrite($fs, '');
fclose($fs);

for ($n = 1; $n <= $p_num; ++$n) {
    $min = ($n - 1) * $unit_num;
    $max = min($min + $unit_num, $num);
    // echo 'per insert number: min->' . $min . ' ; max->' . $max . PHP_EOL;
    $p = pcntl_fork();
    if ($p === -1) {
        exit('create process ' . $n . ' failed!' . PHP_EOL);

    } else if ($p === 0) {
        $is_main_process = false;
        $sql = 'insert into ' . $tb_name . ' (name , sex , height) values ';
        
        for ($i = $min; $i < $max; ++$i) {
            // name
            $name = 'ab' . rand(10, 999999);
            // sex
            shuffle($sex_range);

            $sex = $sex_range[rand(0, $sex_range_count - 1)];
            // height
            $height = rand(50, 175);

            $sql .= '("' . $name . '" , "' . $sex . '" , ' . $height . ') ,';
        }

        $sql = mb_substr($sql, 0, -1);
        $con = new PDO('mysql:host=127.0.0.1;dbname=process', 'root', 'root123456');

        // 每批次插入开始时间
        $s_time = microtime(true);

        if (!$con->query($sql)) {
            exit('插入批次：' . $n . ' 失败' . PHP_EOL);
        }

        // 每批次插入结束时间
        $e_time = microtime(true);
        // 每批次插入耗费的时间
        $duration = $e_time - $s_time;
        // 输出信息
        echo '插入批次 ' . $n . ' 花费时间： ' . $duration . 's' . PHP_EOL;

        // 记录每次插入耗时（用于统计总耗时）
        $fs = fopen($file, 'a');
        fwrite($fs, $duration . "\r\n");
        fclose($fs);

        break;
    } else {
        $p_list[] = $p;
    }
}

if ($is_main_process) {
    foreach ($p_list as $c_pid) {
        pcntl_waitpid($c_pid, $status);
    }

    $fs = fopen($file, 'r') or exit('process ' . $n . ' open the file failed!' . PHP_EOL);
    $total_time = 0;

    while ($line = fgets($fs)) {
        $line = str_replace("\r\n", '', $line);
        $line = floatval($line);
        $total_time += $line;
    }

    echo $p_num . ' 进程插入 ' . ($num / 10000) . 'W 条数据，单次插入 ' . ($unit_num / 10000) . 'W条，耗时：' . $total_time . ' s ' . PHP_EOL;

}