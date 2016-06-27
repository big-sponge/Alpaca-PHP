<?php
namespace Alpaca\Worker;

/* $tasks[count($tasks)] = array(
    'NAME'=>'',                             //NAME
    'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
    'TYPE'=>'2',                            // 1-ONCE,      2-LOOP
    'INTERVAL'=>'+5 minute',                //year（年），month（月），hour（小时）minute（分），second（秒）
    'BEGIN_TIME'=>date("Y-m-d H:i:s",time()),   //开始时间
    'NEXT_TIME'=>'',       //下次执行时间
    'LAST_TIME'=>'',       //上次执行时间
    'ACTION'=>'/worker',   //执行的ACTION
); */

class Crontab
{        
    private $task_json = __DIR__.'\crontab.json';
    private $task_log = __DIR__.'\task_log.log';
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
        $data = json_decode(file_get_contents($this->task_json));
        var_dump($data);
    }

    //添加定时任务
    public function addTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json),true);
        var_dump($tasks);
        $tasks[count($tasks)] = array(
            'NAME'=>'',                             //NAME
            'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
            'TYPE'=>'2',                            // 1-ONCE,      2-LOOP
            'INTERVAL'=>'+5 minute',                //year（年），month（月），hour（小时）minute（分），second（秒）
            'BEGIN_TIME'=>date("Y-m-d H:i:s",time()),   //开始时间
            'NEXT_TIME'=>'',       //下次执行时间
            'LAST_TIME'=>'',       //上次执行时间
            'ACTION'=>'/worker',   //执行的ACTION
        );
    
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        var_dump($tasks);
    }

    //编辑定时任务
    public function editTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json));
        var_dump($tasks);
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        var_dump($tasks);
    }

    //删除定时任务
    public function removeTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json));
        var_dump($tasks);
        array_splice($tasks, 2, 1);
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        var_dump($tasks);
    }

    //定时任务
    public function doTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json));      
        if(empty($tasks)){ return ;}
    
        foreach ($tasks as &$task){
    
            $now = date('Y-m-d H:i:s',time());
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
    
    
            if($task['TYPE'] == 1 && (strtotime($now)<=strtotime($task['NEXT_TIME'])))
            {
                $task['LAST_TIME']= $task['NEXT_TIME'];
                $task['NEXT_TIME']='END';
                $task['STATUS']=2;
                //do Action
                continue;
            }
             
            if($task['TYPE'] == 2)
            {
                if(empty($task['NEXT_TIME'])){
                    $task['NEXT_TIME'] = $task['BEGIN_TIME'];
                }
    
                if(strtotime($now)<=strtotime($task['NEXT_TIME'])){
                    $task['LAST_TIME']= $task['NEXT_TIME'];
                    $task['NEXT_TIME']= date('Y-m-d H:i:s',strtotime($task['INTERVAL'],strtotime($task['NEXT_TIME'])));
                    //do Action
                }
    
                continue;
            }
        }
        var_dump($tasks);
    }
}