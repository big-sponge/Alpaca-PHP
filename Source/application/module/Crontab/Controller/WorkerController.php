<?php
namespace Crontab\Controller;

use Alpaca\MVC\View\View;
use Alpaca\Log\Log;

class WorkerController
{
    public function init()
    {
        ignore_user_abort(true); // 忽略客户端断开
        set_time_limit(0);       // 设置执行不超时
    }

    //index
    public function indexAction()
    {
        Log::add("Start Work ... Welcome Worker index A");
        sleep(5);
        Log::add("Start Work ... Welcome Worker index B");

        die('Welcome Worker index !');
        return View::json();
    }   
}

 