<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;
use Alpaca\Log\Log;

class IndexController
{
    public function indexAction()
    {
        return View::html();
    }
    
    public function testAction()
    { 
        Log::add("sdfsdf == ");
    }
}

 