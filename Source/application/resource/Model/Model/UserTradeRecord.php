<?php 
namespace Model\Model;
class UserTradeRecord
{ 
    const  TABLE_NAME = "tb_user_trade_record";

    public $user_trade_record_id;
    public $user_id;
    public $user_trade_content;
    public $user_trade_date;
    public $user_trade_time;

    public function exchangeArray($data) 
    { 
        $this->user_trade_record_id= (!empty($data['user_trade_record_id'])) ? $data['user_trade_record_id'] : 0;
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0;
        $this->user_trade_content= (!empty($data['user_trade_content'])) ? $data['user_trade_content'] : 0;
        $this->user_trade_date= (!empty($data['user_trade_date'])) ? $data['user_trade_date'] : 0;
        $this->user_trade_time= (!empty($data['user_trade_time'])) ? $data['user_trade_time'] : 0;
    }
} 
