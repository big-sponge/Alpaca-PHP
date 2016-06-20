<?php 
namespace Model\Model;
class PayOrder
{ 
    const  TABLE_NAME = "tb_pay_Order"; 
 
    public $id; 
    public $back_url; 
    public $mer_id; 
    public $user_order_no; 
    public $txn_time; 
    public $txn_amt;
    public $alpaca_order_no;
    public $version;
    public $cert_id;
    public $encoding; 
    public $channel_type; 
    public $state; 
    public $user_name; 
    public $user_id;
    public $virtual_serial_number;
    public $request_uri;
 
    public function exchangeArray($data) 
    { 
        $this->id= (!empty($data['id'])) ? $data['id'] : 0; 
        $this->back_url= (!empty($data['back_url'])) ? $data['back_url'] : 0; 
        $this->mer_id= (!empty($data['mer_id'])) ? $data['mer_id'] : 0; 
        $this->user_order_no= (!empty($data['user_order_no'])) ? $data['user_order_no'] : 0; 
        $this->alpaca_order_no= (!empty($data['alpaca_order_no'])) ? $data['alpaca_order_no'] : 0; 
        $this->txn_time= (!empty($data['txn_time'])) ? $data['txn_time'] : 0; 
        $this->txn_amt= (!empty($data['txn_amt'])) ? $data['txn_amt'] : 0;
        $this->version= (!empty($data['version'])) ? $data['version'] : 0;
        $this->encoding= (!empty($data['encoding'])) ? $data['encoding'] : 0; 
        $this->cert_id= (!empty($data['cert_id'])) ? $data['cert_id'] : 0; 
        $this->channel_type= (!empty($data['channel_type'])) ? $data['channel_type'] : 0; 
        $this->state= (!empty($data['state'])) ? $data['state'] : 0; 
        $this->user_name= (!empty($data['user_name'])) ? $data['user_name'] : 0; 
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0;
        $this->request_uri= (!empty($data['request_uri'])) ? $data['request_uri'] : 0;
        $this->virtual_serial_number= (!empty($data['virtual_serial_number'])) ? $data['virtual_serial_number'] : 0;
    } 
} 
