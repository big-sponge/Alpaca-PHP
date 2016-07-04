<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class WebController
{    
    public function onDisplay($view)
    {       
        $view->setLayout(View::layout());
        $view->setPart(View::part('leftMenu','name2'),['menuId'=>2]);
        return $view;
    }

    public function indexAction()
    {
        return View::html();
    }
}

 