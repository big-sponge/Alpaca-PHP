<?php 
namespace Model\Model;
class OperationLog
{ 
    const  TABLE_NAME = "tb_operation_log"; 

    public $operation_log_id; 
    public $user_id; 
    public $operation; 
    public $time; 
    public $ip; 
    public $user_agent;

    public $email;

    public function exchangeArray($data) 
    { 
        $this->operation_log_id= (!empty($data['operation_log_id'])) ? $data['operation_log_id'] : 0; 
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0; 
        $this->operation= (!empty($data['operation'])) ? $data['operation'] : 0; 
        $this->time= (!empty($data['time'])) ? $data['time'] : 0; 
        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0; 
        $this->user_agent= (!empty($data['user_agent'])) ? $data['user_agent'] : 0;

        $this->email= (!empty($data['email'])) ? $data['email'] : 0;
    } 
} 
