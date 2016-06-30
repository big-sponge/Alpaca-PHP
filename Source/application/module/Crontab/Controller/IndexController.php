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

    protected $request_str = '';

    protected $request_data = [];

    protected $return_data = [];
    
    public function init()
    {
        //过滤输入数据
        $this->dataFilter();
    }

    //处理POST数据 - JSON
    private function dataFilter()
    {
        $this->request_str = file_get_contents("php://input");
        $this->request_data = new \stdClass();

        if(empty($this->request_str)){
            return;
        }

        $tempClass=json_decode($this->request_str);
        if(!empty($tempClass)){
            foreach ($tempClass as $name => $value){
                $this->request_data->$name = addslashes(htmlspecialchars($value));
            }
        }
        $this->request_str = addslashes(htmlspecialchars($this->request_str));
    }
    
    //index
    public function indexAction()
    {
        die('Welcome !');
        return View::json();
    }
    
    public function statusAction()
    {
        $result = Daemon::deamon()->status();
        return View::json($result);
    }
               
    public function stopAction()
    {
        Daemon::deamon()->stop();
    }
    
    public function startAction()
    {
        $events = ['0'=>function(){
            Worker::worker()->action(['REQUEST_URI'=>"/crontab/index/task"]);
        }];
        
        Daemon::deamon()->setEvents($events);

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
        return View::json($result);
    }

    public function  checkTaskAction(){
        return View::html();
    }
    public function  index2Action(){
        return View::html();
    }
    
    //添加定时任务
    public function addTaskAction()
    {
         $task= array(
         'NAME'=>$this->request_data->NAME,                             //NAME
         'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
         'TYPE'=>$this->request_data->TASK_TYPE,                            // 1-ONCE,      2-LOOP
         'INTERVAL'=>$this->request_data->INTERVAL,                //year（年），month（月），hour（小时）minute（分），second（秒）
         'BEGIN_TIME'=>$this->request_data->BEGIN_TIME,   //开始时间
         'NEXT_TIME'=>'',       //下次执行时间
         'LAST_TIME'=>'',       //上次执行时间
         'ACTION'=>$this->request_data->ACTION,   //执行的ACTION
         'END_TIME'=>$this->request_data->END_TIME,   //执行的ACTION
        );

        $result = Crontab::crontab()->addTask($task);
        return View::json($result);
    }
    
    //编辑定时任务
    public function editTaskAction()
    {
        $task= array(
            'NAME'=>'EDIT',                             //NAME
            'STATUS'=>'1',                          // 1-ENABLED,   2-DISABLE
            'TYPE'=>'2',                            // 1-ONCE,      2-LOOP
            'INTERVAL'=>'+30 second',                //year（年），month（月），hour（小时）minute（分），second（秒）
            'BEGIN_TIME'=>date("Y-m-d H:i:s",time()),   //开始时间
            'NEXT_TIME'=>'',       //下次执行时间
            'LAST_TIME'=>'',       //上次执行时间
            'ACTION'=>'/crontab/index/job',   //执行的ACTION
        );
        $result = Crontab::crontab()->editTask(1,$task);
        var_dump($result);
    }

    //删除定时任务
    public function removeTaskAction()
    {
        $result = Crontab::crontab()->removeTask($this->request_data);
        return View::json($result);
    }
    
    //定时任务
    public function taskAction()
    {
        Log::add("task ... ");
        $result = Crontab::crontab()->doTask();
        die;
    }
    
    //定时任务
    public function jobAction()
    {
        Log::add("hahah jobs ... ");
        die();
    }
}

 