<?php 
namespace Model\Model;
class Entity
{ 
    const  TABLE_NAME = "tb_entity"; 

    public $entity_id; 
    public $entity_name; 
    public $entity_type; 
    public $id_type; 
    public $id_no; 
    public $register_time;
    public $entity_type_text;
    public $id_type_text;


    public function exchangeArray($data) 
    { 
        $this->entity_id= (!empty($data['entity_id'])) ? $data['entity_id'] : 0; 
        $this->entity_name= (!empty($data['entity_name'])) ? $data['entity_name'] : 0; 
        $this->entity_type= (!empty($data['entity_type'])) ? $data['entity_type'] : 0; 
        $this->id_type= (!empty($data['id_type'])) ? $data['id_type'] : 0; 
        $this->id_no= (!empty($data['id_no'])) ? $data['id_no'] : 0; 
        $this->register_time= (!empty($data['register_time'])) ? $data['register_time'] : 0;

        if($this->entity_type == 1){
            $this->entity_type_text ="个人";
        }else{
            $this->entity_type_text ="企业";
        }
        if($this->entity_type == 1){
            if($this->id_type == 1){
                $this->id_type_text ="身份证";
            }else if($this->id_type == 2){
                $this->entity_type_text ="企业";
            }
            else{
                return;
            }
        }else if($this->entity_type == 2){
            if($this->id_type == 1){
                $this->id_type_text ="营业执照";
            }else if($this->id_type == 2){
                $this->id_type_text ="组织机构代码证";
            }
            else{
                $this->id_type_text ="统一社会信用代码";
            }
        }

        $this->ip= (!empty($data['ip'])) ? $data['ip'] : 0;
        $this->port= (!empty($data['port'])) ? $data['port'] : 0;
        $this->url= (!empty($data['url'])) ? $data['url'] : 0;
    }



} 
