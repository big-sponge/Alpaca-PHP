<?php 
namespace Model\Model;
class GroupTrading
{ 
    const  TABLE_NAME = "tb_group_trading"; 

    public $group_trading_id; 
    public $group_serial_number; 
    public $virtual_serial_number; 
    public $payer_account_no; 
    public $payer_account_name; 
    public $payer_bank; 
    public $payer_bank_branch; 
    public $payer_cl_ring_no; 
    public $payee_account_no; 
    public $payee_account_name; 
    public $payee_bank; 
    public $payee_bank_branch; 
    public $payee_cl_ring_no; 
    public $trade_type; 
    public $trade_way; 
    public $trade_status;
    public $trade_status_text;
    public $trade_usage; 
    public $trade_start_time; 
    public $trade_end_time; 
    public $trade_amount; 
    public $freeze_period; 
    public $fee; 
    public $message; 

    public function exchangeArray($data) 
    { 
        $this->group_trading_id= (!empty($data['group_trading_id'])) ? $data['group_trading_id'] : 0; 
        $this->group_serial_number= (!empty($data['group_serial_number'])) ? $data['group_serial_number'] : 0; 
        $this->virtual_serial_number= (!empty($data['virtual_serial_number'])) ? $data['virtual_serial_number'] : 0; 
        $this->payer_account_no= (!empty($data['payer_account_no'])) ? $data['payer_account_no'] : 0; 
        $this->payer_account_name= (!empty($data['payer_account_name'])) ? $data['payer_account_name'] : 0; 
        $this->payer_bank= (!empty($data['payer_bank'])) ? $data['payer_bank'] : 0; 
        $this->payer_bank_branch= (!empty($data['payer_bank_branch'])) ? $data['payer_bank_branch'] : 0; 
        $this->payer_cl_ring_no= (!empty($data['payer_cl_ring_no'])) ? $data['payer_cl_ring_no'] : 0; 
        $this->payee_account_no= (!empty($data['payee_account_no'])) ? $data['payee_account_no'] : 0; 
        $this->payee_account_name= (!empty($data['payee_account_name'])) ? $data['payee_account_name'] : 0; 
        $this->payee_bank= (!empty($data['payee_bank'])) ? $data['payee_bank'] : 0; 
        $this->payee_bank_branch= (!empty($data['payee_bank_branch'])) ? $data['payee_bank_branch'] : 0; 
        $this->payee_cl_ring_no= (!empty($data['payee_cl_ring_no'])) ? $data['payee_cl_ring_no'] : 0; 
        $this->trade_type= (!empty($data['trade_type'])) ? $data['trade_type'] : 0; 
        $this->trade_way= (!empty($data['trade_way'])) ? $data['trade_way'] : 0; 
        $this->trade_status= (!empty($data['trade_status'])) ? $data['trade_status'] : 0; 
        $this->trade_usage= (!empty($data['trade_usage'])) ? $data['trade_usage'] : 0; 
        $this->trade_start_time= (!empty($data['trade_start_time'])) ? $data['trade_start_time'] : 0; 
        $this->trade_end_time= (!empty($data['trade_end_time'])) ? $data['trade_end_time'] : 0; 
        $this->trade_amount= (!empty($data['trade_amount'])) ? $data['trade_amount'] : 0; 
        $this->freeze_period= (!empty($data['freeze_period'])) ? $data['freeze_period'] : 0; 
        $this->fee= (!empty($data['fee'])) ? $data['fee'] : 0; 
        $this->message= (!empty($data['message'])) ? $data['message'] : 0; 
        

        if($this->trade_status == 1){
            $this->trade_status_text ="交易成功";
        }elseif($this->trade_status == 2){
            $this->trade_status_text ="交易失败";
        }elseif($this->trade_status == 3){
            $this->trade_status_text ="付款冻结中";
        }elseif($this->trade_status == 4){
            $this->trade_status_text ="交易初始化";
        }
    } 
} 
