<?php
namespace Admin;
use Alpaca\MVC\View\View;
use Alpaca\MVC\Router\Router;

class Module
{
    public function onInit()
    {
        Router::router()->ControllerClass->request_data = 'asdasd';
    }
    
    public function onDisplay($view)
    {
        $view->setLayout(View::layout());
        $menuId =lcfirst(Router::router()->Controller).'-'.Router::router()->Action;
        $view->setPart(View::part('leftMenu')->setData(['menuId'=>$menuId]));
        return $view;
    }
}
