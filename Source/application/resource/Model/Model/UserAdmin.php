<?php 
namespace Model\Model;
class UserAdmin
{ 
    const  TABLE_NAME = "tb_user_admin";

    public $admin_id;
    public $admin_email;
    public $admin_name;
    public $login_password;
    public $role;
    public $registration_time;
    public $last_login_time;

    public function exchangeArray($data) 
    {
        $this->admin_id= (!empty($data['admin_id'])) ? $data['admin_id'] : 0;
        $this->admin_email= (!empty($data['admin_email'])) ? $data['admin_email'] : 0;
        $this->admin_name= (!empty($data['admin_name'])) ? $data['admin_name'] : 0;
        $this->login_password= (!empty($data['login_password'])) ? $data['login_password'] : 0;
        $this->role= (!empty($data['role'])) ? $data['role'] : 0;
        $this->registration_time= (!empty($data['registration_time'])) ? $data['registration_time'] : 0;
        $this->last_login_time= (!empty($data['last_login_time'])) ? $data['last_login_time'] : 0;
    }
} 
