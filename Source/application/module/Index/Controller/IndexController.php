<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;
use Illuminate\Container\Container;  
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好 
use Alpaca\Tools\Validate;
use Index\Form\PassportForm;
use Alpaca\Factory\ServerManager;

class IndexController
{               
    public function indexAction()
    {        
        die('Welcome !');         
        return ViewModel::json($data);
    }
    
    public function index2Action()
    {         
        $results = Capsule::select('select * from users where id = ?', array(1));        
        var_dump($results);
        die();
        // var_dump( $this->params);
        // $data = ['name'=>'Big Bob','age'=>'18'];           
        return ViewModel::json($data);
    }    
}

 