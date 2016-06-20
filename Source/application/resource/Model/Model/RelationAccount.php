<?php 
namespace Model\Model;
class RelationAccount 
{ 
    const  TABLE_NAME = "tb_relation_account"; 

    public $relation_account_id; 
    public $relation_account_name;
    public $relation_account_no; 
    public $balance; 
    public $status; 
    public $id_type; 
    public $id_no; 
    public $id_file_path; 

    public function exchangeArray($data) 
    { 
        $this->relation_account_id= (!empty($data['relation_account_id'])) ? $data['relation_account_id'] : 0; 
        $this->relation_account_name= (!empty($data['relation _account_name'])) ? $data['relation _account_name'] : 0;
        $this->relation_account_no= (!empty($data['relation_account_no'])) ? $data['relation_account_no'] : 0; 
        $this->balance= (!empty($data['balance'])) ? $data['balance'] : 0; 
        $this->status= (!empty($data['status'])) ? $data['status'] : 0; 
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0; 
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0; 
        $this->id_file_path= (!empty($data['id_file_path'])) ? $data['id_file_path'] : 0; 
    } 
} 
