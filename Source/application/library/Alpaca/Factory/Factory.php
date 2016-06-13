<?php
namespace Alpaca\Factory;

class Factory
{    
    public static function get($class)
    {
        \Yaf_Registry::get("factoryConfig");
        $factories = \Yaf_Registry::get("factoryConfig");
        return $factories[$class]();
    }
}


