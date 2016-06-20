<?php 
namespace Model\Model;
class VirtualAccountAuthorize
{ 
    const  TABLE_NAME = "tb_virtual_account_authorize";

    public $virtual_account_authorize_id;
    public $virtual_account_id;
    public $virtual_account_authorize_create_time;
    public $virtual_account_authorize_end_time;
    public $virtual_account_auth_code;

    public $virtual_account_name;
    public $virtual_account_no;

    public $use_datetime;
    public $use_id;
    public $use_status;

    public function exchangeArray($data) 
    { 
        $this->virtual_account_authorize_id= (!empty($data['virtual_account_authorize_id'])) ? $data['virtual_account_authorize_id'] : 0;
        $this->virtual_account_id= (!empty($data['virtual_account_id'])) ? $data['virtual_account_id'] : 0;
        $this->virtual_account_authorize_create_time= (!empty($data['virtual_account_authorize_create_time'])) ? $data['virtual_account_authorize_create_time'] : 0;
        $this->virtual_account_authorize_end_time= (!empty($data['virtual_account_authorize_end_time'])) ? $data['virtual_account_authorize_end_time'] : 0;
        $this->virtual_account_auth_code= (!empty($data['virtual_account_auth_code'])) ? $data['virtual_account_auth_code'] : 0;

        $this->virtual_account_name= (!empty($data['virtual_account_name'])) ? $data['virtual_account_name'] : 0;
        $this->virtual_account_no= (!empty($data['virtual_account_no'])) ? $data['virtual_account_no'] : 0;


        $this->use_datetime= (!empty($data['use_datetime'])) ? $data['use_datetime'] : 0;
        $this->use_id= (!empty($data['use_id'])) ? $data['use_id'] : 0;
        $this->use_status= (!empty($data['use_status'])) ? $data['use_status'] : 0;
    }
} 
