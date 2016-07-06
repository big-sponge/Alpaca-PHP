<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class WebController
{    
    public function onDisplay($view)
    {
        $view->setLayout(View::layout('layout'));
        $view->setPart(View::part('leftMenu')->setData(['menuId'=>3]));
        return $view;
    }

    public function indexAction()
    {
        return View::html()->setPartData('leftMenu',['menuId'=>2]);
    }
}

 