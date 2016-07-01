<?php
namespace Alpaca\Log;

class Log
{
    private static $basePath = APP_PATH . "/logs/";
        
    public static function add($string)
    {
        $logger = new \Zend\Log\Logger();
        $date = date("Y-m-d H:i:s", time());
        $logFileName = date("Y-m-d", time()) . ".log";
        $writer = new \Zend\Log\Writer\Stream(self::$basePath . $logFileName);
        $logger->addWriter($writer);
        $logger->info($string);
    }

    public static function addName($string, $name)
    {
        $logger = new \Zend\Log\Logger();
        $date = date("Y-m-d H:i:s", time());
        $logFileName = date("Y-m-d", time()) . $name . ".log";
        $writer = new \Zend\Log\Writer\Stream(self::$basePath . $logFileName);
        $logger->addWriter($writer);
        $logger->info($string);
    }

    public static function error($string)
    {
        $logger = new \Zend\Log\Logger();
        $date = date("Y-m-d H:i:s", time());
        $logFileName = date("Y-m-d", time()) . "_error" . ".log";
        $writer = new \Zend\Log\Writer\Stream(self::$basePath . $logFileName);
        $logger->addWriter($writer);
        $logger->info($string);
    }

    public static function debug($string)
    {
        if ($_SERVER['APPLICATION_ENV'] == 'development') {
            $logger = new \Zend\Log\Logger();
            $date = date("Y-m-d H:i:s", time());
            $logFileName = date("Y-m-d", time()) . "_debug" . ".log";
            $writer = new \Zend\Log\Writer\Stream(self::$basePath . $logFileName);
            $logger->addWriter($writer);
            $logger->debug($string);
        }
    }
}
