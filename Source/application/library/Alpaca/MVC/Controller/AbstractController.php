<?php
namespace Alpaca\MVC\Controller;

use Alpaca\MVC\View\ViewModel;
use Alpaca\MVC\View\View;
use Alpaca\Factory\Factory;

class AbstractController extends \Yaf_Controller_Abstract 
{    
    protected $layout = null;   
    protected $sm = null;

    protected function init()
    {        
        \Yaf_Dispatcher::getInstance()->disableView();
        $this->layout = new ViewModel();
        $template=  APP_PATH."/application/modules/{$this->getRequest()->getModuleName()}/views/layout/layout.phtml";
        $this->layout->setTemplate($template);
        
        $this->initData();
        
        $this->initLayout();
        
        $this->initAction();
    }    
        
    protected function initData()
    {
    
    }
    
    protected function initLayout()
    {   

    }
    
    protected function initAction()
    {
    
    }
    
   
    protected function view($variables = null){
        $view = new View($variables);
        $template=  APP_PATH."/application/modules/{$this->getRequest()->getModuleName()}/views/{$this->getRequest()->getControllerName()}/{$this->getRequest()->getActionName()}.phtml";
        $view->setTemplate($template);       
        $view->setLayout($this->layout);        
        return $view;
    }
}
