<?php 
namespace Model\Model;
class LoginLog
{ 
    const  TABLE_NAME = "tb_login_log"; 

    public $login_log_id; 
    public $user_id; 
    public $login_time; 
    public $ip; 
    public $user_agent;

    public $email;

    public function exchangeArray($data) 
    { 
        $this->login_log_id= (!empty($data['login_log_id'])) ? $data['login_log_id'] : 0; 
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0; 
        $this->login_time= (!empty($data['login_time'])) ? $data['login_time'] : 0; 
        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0; 
        $this->user_agent= (!empty($data['user_agent'])) ? $data['user_agent'] : 0;

        $this->email= (!empty($data['email'])) ? $data['email'] : 0;
    } 
} 
