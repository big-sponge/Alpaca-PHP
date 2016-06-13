<?php

use Alpaca\Factory\Factory;
use Zend\Db\Adapter\Adapter;
/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Alpaca调用,
 */
class Bootstrap
{
    public function _initConfig()
    {
        var_dump($this->app);
    }

    public function a_initModules()
    {
        $modules = Yaf_Application::app()->getModules();  
        $factoryConfig = array();
        foreach ($modules as $m) {
            if ($m =="Index"){
                continue;
            }
            $class = "{$m}\\Module";
            $m = new $class();      
            if (method_exists($m, 'getFactories')) {
                if (! empty($m->getFactories()['factories'])) {
                    $factoryConfig = array_merge($factoryConfig, $m->getFactories()['factories']);
                }
            }
        }
        
        Yaf_Registry::set("factoryConfig", $factoryConfig);
    }

    public function _initDefaultName()
    {
        
    }

    public function a_initDefaultService()
    {
        $factories = array(   
                'Zend\Db\Adapter\Adapter' =>  function() {                   
                    $config = Yaf_Registry::get("config");
                    return new Adapter($config['db']);
                },
        );
        
        $factoryConfig = array_merge(Yaf_Registry::get("factoryConfig"),$factories);
        Yaf_Registry::set("factoryConfig", $factoryConfig);       
    }
}