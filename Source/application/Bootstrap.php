<?php

use Zend\Db\Adapter\Adapter;
use Alpaca\Factory\ServerManager;
use Illuminate\Container\Container;  
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好 
/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Alpaca调用,
 */
class Bootstrap
{
    public function _initConfig()
    {
        ServerManager::factory()->addFactories(array(
            'config' =>  function() {
                return $this->app->config;
            },
        ));
    }

    public function _initModules()
    {        
        $modules = $this->app->getModules();           
        if(!$modules){ return; }

        $factories = array();
        foreach ($modules as $m) {
            $class = "{$m}\\Module";   
            if(class_exists($class)){   
                $m = new $class();
                if (method_exists($m, 'getFactories')) {
                    if (! empty($m->getFactories()['factories'])) {
                        $factories = array_merge($factories, $m->getFactories()['factories']);
                    }
                }
            }
        }       
        ServerManager::factory()->addFactories($factories);
    }

    public function _initDefaultService()
    {
        $factories = array(   
                'Zend\Db\Adapter\Adapter' =>  function($sm) {                   
                    $config = $sm->get("config");
                    return new Adapter($config['db']);
                },
        );
        ServerManager::factory()->addFactories($factories);
    }    

     public function _initDatabase()
    {


        global $CONFIG;

        $capsule = new Capsule;
        // 创建链接
        $capsule->addConnection($CONFIG['database']);
        // 设置全局静态可访问
        $capsule->setAsGlobal();
        // 启动Eloquent
        $capsule->bootEloquent();
 
    }    


}