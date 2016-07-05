<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class WebController
{    
    public function onDisplay($view)
    {
        $view->setUseLayout(true);
        $view->setPart(View::part('leftMenu'));
        return $view;
    }

    public function indexAction()
    {
        return View::html()->setPartData('leftMenu',['menuId'=>1]);
    }
}

 