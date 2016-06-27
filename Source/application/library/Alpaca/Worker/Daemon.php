<?php
namespace Alpaca\Worker;

class Daemon
{
    private $deamon_json = __DIR__.'\deamon.json';
    
    private static $instance;
    
    private $onClass = [];
    
    public static function deamon()
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

    public function setDeamon($deamon_json)
    {
        $this->deamon_json =$deamon_json;
        return $this;
    }
    
    public function status()
    {
        $data = json_decode(file_get_contents($this->deamon_json));
        var_dump($data);
    }
           
    private function stop()
    {
        $data =new \stdClass();
        $data->code="1001";
        $data->message="Stop ";
        file_put_contents($this->deamon_json,json_encode($data),LOCK_EX);
    }
        
    public function start()
    {
        $data = json_decode(file_get_contents($this->deamon_json));
        if(empty($data) || empty($data->code) || $data->code == "1000" ){
            die("Error - exit,   Already running !");
        }
    
        $this->start();
    
        ignore_user_abort(true); // 忽略客户端断开
        set_time_limit(0);       // 设置执行不超时
    
        while(true){
            $data = json_decode(file_get_contents($this->deamon_json));
            if(empty($data) || empty($data->code) || $data->code == "1001" ){
                break;
            }
    
            $data->message = date("Y-m-d H:i:s" ,time())." : Working ...";
            file_put_contents($this->deamon_json, json_encode($data), LOCK_EX);
            sleep(5);
        }    
        $this->stop();
    }
}