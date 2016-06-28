<?php
namespace Alpaca\MVC\View;

class Redirect
{    
    private static $instance;
    
    const REDIRECT_TYPE_URL  = 1;
    
    const REDIRECT_TYPE_ROUTER  = 2;
    
    public $type = 1;
    
    public $path = '';
    
    public static function redirect()
    {
        return self::getInstance();
    }
    
    public static function toUrl($path)
    {
        return self::getInstance()->_toUrl($path);
    }

    public static function toRouter($path)
    {
        return self::getInstance()->_toRouter($path);
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }     

    public  function _toUrl($path)
    {
        $this->type = self::REDIRECT_TYPE_URL;
        $this->path = $path;
        return $this;
    }
    
    public  function _toRouter($path)
    {
        $this->type = self::REDIRECT_TYPE_ROUTER;
        $this->path = $path;
        return $this;
    }   
}
