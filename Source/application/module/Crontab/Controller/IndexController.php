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
        
        $data = json_decode(file_get_contents($this->crontab_json));

        var_dump($data);

        die('worker!');
        
        $fp = fsockopen("192.168.1.15", 8081, $errno, $errstr, 1);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
        
            $out = "POST /auto/checkGroupAccountCange HTTP/1.1\r\n";
            $out .= "Host: 192.168.1.15\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $out .="\r\n";
            $out .="{'data':111}";
            fwrite($fp, $out);
            fclose($fp);
        }
        
        die('worker!');
    }
    
    private function doWorkerAction(array $worker)
    {
                
        $ip   = empty($worker['SERVER_ADDR']) ? '127.0.0.1' : $worker['SERVER_ADDR'];       //服务器IP地址
        
        $port = empty($worker['SERVER_PORT']) ? '80' : $worker['SERVER_PORT'];              //服务器端口
        
        $url  = $worker['REQUEST_URI'];                                                     //服务器URL
        
        die('worker!');
    
        $fp = fsockopen("192.168.1.15", 8081, $errno, $errstr, 1);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
    
            $out = "POST /auto/checkGroupAccountCange HTTP/1.1\r\n";
            $out .= "Host: 192.168.1.15\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $out .="\r\n";
            $out .="{'data':111}";
            fwrite($fp, $out);
            fclose($fp);
        }
    
        die('worker!');
    }
         
}

 