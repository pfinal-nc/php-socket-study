<?php

/**
 *  这个是一个处理高并发
 */

class WebServer
{
    private $list;

    public function __construct()
    {
        $this->list = [];
    }

    public function work($request)
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            return false;
        }
        if ($pid > 0) {
            return $pid;
        }
        if ($pid == 0) {
            $time = $request[0];
            $method = $request[1];
            $start = time();
            echo getmypid() . "\t start " . $method . "\tat" . $start . PHP_EOL;
            sleep($time);
            $end = time();
            $cost = $end - $start;
            echo getmypid() . "\t stop \t" . $method . "\tat:" . $end . "\tcost:" . $cost . PHP_EOL;
            exit(0);
        }
    }

    public function master($requests)
    {
        $start = time();
        echo "All request handle stop at " . $start . PHP_EOL;
        foreach ($requests as $request) {
            $pid = $this->work($request);
            if (!$pid) {
                echo 'handle fail!' . PHP_EOL;
                return;
            }
            array_push($this->list, $pid);
        }
        while (count($this->list) > 0) {
            foreach ($this->list as $k => $pid) {
                $res = pcntl_waitpid($pid, $status, WNOHANG);
                if ($res == -1 || $res > 0) {
                    unset($this->list[$k]);
                }
            }
            usleep(100);
        }
        $end = time();
        $cost = $end - $start;
        echo "All request handle stop at " . $end . "\t cost:" . $cost . PHP_EOL;
    }
}

$requests = [
    [1, 'GET index.php'],
    [2, 'GET index.php'],
    [3, 'GET index.php'],
    [4, 'GET index.php'],
    [5, 'GET index.php'],
    [6, 'GET index.php']
];

$server = new WebServer();
$server->master($requests);