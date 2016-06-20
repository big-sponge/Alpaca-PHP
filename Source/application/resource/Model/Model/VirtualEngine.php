<?php 
namespace Model\Model;
class VirtualEngine
{ 
    const  TABLE_NAME = "tb_virtual_engine"; 

    public $virtual_engine_id; 
    public $project_name;
    public $group_account_id; 
    public $ip; 
    public $port; 
    public $url;
    public $ip_address;
    public $status;


    public $group_account_name;
    public $group_account_no;
    public $open_bank;
    public $open_bank_branch;

    public $status_text;

    public function exchangeArray($data) 
    { 
        $this->virtual_engine_id= (!empty($data['virtual_engine_id'])) ? $data['virtual_engine_id'] : 0; 
        $this->project_name= (!empty($data['project_name'])) ? $data['project_name'] : 0;
        $this->group_account_id= (!empty($data['group_account_id'])) ? $data['group_account_id'] : 0; 
        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0; 
        $this->port= (!empty($data['port'])) ? $data['port'] : 0; 
        $this->url= (!empty($data['url'])) ? $data['url'] : 0;
        $this->ip_address= (!empty($data['ip_address'])) ? $data['ip_address'] : 0;
        $this->status= (!empty($data['status'])) ? $data['status'] : 0;


        $this->group_account_name= (!empty($data['group_account_name'])) ? $data['group_account_name'] : 0;
        $this->group_account_no= (!empty($data['group_account_no'])) ? $data['group_account_no'] : 0;
        $this->open_bank= (!empty($data['open_bank'])) ? $data['open_bank'] : 0;
        $this->open_bank_branch= (!empty($data['open_bank_branch'])) ? $data['open_bank_branch'] : 0;

        if($this->status==1){
            $this->status_text="使用中";
        }else if($this->status==9){
            $this->status_text="已删除";
        }else{
            $this->status_text="未使用";
        }
    } 
} 
