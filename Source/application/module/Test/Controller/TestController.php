<?php
namespace Test\Controller;

use Alpaca\MVC\View\View;

class TestController
{
    public function indexAction()
    {
        return View::html();
    }
}

 