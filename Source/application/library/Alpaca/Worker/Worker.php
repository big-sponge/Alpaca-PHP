<?php
namespace Alpaca\Worker;

class Worker
{        
    private static $instance;
    
    public static function worker()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
        
    public function action(array $worker = null)
    {
        $ip   = empty($worker['SERVER_ADDR']) ? $_SERVER['SERVER_NAME'] : $worker['SERVER_ADDR'];     //服务器IP地址
        $port = empty($worker['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : $worker['SERVER_PORT'];     //服务器端口
        $url  = empty($worker['REQUEST_URI']) ? '/' :$worker['REQUEST_URI'];                          //服务器URL
        $data = empty($worker['REQUEST_DTAT']) ? '' :$worker['REQUEST_DTAT'];                         //请求参数

        $fp = fsockopen("{$ip}", $port, $errno, $errstr, 1);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $out = "POST {$url} HTTP/1.1\r\n";
            $out .= "Host: {$ip}\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $out .="\r\n";
            $out .=$data;
            fwrite($fp, $out);
            fclose($fp);
        }       
        return 'worker!';
    }       
}