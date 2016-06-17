<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;

class IndexController
{               
    public function indexAction()
    {        
        die('Welcome !');         
        return View::json();
    }    
}

 