<?php
namespace Admin;
use Alpaca\MVC\View\View;
use Alpaca\MVC\Router\Router;

class Module
{
    public function onInit()
    {
        Router::router()->ControllerClass->testdata = 'asdasd';
    }
    
    public function onDisplay($view)
    {
        $view->setLayout(View::layout());
        $view->setPart(View::part('leftMenu')->setData(['menuId'=>1]));
        return $view;
    }
}
