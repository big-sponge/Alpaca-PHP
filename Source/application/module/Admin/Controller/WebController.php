<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class WebController
{    
    public function indexAction()
    {
        return View::html()->setData(['name'=>"Bob"]);
    }
}
