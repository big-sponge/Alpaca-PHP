<?php 
namespace Model\Model;
class SystemParameter 
{ 
    const  TABLE_NAME = "tb_system_parameter"; 

    public $id; 
    public $key; 
    public $value; 
    public $name; 

    public function exchangeArray($data) 
    { 
        $this->id= (!empty($data['id'])) ? $data['id'] : 0; 
        $this->key= (!empty($data['key'])) ? $data['key'] : 0; 
        $this->value= (!empty($data['value'])) ? $data['value'] : 0; 
        $this->name= (!empty($data['name'])) ? $data['name'] : 0; 
    } 
} 
