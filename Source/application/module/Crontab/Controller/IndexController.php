<?php
namespace Crontab\Controller;

use Alpaca\MVC\View\View;
use Alpaca\Log\Log;
use Alpaca\Worker\Crontab;
use Alpaca\Worker\Worker;
use Alpaca\Worker\Daemon;

class IndexController
{    
    private $crontab_json = __DIR__.'\crontab.json';
    
    public function init()
    {
        
    }
    
    //index
    public function indexAction()
    {
        die('Welcome !');
        return View::json();
    }
    
    public function statusAction()
    {
        Daemon::deamon()->status();
    }
               
    public function stopAction()
    {
        Daemon::deamon()->stop();
    }
    
    public function startAction()
    {
        Daemon::deamon()->start();
    }
        
    //异步调用
    public function workerAction()
    {
        Worker::worker()->doWorker(['REQUEST_DTAT'=>"ccc",'REQUEST_URI'=>"/crontab/worker/index",]);
    }
        
    //查看定时任务
    public function listTaskAction()
    {
        $result = Crontab::crontab()->listTask();
//        var_dump($result);
        return View::json($result);
    }

    public function  checkTaskAction(){
        return View::html();
    }
    
    //添加定时任务
    public function addTaskAction()
    {
         $task= array(
         'NAME'=>'',                             //NAME
         'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
         'TYPE'=>'2',                            // 1-ONCE,      2-LOOP
         'INTERVAL'=>'+5 minute',                //year（年），month（月），hour（小时）minute（分），second（秒）
         'BEGIN_TIME'=>date("Y-m-d H:i:s",time()),   //开始时间
         'NEXT_TIME'=>'',       //下次执行时间
         'LAST_TIME'=>'',       //上次执行时间
         'ACTION'=>'/worker',   //执行的ACTION
        ); 
        
        $result = Crontab::crontab()->addTask($task);
        var_dump($result);
    }
    
    //编辑定时任务
    public function editTaskAction()
    {
        $task= array(
            'NAME'=>'EDIT',                             //NAME
            'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
            'TYPE'=>'2',                            // 1-ONCE,      2-LOOP
            'INTERVAL'=>'+5 minute',                //year（年），month（月），hour（小时）minute（分），second（秒）
            'BEGIN_TIME'=>date("Y-m-d H:i:s",time()),   //开始时间
            'NEXT_TIME'=>'',       //下次执行时间
            'LAST_TIME'=>'',       //上次执行时间
            'ACTION'=>'/worker',   //执行的ACTION
        );
        $result = Crontab::crontab()->editTask(1,$task);
        var_dump($result);
    }

    //删除定时任务
    public function removeTaskAction()
    {
        $result = Crontab::crontab()->removeTask(0);
        var_dump($result);
    }
    
    //定时任务
    public function taskAction()
    {
        Crontab::crontab()->task();
    }
}

 