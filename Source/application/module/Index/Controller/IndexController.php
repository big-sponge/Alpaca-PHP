<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;

class IndexController
{           
    public function indexAction()
    {      
        $data = ['name'=>'Bob中文','age'=>'18'];
       
        $data2 = json_encode(['name'=>'Bob中文','age'=>'18'],JSON_UNESCAPED_UNICODE);
        
        return ViewModel::html($data);
    }    
}
