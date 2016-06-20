<?php 
namespace Model\Model;
class GroupAccount
{ 
    const  TABLE_NAME = "tb_group_account"; 

    public $group_account_id; 
    public $group_account_name; 
    public $group_account_no; 
    public $balance; 
    public $status; 
    public $open_bank; 
    public $open_bank_branch; 
    public $cl_ring_no; 
    public $id_type; 
    public $id_no; 
    public $id_file_path; 
    public $relation_account_id; 
    public $entity_id; 
    public $status_text;

    public $entity_type;
    public $entity_type_text;
    public $entity_name;
    public $entity_id_type;
    public $entity_id_no;
    public $register_time;
    public $entity_id_type_text;
    
    public $relation_account_no; 
    public $relation_account_name;
    public $relation_status;

    public $ip;
    public $port;
    public $url;
    
    public $caymanURL;
    
       
    public function exchangeArray($data) 
    { 
        $this->group_account_id= (!empty($data['group_account_id'])) ? $data['group_account_id'] : 0; 
        $this->group_account_name= (!empty($data['group_account_name'])) ? $data['group_account_name'] : 0; 
        $this->group_account_no= (!empty($data['group_account_no'])) ? $data['group_account_no'] : 0; 
        $this->balance= (!empty($data['balance'])) ? $data['balance'] : 0; 
        $this->status= (!empty($data['status'])) ? $data['status'] : 0; 
        $this->open_bank= (!empty($data['open_bank'])) ? $data['open_bank'] : 0; 
        $this->open_bank_branch= (!empty($data['open_bank_branch'])) ? $data['open_bank_branch'] : 0; 
        $this->cl_ring_no= (!empty($data['cl_ring_no'])) ? $data['cl_ring_no'] : 0; 
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0; 
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0; 
        $this->id_file_path= (!empty($data['id_file_path'])) ? $data['id_file_path'] : 0; 
        $this->relation_account_id= (!empty($data['relation_account_id'])) ? $data['relation_account_id'] : 0; 
        $this->entity_id= (!empty($data['entity_id'])) ? $data['entity_id'] : 0;

        $this->entity_type= (!empty($data['entity_type'])) ? $data['entity_type'] : 0;
        $this->entity_name= (!empty($data['entity_name'])) ? $data['entity_name'] : 0;
        $this->entity_id_type= (!empty($data['entity_id_type'])) ? $data['entity_id_type'] : 0;
        $this->entity_id_no= (!empty($data['entity_id_no'])) ? $data['entity_id_no'] : 0;
        $this->register_time= (!empty($data['register_time'])) ? $data['register_time'] : 0;

        if($this->status==1){$this->status_text="正常";}elseif($this->status==2){$this->status_text="冻结";}else{$this->status_text="销户";}
        if($this->entity_type==1){$this->entity_type_text="个人";}else{$this->entity_type_text="企业";}
        if($this->entity_type == 1){
            if($this->id_type == 1){
                $this->entity_id_type_text ="身份证";
            }else if($this->entity_id_type == 2){
                $this->entity_id_type_text ="企业";
            }
            else{
                return;
            }
        }else if($this->entity_type == 2){
            if($this->entity_id_type == 1){
                $this->entity_id_type_text ="营业执照";
            }else if($this->entity_id_type == 2){
                $this->entity_id_type_text ="组织机构代码证";
            }
            else{
                $this->entity_id_type_text ="统一社会信用代码";
            }
        }

        $this->relation_account_no= (!empty($data['relation_account_no'])) ? $data['relation_account_no'] : 0;
        $this->relation_account_name= (!empty($data['relation_account_name'])) ? $data['relation_account_name'] : 0;
        $this->relation_status= (!empty($data['relation_status'])) ? $data['relation_status'] : 0;

        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0;
        $this->port= (!empty($data['port'])) ? $data['port'] : 0;
        $this->url= (!empty($data['url'])) ? $data['url'] : 0;    
        
        $this->caymanURL = "http://".$this->ip.":".$this->port."/".$this->url."/";
    } 
} 
