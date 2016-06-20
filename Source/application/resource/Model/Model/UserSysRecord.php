<?php 
namespace Model\Model;
class UserSysRecord
{ 
    const  TABLE_NAME = "tb_user_sys_record";

    public $user_sys_record_id;
    public $user_id;
    public $user_sys_title;
    public $user_sys_content;
    public $user_sys_time;

    public function exchangeArray($data) 
    { 
        $this->user_sys_record_id= (!empty($data['user_sys_record_id'])) ? $data['user_sys_record_id'] : 0;
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0;
        $this->user_sys_title= (!empty($data['user_sys_title'])) ? $data['user_sys_title'] : 0;
        $this->user_sys_content= (!empty($data['user_sys_content'])) ? $data['user_sys_content'] : 0;
        $this->user_sys_time= (!empty($data['user_sys_time'])) ? $data['user_sys_time'] : 0;
    } 
} 
