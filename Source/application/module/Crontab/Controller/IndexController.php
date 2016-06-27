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
//        die('Welcome !');
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
        var_dump($result);           
    }
    
    //添加定时任务
    public function addTaskAction()
    {
        $result = Crontab::crontab()->addTask();
        var_dump($result);
    }
    
    //编辑定时任务
    public function editTaskAction()
    {
        $result = Crontab::crontab()->editTask();
        var_dump($result);
    }

    //删除定时任务
    public function removeTaskAction()
    {
        $result = Crontab::crontab()->removeTask();
        var_dump($result);
    }
    
    //定时任务
    public function taskAction()
    {
        Crontab::crontab()->task();
    }
}

 