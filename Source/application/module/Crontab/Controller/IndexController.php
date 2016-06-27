<?php
namespace Crontab\Controller;

use Alpaca\MVC\View\View;
use Alpaca\Log\Log;

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
        $data = json_decode(file_get_contents($this->crontab_json));
        var_dump($data);
    }
    
    
    private function start()
    {        
        $data =new \stdClass();
        $data->code="1000";
        $data->message="Running ...";       
        file_put_contents($this->crontab_json,json_encode($data),LOCK_EX);
    }
    
    private function stop()
    {
        $data =new \stdClass();
        $data->code="1001";
        $data->message="Stop ";
        file_put_contents($this->crontab_json,json_encode($data),LOCK_EX);
    }
        
    public function stopAction()
    {
        $this->stop();
        echo "stop ok!";
    }
    
    public function startAction()
    {
        Log::add("Start Work ...");
        $data = json_decode(file_get_contents($this->crontab_json));
        if(empty($data) || empty($data->code) || $data->code == "1000" ){
            Log::add("Error - exit,   Already running !");
            die("Error - exit,   Already running !");
        }
        
        $this->start();
                
        ignore_user_abort(true); // 忽略客户端断开
        set_time_limit(0);       // 设置执行不超时
        
        while(true){           
            $data = json_decode(file_get_contents($this->crontab_json));
            if(empty($data) || empty($data->code) || $data->code == "1001" ){
                Log::add("exit, status change...");
                break;
            }           
            
            $data->message = date("Y-m-d H:i:s" ,time())." : Working ...";            
            file_put_contents($this->crontab_json, json_encode($data), LOCK_EX);
            sleep(2);                        
        }
        
        $this->stop();
        
        Log::add("End Work ...");       
        die("Exit:".date("Y-m-d H:i:s" ,time()));
    }
    
    
    //异步调用
    public function workerAction()
    {
        $this->doWorker(['REQUEST_DTAT'=>"ccc",'REQUEST_URI'=>"/crontab/worker/index",]);
        die('worker!');
    }
    
    private function doWorker(array $worker = null)
    {
        $ip   = empty($worker['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $worker['SERVER_ADDR'];     //服务器IP地址       
        $port = empty($worker['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : $worker['SERVER_PORT'];     //服务器端口       
        $url  = empty($worker['REQUEST_URI']) ? '/' :$worker['REQUEST_URI'];                          //服务器URL
        $data = empty($worker['REQUEST_DTAT']) ? '' :$worker['REQUEST_DTAT'];                         //请求参数

        $fp = fsockopen("{$ip}", $port, $errno, $errstr, 1);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $out = "POST {$url} HTTP/1.1\r\n";
            $out .= "Host: {$ip}\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $out .="\r\n";
            $out .=$data;
            fwrite($fp, $out);
            fclose($fp);
        }
        return 'worker!';
    }
    
    //定时任务
    public function taskAction()
    {
        $task = array(
            'ID'=>'',           //ID
            'STATUS'=>'',       // 1-ENABLED,   2-DISABLE  
            'TYPE'=>'',         // 1-ONCE,      2-LOOP
            'INTERVAL'=>'',     //year（年），month（月），hour（小时）minute（分），second（秒）
            'BEGIN_TIME'=>'',   //开始时间
            'NEXT_TIME'=>'',    //下次执行时间
            'LAST_TIME'=>'',    //上次执行时间
            'ACTION'=>'',       //执行的ACTION
        );
        
        $tasks = array();
        
        foreach ($tasks as $task){
            
        }
        
        
        echo "今天:",date('Y-m-d H:i:s'),"<br>";
        echo "明天:",date('Y-m-d H:i:s',strtotime('+5 minute'));
                
        die('worker!');
    }
}

 