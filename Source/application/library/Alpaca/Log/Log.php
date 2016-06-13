<?php
namespace Alpaca\Log;

class Log
{
    static $basePath=APP_PATH."/logs/";
    
    public static function add($string)
    {   
        $date = date("Y-m-d H:i:s",time());        
        $logStr = "{$date} info: {$string} \n";    
        $logFileName = date("Y-m-d",time()).".log";          
        file_put_contents(self::$basePath.$logFileName,$logStr,FILE_APPEND|LOCK_EX);
    }
    
    public static function error($string)
    {
        if (!empty($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] == 'development') {
            $date = date("Y-m-d H:i:s",time());
            $logStr = "{$date} info: {$string} \n";
            $logFileName = date("Y-m-d",time())."_error.log";
            file_put_contents(self::$basePath.$logFileName,$logStr,FILE_APPEND|LOCK_EX);
        }
    }
    
    public static function debug($string)
    {
        if (!empty($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] == 'development') {
            $date = date("Y-m-d H:i:s",time());
            $logStr = "{$date} info: {$string} \n";
            $logFileName = date("Y-m-d",time())."_debug.log";
            file_put_contents(self::$basePath.$logFileName,$logStr,FILE_APPEND|LOCK_EX);
        }
    }
    
}
