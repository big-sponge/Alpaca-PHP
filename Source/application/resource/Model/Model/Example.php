<?php
namespace Model\Model;

class Example
{
    const  TABLE_NAME = "TB_EXAMPLE";
       
    public $EXAMPLE_ID;
    public $USER_NAME;
    public $PASSWORD;
       
    public function exchangeArray($data)
    {
        $this->EXAMPLE_ID= (!empty($data['EXAMPLE_ID'])) ? $data['EXAMPLE_ID'] : 0;
        $this->USER_NAME= (!empty($data['USER_NAME'])) ? $data['USER_NAME'] : 0;
        $this->PASSWORD= (!empty($data['PASSWORD'])) ? $data['PASSWORD'] : 0;        
    }       
}