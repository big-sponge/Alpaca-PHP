<?php
namespace Alpaca\MVC\Controller;


class AlpacaController
{          
    public function indexAction()
    {
        echo ("This is index action!");
    }
    
    public function actionNotFoundAction()
    {
        echo ("The action is not found  : {} !");
    }
    
    public function controllerNotFoundAction()
    {
        echo ("The controller is not found  : {} !");
    }
    
    public function moduleNotFoundAction()
    {
        echo ("The module is not found  : {} !");
    }
}
