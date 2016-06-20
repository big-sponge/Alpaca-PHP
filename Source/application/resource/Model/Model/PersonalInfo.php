<?php 
namespace Model\Model;
class PersonalInfo
{ 
    const  TABLE_NAME = "tb_personal_info"; 

    public $personal_info_id; 
    public $name; 
    public $mobile_no; 
    public $id_type; 
    public $id_no; 
    public $checking_status; 
    public $checking_time; 

    public function exchangeArray($data) 
    { 
        $this->personal_info_id= (!empty($data['personal_info_id'])) ? $data['personal_info_id'] : 0; 
        $this->name= (!empty($data['name'])) ? $data['name'] : 0; 
        $this->mobile_no= (!empty($data['mobile_no'])) ? $data['mobile_no'] : 0; 
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0; 
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0; 
        $this->checking_status= (!empty($data['checking_status'])) ? $data['checking_status'] : 0; 
        $this->checking_time= (!empty($data['checking_time'])) ? $data['checking_time'] : 0; 
    } 
} 
