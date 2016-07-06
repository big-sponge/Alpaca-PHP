<?php
namespace Admin\Controller;

use Alpaca\MVC\View\View;

class CrontabController
{
    public function indexAction()
    {
        return View::html()->setPartData("leftMenu", ['menuId'=>2]);
    }
}

 