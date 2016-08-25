<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;
use Redis\Redis;

class WebController
{        
    public function indexAction()
    {
        echo "sdfsd";
        die;
        return View::html()->setData(['name'=>"Bob"])->setFinal(true)->addChild(View::child('leftMenu','left'));
    }

    public function index2Action()
    {
        return View::html(['name'=>"Bob"]);
        
    }
    
    public function testAction()
    {
        echo "Stored string in redis:: " . Redis::redis()->get("tutorial-name");
    }
}
