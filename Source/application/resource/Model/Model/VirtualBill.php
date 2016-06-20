<?php 
namespace Model\Model;
class VirtualBill
{ 
    const  TABLE_NAME = "tb_virtual_bill"; 

    public $bill_id; 
    public $virtual_account_id; 
    public $virtual_serial_number; 
    public $trade_time; 
    public $trade_type; 
    public $amount; 
    public $account_balance; 
    public $opposite_account_type; 
    public $opposite_account_no; 
    public $opposite_account_name; 
    public $direction; 
    public $usage;

    public $entity_id;
    public $trade_time_date;
    public $trade_time_second;

    public function exchangeArray($data) 
    { 
        $this->bill_id= (!empty($data['bill_id'])) ? $data['bill_id'] : 0; 
        $this->virtual_account_id= (!empty($data['virtual_account_id'])) ? $data['virtual_account_id'] : 0; 
        $this->virtual_serial_number= (!empty($data['virtual_serial_number'])) ? $data['virtual_serial_number'] : 0; 
        $this->trade_time= (!empty($data['trade_time'])) ? $data['trade_time'] : 0; 
        $this->trade_type= (!empty($data['trade_type'])) ? $data['trade_type'] : 0; 
        $this->amount= (!empty($data['amount'])) ? $data['amount'] : 0; 
        $this->account_balance= (!empty($data['account_balance'])) ? $data['account_balance'] : 0; 
        $this->opposite_account_type= (!empty($data['opposite_account_type'])) ? $data['opposite_account_type'] : 0; 
        $this->opposite_account_no= (!empty($data['opposite_account_no'])) ? $data['opposite_account_no'] : 0; 
        $this->opposite_account_name= (!empty($data['opposite_account_name'])) ? $data['opposite_account_name'] : 0; 
        $this->direction= (!empty($data['direction'])) ? $data['direction'] : 0; 
        $this->usage= (!empty($data['usage'])) ? $data['usage'] : 0;

        $this->entity_id= (!empty($data['entity_id'])) ? $data['entity_id'] : 0;

        if(!empty($this->trade_time)){
            $arr = explode(" ", $this->trade_time);
            $i = 0;
            foreach($arr as $u){
                if($i == 0){
                    $this->trade_time_date = $u;
                }
                else{
                    $this->trade_time_second = $u;
                }
                $i++;
            }
        }
    } 
} 
