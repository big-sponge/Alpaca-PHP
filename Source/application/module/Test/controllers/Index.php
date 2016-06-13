<?php

use Alpaca\MVC\Controller\AbstractController;
use Alpaca\Factory\Factory;

class IndexController extends AbstractController
{    
    public function indexAction()
    {                  
        $adapter = (Factory::get('Zend\Db\Adapter\Adapter'));
         
        $data = $adapter->query("select * from tb_user",'execute');
         
        $arrrayData =array();
        foreach ($data as $d)
        {
            array_push($arrrayData, $d);
        }                                
        return $this->view()->displayToJson(json_encode($arrrayData,JSON_UNESCAPED_UNICODE));
    }
    
    public function testDotjsAction(){
        return $this->view()->display();
    }
}
