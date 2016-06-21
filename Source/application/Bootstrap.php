<?php
use Zend\Db\Adapter\Adapter;
use Alpaca\Factory\ServerManager; 
use Illuminate\Database\Capsule\Manager as Capsule;

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

    public function _initDatabase()
    {
        $config = $this->app->config;
        $capsule = new Capsule;
        $capsule->addConnection($config['database']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
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
}