<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2018/6/7
 * Time: 下午2:44
 */

trait PcntlTrait
{
    private $workers = 1;

    public function worker($count)
    {
        $this->workers = $count;
    }

    public function pcntl_call($all, \Closure $callback)
    {
        $perNum = ceil(count($all) / $this->workers);

        $pids = [];
        for($i = 0; $i < $this->workers; $i++){
            $pids[$i] = pcntl_fork();
            switch ($pids[$i]) {
                case -1:
                    echo "fork error : {$i} \r\n";
                    exit;
                case 0:
                    $data = [];
                    try {
                        $data = $callback(array_slice($all, $i * $perNum, $perNum));
                    } catch(\Exception $e) {
                        echo ($e->getMessage());
                    }

                    $shm_key = ftok(__FILE__, 't') . getmypid();
                    $data = json_encode($data);
                    $shm_id = shmop_open($shm_key, "c", 0777, strlen($data) + 10);
                    shmop_write($shm_id, $data, 0);
                    shmop_close($shm_id);
                    exit;
                default:
                    break;
            }
        }

        // only master process will go into here
        $ret = [];
        foreach ($pids as $i => $pid) {
            if($pid) {
                pcntl_waitpid($pid, $status);

                $shm_key = ftok(__FILE__, 't') . $pid;
                $shm_id = shmop_open($shm_key, "w", 0, 0);

                $data = trim(shmop_read($shm_id, 0, shmop_size($shm_id)));
                $data = json_decode($data, true);
                $ret = array_merge($ret, $data);
                @shmop_close($shm_id);
                @shmop_delete($shm_id);
            }
        }

        return $ret;
    }
}