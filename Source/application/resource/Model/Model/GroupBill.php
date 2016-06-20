<?php 
namespace Model\Model;
class GroupBill
{ 
    const  TABLE_NAME = "tb_group_bill"; 

    public $bill_id; 
    public $group_account_id; 
    public $group_serial_number; 
    public $trade_time; 
    public $trade_type; 
    public $amount; 
    public $account_balance; 
    public $opposite_account_no; 
    public $opposite_account_name; 
    public $direction; 
    public $usage; 

    public function exchangeArray($data) 
    { 
        $this->bill_id= (!empty($data['bill_id'])) ? $data['bill_id'] : 0; 
        $this->group_account_id= (!empty($data['group_account_id'])) ? $data['group_account_id'] : 0; 
        $this->group_serial_number= (!empty($data['group_serial_number'])) ? $data['group_serial_number'] : 0; 
        $this->trade_time= (!empty($data['trade_time'])) ? $data['trade_time'] : 0; 
        $this->trade_type= (!empty($data['trade_type'])) ? $data['trade_type'] : 0; 
        $this->amount= (!empty($data['amount'])) ? $data['amount'] : 0; 
        $this->account_balance= (!empty($data['account_balance'])) ? $data['account_balance'] : 0; 
        $this->opposite_account_no= (!empty($data['opposite_account_no'])) ? $data['opposite_account_no'] : 0; 
        $this->opposite_account_name= (!empty($data['opposite_account_name'])) ? $data['opposite_account_name'] : 0; 
        $this->direction= (!empty($data['direction'])) ? $data['direction'] : 0; 
        $this->usage= (!empty($data['usage'])) ? $data['usage'] : 0; 
    } 
} 
