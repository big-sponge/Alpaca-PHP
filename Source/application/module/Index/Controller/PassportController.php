<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;
use Illuminate\Container\Container;  
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好 
use Model\User;
class PassportController
{   

    protected $reutrn_data = [];

    public function init(){
       
        
    }
    
 
    
    public function indexAction()
    {   
        

        

        return ViewModel::json($data);
    

    }    
}

 