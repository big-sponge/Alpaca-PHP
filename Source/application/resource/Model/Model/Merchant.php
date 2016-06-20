<?php 
namespace Model\Model;
use Model\Common\Constant;
use Model\Common\ResultMsg;

class Merchant
{ 
    const TABLE_NAME = "tb_merchant";

    public $merchant_id;
    public $virtual_account_no;
    public $merchant_name;
    public $merchant_addr;
    public $merchant_phone;
    public $merchant_email;
    public $merchant_type;
    public $merchant_id_type;
    public $merchant_id_no;
    public $merchant_create_time;
    public $merchant_state;
    public $user_id;
    public $virtual_account_id;

    public $merchant_type_text;
    public $merchant_id_type_text;
    public $merchant_state_text;

    public $user_email;

    public function exchangeArray($data) 
    { 
        $this->merchant_id= (!empty($data['merchant_id'])) ? $data['merchant_id'] : 0;
        $this->virtual_account_no= (!empty($data['virtual_account_no'])) ? $data['virtual_account_no'] : 0;
        $this->merchant_name= (!empty($data['merchant_name'])) ? $data['merchant_name'] : 0;
        $this->merchant_addr= (!empty($data['merchant_addr'])) ? $data['merchant_addr'] : 0;
        $this->merchant_phone= (!empty($data['merchant_phone'])) ? $data['merchant_phone'] : 0;
        $this->merchant_email= (!empty($data['merchant_email'])) ? $data['merchant_email'] : 0;
        $this->merchant_type= (!empty($data['merchant_type'])) ? $data['merchant_type'] : 0;
        $this->merchant_id_type= (!empty($data['merchant_id_type'])) ? $data['merchant_id_type'] : 0;
        $this->merchant_id_no= (!empty($data['merchant_id_no'])) ? $data['merchant_id_no'] : 0;
        $this->merchant_create_time= (!empty($data['merchant_create_time'])) ? $data['merchant_create_time'] : 0;
        $this->merchant_state= (!empty($data['merchant_state'])) ? $data['merchant_state'] : 0;
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0;
        $this->virtual_account_id= (!empty($data['virtual_account_id'])) ? $data['virtual_account_id'] : 0;

        $this->user_email= (!empty($data['user_email'])) ? $data['user_email'] : 0;

        if($this->merchant_type == Constant::MERCHANT_TYPE_PERSONAL){
            $this->merchant_type_text = ResultMsg::getMsg("personal");
        }
        elseif($this->merchant_type == Constant::MERCHANT_TYPE_COMPANY){
            $this->merchant_type_text = ResultMsg::getMsg("company");
        }

        if($this->merchant_id_type == Constant::MERCHANT_ID_TYPE_ID){
            $this->merchant_id_type_text = ResultMsg::getMsg("id");
        }
        elseif($this->merchant_id_type == Constant::MERCHANT_ID_TYPE_BUSINESS_LICENCE){
            $this->merchant_id_type_text = ResultMsg::getMsg("business_licence");
        }

        if($this->merchant_state == Constant::MERCHANT_STATUS_OPEN){
            $this->merchant_state_text = ResultMsg::getMsg("user_normal");
        }
        elseif($this->merchant_state == Constant::MERCHANT_STATUS_FORBIDDEN){
            $this->merchant_state_text = ResultMsg::getMsg("user_forbid");
        }
        elseif($this->merchant_state == Constant::MERCHANT_STATUS_CLOSE){
            $this->merchant_state_text = ResultMsg::getMsg("user_close");
        }
    }
} 
