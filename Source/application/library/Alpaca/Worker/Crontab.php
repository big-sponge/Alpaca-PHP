<?php
namespace Alpaca\Worker;

class Crontab
{        
    private $task_json = __DIR__.'/crontab.json';
    private $task_log = __DIR__.'/task_log.log';
    private static $instance;
    
    public static function crontab()
    {
        return self::getInstance();
    }

    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    //查看定时任务
    public function listTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json));
        return $tasks;
    }

    //添加定时任务
    public function addTask($task)
    {
        $result["result_code"] = "1";
        $result["result_message"] = "添加成功";

        $tasks = json_decode(file_get_contents($this->task_json),true);
        $tasks[count($tasks)] = $task;
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $result;
    }

    //编辑定时任务
    public function editTask($index,$task)
    {
        $tasks = json_decode(file_get_contents($this->task_json));
        $tasks[$index] = $task;
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $tasks;
    }

    //删除定时任务
    public function removeTask($data)
    {
        $result_data["result_code"] = "1";
        $result_data["result_message"] = "删除任务【".$data->index."】成功";
        $index = $data->index;
        $tasks = json_decode(file_get_contents($this->task_json));
        array_splice($tasks, $index, 1);
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $result_data;
    }

    //定时任务
    public function doTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json) ,true);      
        if(empty($tasks)){ return ;}
    
        $now = date('Y-m-d H:i:s',time());
        foreach ($tasks as &$task){
            if(empty($task['STATUS']) || empty($task['TYPE'])  || empty($task['BEGIN_TIME']) || empty($task['ACTION']) )
            {
                continue;
            }
    
            if($task['STATUS'] != 1)
            {
                continue;
            }
    
            if($task['TYPE'] == 1 && empty($task['NEXT_TIME']) )
            {
                continue;
            }
    
            if($task['TYPE'] == 2 && empty($task['INTERVAL']) )
            {
                continue;
            }
    
            if(!empty($task['NEXT_TIME']) && $task['NEXT_TIME']=='END' )
            {
                continue;
            }
    
            if($task['TYPE'] == 1 && (strtotime($now)>=strtotime($task['NEXT_TIME'])))
            {
                $task['LAST_TIME']= $now;
                $task['NEXT_TIME']='END';
                $task['STATUS']=2;
                Worker::worker()->action(['REQUEST_URI'=>"{$task['ACTION']}"]);
                continue;
            }
             
            if($task['TYPE'] == 2)
            {
                if(empty($task['NEXT_TIME'])){
                    $task['NEXT_TIME'] = $task['BEGIN_TIME'];
                }

                if(strtotime($now)>=strtotime($task['NEXT_TIME'])){
                    $task['LAST_TIME']= $now;
                    $task['NEXT_TIME']= date('Y-m-d H:i:s',strtotime($task['INTERVAL']) );                    
                    Worker::worker()->action(['REQUEST_URI'=>"{$task['ACTION']}"]);
                }
                continue;
            }
        }
        
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $tasks;
    }
}