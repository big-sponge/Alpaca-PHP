<?php
namespace Alpaca\Factory;

class Factory
{    
    public static $factories =array();
    
    public static function set($name,$value)
    {
        $factories[$name] = $value;
    }
    
    public static function get($name)
    {
        return  $factories[$name];
    }
}


