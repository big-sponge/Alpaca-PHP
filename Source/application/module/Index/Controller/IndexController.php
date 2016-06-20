<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;

class IndexController
{
    public function indexAction()
    {
        $form = $this->sm->form('Index\Form\PassportForm');
        $form->test();
        die('Welcome !');
        return View::json();
    }
}

 