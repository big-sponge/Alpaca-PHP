<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;

class IndexController
{           
    public function init(){
       
        return $this->app->router->forward('/index2');
    }
    
    public function indexAction()
    {
         
        $data = ['name'=>'Bob2','age'=>'18'];
             
        return ViewModel::json($data);
    }
    
    public function index2Action()
    {   
               
        $data = ['name'=>'Big Bob','age'=>'18'];
               
        return ViewModel::json($data);
    }    
}
