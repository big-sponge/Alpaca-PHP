<?php
namespace Alpaca\Worker;

class Crontab
{
    private $task_json = __DIR__.'/crontab.json';
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
    
    public function setConfig($crontab)
    {
        $this->task_json = $crontab;
        return $this;
    }
        
    //查看定时任务
    public function listTask()
    {
        $tasks = json_decode(file_get_contents($this->task_json));
        $i = 0;
        foreach ($tasks as $task)
        {
            $tasks[$i]->INTERVAL = $this->timeToStr($tasks[$i]->INTERVAL);
            $i++;
        }
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
        $result["result_code"] = "1";
        $result["result_message"] = "修改成功";
        $tasks = json_decode(file_get_contents($this->task_json));
        $tasks[$index] = $task;
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $result;
    }

    //编辑定时任务状态
    public function editTaskStatus($index,$status)
    {
        $result_data["result_code"] = "1";
        $result_data["result_message"] = "修改状态成功[".$status."]";
        $tasks = json_decode(file_get_contents($this->task_json));
        $tasks[$index]->STATUS = $status;
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $result_data;
    }

    public function getIndexTask($index)
    {
        $result_data["result_code"] = "1";
        $result_data["result_message"] = "获取任务成功【".$index."】";
        $tasks = json_decode(file_get_contents($this->task_json));
        $result_data["result_data"] = $tasks[$index];
        return $result_data;
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
            
            if(!empty($task['END_TIME']) && strtotime($now)>=strtotime($task['END_TIME'])){
                $task['NEXT_TIME']='END';
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
                    $task['NEXT_TIME']= date('Y-m-d H:i:s',strtotime($task['INTERVAL']));
                    Worker::worker()->action(['REQUEST_URI'=>"{$task['ACTION']}"]);
                }
                continue;
            }
        }
        
        file_put_contents($this->task_json, json_encode($tasks), LOCK_EX);
        return $tasks;
    }

    private function timeToStr($interval)
    {
        $result = "";
        if($interval != null && $interval != ""){
            $temp = explode(" ", $interval);
            $iNumTemp = $temp[0];
            $iType = $temp[1];
            $iNum = str_replace("+", "", $iNumTemp);
            $str = "";
            switch ($iType){
                case "year":
                    $str = "（年）";
                    break;
                case "month":
                    $str = "（月）";
                    break;
                case "month":
                    $str = "（日）";
                    break;
                case "hour":
                    $str = "（小时）";
                    break;
                case "minute":
                    $str = "（分）";
                    break;
                case "second":
                    $str = "（秒）";
                    break;
                default:
                    break;
            }
           $result = $iNum. $str;
        }
        return $result;
    }
}