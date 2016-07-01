<?php
namespace Alpaca\MVC\Controller;


class AlpacaController
{          
    public function indexAction()
    {
        echo ("This is index action!");
    }
    
    public function actionNotFoundAction($name =null)
    {
        echo ("The action is not found  : {$name} !");
    }
    
    public function controllerNotFoundAction($name =null)
    {
        echo ("The controller is not found  : {$name} !");
    }
    
    public function moduleNotFoundAction($name =null)
    {
        echo ("The module is not found  : {$name} !");
    }
}
