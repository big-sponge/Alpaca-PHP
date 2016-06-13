<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;

class IndexController
{           
    public function indexAction()
    {                  
        return (new ViewModel(['json'=>json_encode(['name'=>'Bob','age'=>'18'],JSON_UNESCAPED_UNICODE)]))->setType(ViewModel::VIEW_TYPE_JSON);
    }    
}
