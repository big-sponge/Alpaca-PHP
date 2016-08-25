<?php
namespace Test\Controller;

use Alpaca\MVC\View\View;

class TestController
{
    public function indexAction()
    {
        return View::html();
    }
    
    
    public function testAction()
    {
        echo "ddd";
        $fp = fsockopen("101.201.28.96", "7070", $errno, $errstr, "10");
        if (!$fp) {
            return false;
        } else {
            
            
            $post_data="A0010101010100108000000zzzz0000000000053S001  123450120160816152859YQTEST20160816152859                                                                                                          000001            00000000000";
            /*$post_data +='<?xml version="1.0" encoding="GBK"?><Result></Result>'; */
            
            
            $out = iconv('UTF-8', 'GB2312', $post_data);
            fwrite($fp, $out);
            $readStr = "";
            /* $readStr.= fgets($fp);
            $readStr=iconv('GB2312', 'UTF-8', $readStr) ; */
            fclose($fp);
           // echo $readStr;
        }
        
        
        // http://101.201.28.96:7070
        return;
    }

}

 