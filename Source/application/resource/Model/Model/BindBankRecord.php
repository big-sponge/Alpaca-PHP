<?php 
namespace Model\Model;
class BindBankRecord
{ 
    const  TABLE_NAME = "tb_bind_bank_record"; 

    public $bind_bank_record_id; 
    public $virtual_account_no; 
    public $bank_account_no; 
    public $bank_account_name; 
    public $open_bank; 
    public $open_bank_branch; 
    public $cl_ring_no; 
    public $bind_time; 

    public function exchangeArray($data) 
    { 
        $this->bind_bank_record_id= (!empty($data['bind_bank_record_id'])) ? $data['bind_bank_record_id'] : 0; 
        $this->virtual_account_no= (!empty($data['virtual_account_no'])) ? $data['virtual_account_no'] : 0; 
        $this->bank_account_no= (!empty($data['bank_account_no'])) ? $data['bank_account_no'] : 0; 
        $this->bank_account_name= (!empty($data['bank_account_name'])) ? $data['bank_account_name'] : 0;
        $this->bank_account_type= (!empty($data['bank_account_type'])) ? $data['bank_account_type'] : 0;
        $this->open_bank= (!empty($data['open_bank'])) ? $data['open_bank'] : 0; 
        $this->open_bank_branch= (!empty($data['open_bank_branch'])) ? $data['open_bank_branch'] : 0; 
        $this->cl_ring_no= (!empty($data['cl_ring_no'])) ? $data['cl_ring_no'] : 0; 
        $this->bind_time= (!empty($data['bind_time'])) ? $data['bind_time'] : 0;
        $this->unbind_time= (!empty($data['unbind_time'])) ? $data['unbind_time'] : 0;
    } 
} 
