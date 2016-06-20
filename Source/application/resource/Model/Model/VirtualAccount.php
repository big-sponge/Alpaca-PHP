<?php 
namespace Model\Model;
class VirtualAccount
{ 
    const  TABLE_NAME = "tb_virtual_account";

    public $virtual_account_id; 
    public $virtual_account_name; 
    public $virtual_account_no; 
    public $virtual_account_type; 
    public $group_account_id;
    public $total_balance; 
    public $available_balance; 
    public $freeze_amount; 
    public $id_type; 
    public $id_no; 
    public $id_file_path; 
    public $usage; 
    public $open_time; 
    public $close_time;
    public $active_time;
    public $status; 
    public $entity_id;

    public $virtual_account_type_text;
    public $status_text;
    public $group_account_no;
    public $group_account_name;
    public $relation_account_no;
    public $relation_account_name;
    public $balance;
    public $group_entity_id;
    
    
    
    public $bank_account_id;
    public $bank_account_no;
    public $bank_account_name;
    public $bank_account_type;
    public $bc_open_bank;
    public $bc_open_bank_branch;
    public $bc_cl_ring_no;
    public $bc_bind_time;
    
    
    public $ip;
    public $port;
    public $url;
    public $caymanURL;

    public $virtual_account_authorize_id;
    public $virtual_account_authorize_create_time;
    public $virtual_account_authorize_end_time;
    public $virtual_account_auth_code;
    
    
    public $open_bank;
    public $open_bank_branch;
    public $cl_ring_no;

    public $auth_status; 

    public function exchangeArray($data)
    { 
        $this->virtual_account_id= (!empty($data['virtual_account_id'])) ? $data['virtual_account_id'] : 0; 
        $this->virtual_account_name= (!empty($data['virtual_account_name'])) ? $data['virtual_account_name'] : 0; 
        $this->virtual_account_no= (!empty($data['virtual_account_no'])) ? $data['virtual_account_no'] : 0; 
        $this->virtual_account_type= (!empty($data['virtual_account_type'])) ? $data['virtual_account_type'] : 0; 
        $this->group_account_id= (!empty($data['group_account_id'])) ? $data['group_account_id'] : 0;
        $this->total_balance= (!empty($data['total_balance'])) ? $data['total_balance'] : 0; 
        $this->available_balance= (!empty($data['available_balance'])) ? $data['available_balance'] : 0; 
        $this->freeze_amount= (!empty($data['freeze_amount'])) ? $data['freeze_amount'] : 0; 
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0; 
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0; 
        $this->id_file_path= (!empty($data['id_file_path'])) ? $data['id_file_path'] : 0; 
        $this->usage= (!empty($data['usage'])) ? $data['usage'] : 0; 
        $this->open_time= (!empty($data['open_time'])) ? $data['open_time'] : 0; 
        $this->close_time= (!empty($data['close_time'])) ? $data['close_time'] : 0;
        $this->active_time= (!empty($data['active_time'])) ? $data['active_time'] : 0;
        $this->status= (!empty($data['status'])) ? $data['status'] : 0; 
        $this->entity_id= (!empty($data['entity_id'])) ? $data['entity_id'] : 0; 
        
        $this->group_account_no= (!empty($data['group_account_no'])) ? $data['group_account_no'] : 0;
        $this->group_account_name= (!empty($data['group_account_name'])) ? $data['group_account_name'] : 0;
        $this->relation_account_no= (!empty($data['relation_account_no'])) ? $data['relation_account_no'] : 0;
        $this->relation_account_name= (!empty($data['relation_account_name'])) ? $data['relation_account_name'] : 0;
        $this->bank_account_id= (!empty($data['bank_account_id'])) ? $data['bank_account_id'] : 0;
        $this->bank_account_no= (!empty($data['bank_account_no'])) ? $data['bank_account_no'] : 0;
        $this->bank_account_name= (!empty($data['bank_account_name'])) ? $data['bank_account_name'] : 0;
        $this->bank_account_type= (!empty($data['bank_account_type'])) ? $data['bank_account_type'] : 0;
        $this->bc_open_bank= (!empty($data['bc_open_bank'])) ? $data['bc_open_bank'] : 0;
        $this->bc_open_bank_branch= (!empty($data['bc_open_bank_branch'])) ? $data['bc_open_bank_branch'] : 0;
        $this->bc_cl_ring_no= (!empty($data['bc_cl_ring_no'])) ? $data['bc_cl_ring_no'] : 0;
        $this->bc_bind_time= (!empty($data['bc_bind_time'])) ? $data['bc_bind_time'] : 0;
        $this->balance= (!empty($data['balance'])) ? $data['balance'] : 0;
        $this->group_entity_id= (!empty($data['group_entity_id'])) ? $data['group_entity_id'] : 0;
 
        
        $this->open_bank= (!empty($data['open_bank'])) ? $data['open_bank'] : 0;
        $this->open_bank_branch= (!empty($data['open_bank_branch'])) ? $data['open_bank_branch'] : 0;
        $this->cl_ring_no= (!empty($data['cl_ring_no'])) ? $data['cl_ring_no'] : 0;
        
        $this->virtual_account_authorize_id= (!empty($data['virtual_account_authorize_id'])) ? $data['virtual_account_authorize_id'] : 0;
        $this->virtual_account_authorize_create_time= (!empty($data['virtual_account_authorize_create_time'])) ? $data['virtual_account_authorize_create_time'] : 0;
        $this->virtual_account_authorize_end_time= (!empty($data['virtual_account_authorize_end_time'])) ? $data['virtual_account_authorize_end_time'] : 0;
        $this->virtual_account_auth_code= (!empty($data['virtual_account_auth_code'])) ? $data['virtual_account_auth_code'] : 0;
        $this->auth_status= (!empty($data['auth_status'])) ? $data['auth_status'] : 0;
        



        if ($this->virtual_account_type == 1) {
            $this->virtual_account_type_text = "个人账户";
        } 
        elseif ($this->virtual_account_type == 2) {
            $this->virtual_account_type_text = "对公账户";
        } 
        elseif ($this->virtual_account_type == 3) {
            $this->virtual_account_type_text = "收益账户";
        } 
        else if ($this->virtual_account_type == 4) {
            $this->virtual_account_type_text = "冻结账户";
        }
        else if ($this->virtual_account_type == 5) {
            $this->virtual_account_type_text = "不明款项";
        } 
        else {
            $this->virtual_account_type_text = "未知类型";
        }

        
        if ($this->status == 1) {
            $this->status_text = "正常";
        } elseif ($this->status == 2) {
            $this->status_text = "冻结";
        } elseif ($this->status == 3) {
            $this->status_text = "销户";
        } else {
            $this->status_text = "未激活";
        }

        
        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0;
        $this->port= (!empty($data['port'])) ? $data['port'] : 0;
        $this->url= (!empty($data['url'])) ? $data['url'] : 0;
        
        $this->caymanURL = "http://".$this->ip.":".$this->port."/".$this->url."/";

    } 
} 
