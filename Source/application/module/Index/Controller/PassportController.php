<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;
 
class PassportController
{   

    protected $return_data = [];
    
    protected $request_data = [];

    public function init()
    {
        $this->dataFilter();
    }
   
    //处理POST数据
    private function dataFilter()
    {        
        if(empty($_POST)){ return;}
        foreach ($_POST as $name => $value){
            $this->request_data[$name] = addslashes(htmlspecialchars(trim($value)));
        }
    }
     
    public function indexAction()
    {       
        $form = $this->sm->form('Index\Form\PassportForm');
        $data = $form->createJwt($this->params);
        return View::json($data);
    }

    public function checkAction()
    {        
        //获取token
        $token = $_GET['token'];
        
        $form = $this->sm->form('Index\Form\PassportForm');
        $data = $form->parserJwt($token);
        
        return View::json($data);
    }
    public function bindAccountAction()
    {
        return View::html(array('keys'=>'asdasdd'));
    }
    
    public function postbindAccountAction()
    {   
        $form = $this->sm->form('Index\Form\PassportForm');
        $data = $form->bindAccount($this->request_data);
        return View::json($data);
    }
  
}

 