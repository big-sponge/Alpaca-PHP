<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class WebController
{
    public function onDisplay($view){
        $view->setLayout(View::getDefaultLayout());
        return $view;
    }

    public function indexAction()
    {
        return View::html()->setUseLayout(true);
    }
}

 