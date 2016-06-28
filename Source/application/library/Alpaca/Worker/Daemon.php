<?php
namespace Alpaca\Worker;

class Daemon
{
    private $deamon_json = __DIR__.'\deamon.json';
    
    private static $instance;
    
    private $events = [];
    
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
        $this->deamon_json = $deamon_json;
        return $this;
    }
    
    public function setEvents(array $events)
    {
        $this->events = $events;
        return $this;
    }

    public function status()
    {
        $data = json_decode(file_get_contents($this->deamon_json));
        var_dump($data);
    }
           
    public function stop()
    {
        $data =new \stdClass();
        $data->code="1001";
        $data->message="Stop at:".date("Y-m-d H:i:s" ,time());
        file_put_contents($this->deamon_json,json_encode($data),LOCK_EX);
        die($data->message);
    }
        
    public function start()
    {
        $data = json_decode(file_get_contents($this->deamon_json) , true);
        if(empty($data)){
            $data['code']="1001";
        }
        
        if($data['code'] == "1000" ){
            die("Error - exit,   Already running !");
        }

        $data['code']="1000";
        $data['message']="Start";
        file_put_contents($this->deamon_json,json_encode($data),LOCK_EX);
        
        ignore_user_abort(true); // 忽略客户端断开
        set_time_limit(0);       // 设置执行不超时

        while(true){
            $data = json_decode(file_get_contents($this->deamon_json) , true);
            if(empty($data) || empty($data['code']) || $data['code'] == "1001" ){
                break;
            }

            if(!empty($this->events)){
                foreach ($this->events as $e){
                    $e();
                }
            }
                        
            $data['message'] = date("Y-m-d H:i:s" ,time())." : Working ...";
            file_put_contents($this->deamon_json, json_encode($data), LOCK_EX);
            sleep(1);
        }
        $this->stop();
    }
}