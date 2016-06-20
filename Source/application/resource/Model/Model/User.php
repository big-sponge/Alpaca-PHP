<?php 
namespace Model\Model;
use Model\Common\Constant;
use Model\Common\ResultMsg;

class User
{ 
    const  TABLE_NAME = "tb_user"; 

    public $user_id; 
    public $email; 
    public $login_password; 
    public $pay_password; 
    public $type; 
    public $role; 
    public $authority; 
    public $registration_date; 
    public $registration_source; 
    public $status; 
    public $personal_info_id; 
    public $entity_id;

    public $entity_name;
    public $entity_type;
    public $id_type;
    public $id_no;

    public $name;
    public $mobile_no;
    public $user_id_type;
    public $user_id_no;
    public $checking_status;
    public $checking_time;

    public $entity_type_text;
    public $id_type_text;
    public $user_id_type_text;
    public $checking_status_text;
    public $user_type_text;
    public $status_text;

    public function exchangeArray($data) 
    { 
        $this->user_id= (!empty($data['user_id'])) ? $data['user_id'] : 0; 
        $this->email= (!empty($data['email'])) ? $data['email'] : 0; 
        $this->login_password= (!empty($data['login_password'])) ? $data['login_password'] : 0; 
        $this->pay_password= (!empty($data['pay_password'])) ? $data['pay_password'] : 0; 
        $this->type= (!empty($data['type'])) ? $data['type'] : 0; 
        $this->role= (!empty($data['role'])) ? $data['role'] : 0; 
        $this->authority= (!empty($data['authority'])) ? $data['authority'] : 0; 
        $this->registration_date= (!empty($data['registration_date'])) ? $data['registration_date'] : 0; 
        $this->registration_source= (!empty($data['registration_source'])) ? $data['registration_source'] : 0; 
        $this->status= (!empty($data['status'])) ? $data['status'] : 0; 
        $this->personal_info_id= (!empty($data['personal_info_id'])) ? $data['personal_info_id'] : 0; 
        $this->entity_id= (!empty($data['entity_id'])) ? $data['entity_id'] : 0;
        $this->entity_name= (!empty($data['entity_name'])) ? $data['entity_name'] : 0;
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0;
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0;
        $this->entity_type= (!empty($data['entity_type'])) ? $data['entity_type'] : 0;

        $this->name= (!empty($data['name'])) ? $data['name'] : 0;
        $this->mobile_no= (!empty($data['mobile_no'])) ? $data['mobile_no'] : 0;
        $this->user_id_type= (!empty($data['user_id_type'])) ? $data['user_id_type'] : 0;
        $this->user_id_no= (!empty($data['user_id_no'])) ? $data['user_id_no'] : 0;
        $this->checking_status= (!empty($data['checking_status'])) ? $data['checking_status'] : 0;
        $this->checking_time= (!empty($data['checking_time'])) ? $data['checking_time'] : 0;

        if($this->id_type == 1){
            $this->id_type_text ="商业营业执照";
        }elseif($this->id_type == 2){
            $this->id_type_text ="其他";
        }

        if($this->entity_type == 1){
            $this->entity_type_text ="个人";
        }elseif($this->entity_type == 2){
            $this->entity_type_text ="企业";
        }

        if($this->entity_type == Constant::USER_TYPE_PERSONAL){
            if($this->id_type == Constant::USER_ID_TYPE_ID){
                $this->user_id_type_text = ResultMsg::getMsg("id");
            }
            else{
                $this->user_id_type_text = ResultMsg::getMsg("passport");
            }
        }
        else{
            if($this->id_type == Constant::ENTITY_ID_TYPE_BUSINESS_LICENCE){
                $this->user_id_type_text = ResultMsg::getMsg("entity_id_type_business_licence");
            }
            elseif($this->id_type == Constant::ENTITY_ID_TYPE_ORGANIZATION_CODE){
                $this->user_id_type_text = ResultMsg::getMsg("entity_id_type_organization_code");
            }
            else{
                $this->user_id_type_text = ResultMsg::getMsg("entity_id_type_credit_code");
            }
        }

        if($this->checking_status == 1){
            $this->checking_status_text = ResultMsg::getMsg("user_check_status_checked");
        }
        else{
            $this->checking_status_text = ResultMsg::getMsg("user_check_status_unchecked");
        }


        // if($this->type == Constant::USER_TYPE_PERSONAL){
        //     $this->user_type_text = ResultMsg::getMsg("personal");
        // }
        // else{
        //     $this->user_type_text = ResultMsg::getMsg("company");
        // }

        if($this->type == Constant::ACCOUNT_TYPE_GROUP){
            $this->user_type_text = ResultMsg::getMsg("account_type_group");
        }
        if($this->type == Constant::ACCOUNT_TYPE_VIRTUAL){
            $this->user_type_text = ResultMsg::getMsg("account_type_virtual");
        }
        if($this->type == Constant::ACCOUNT_TYPE_GROUP_VIRTUAL){
            $this->user_type_text = ResultMsg::getMsg("account_type_group_virtual");
        }


        if($this->status == Constant::USER_STATUS_OPEN){
            $this->status_text = ResultMsg::getMsg("user_normal");
        }
        elseif($this->status == Constant::USER_STATUS_FORBIDDEN){
            $this->status_text = ResultMsg::getMsg("user_forbid");
        }
        else{
            $this->status_text = ResultMsg::getMsg("user_close");
        }
    }
} 
