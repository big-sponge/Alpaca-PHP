<?php
use Zend\Db\Adapter\Adapter;
use Alpaca\Factory\ServerManager; 
use Illuminate\Database\Capsule\Manager as Capsule;
use Alpaca\MVC\Router\Router;
use Alpaca\MVC\Application;

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Alpaca调用,
 */
class Bootstrap
{
    public function _initConfig()
    {
        ServerManager::factory()->addFactories(array(
            'config' =>  function() {
                return Application::app()->config;
            },
        ));
    }

    public function _initDatabase()
    {
        $config = Application::app()->config;
        $capsule = new Capsule;
        $capsule->addConnection($config['database']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
    
    public function _initDefaultService()
    {
        $factories = array(   
                'Zend\Db\Adapter\Adapter' =>  function($sm) {
                    if(empty($sm->getClassLib('Zend\Db\Adapter\Adapter'))){
                        $config = $sm->get("config");
                        $sm->setClassLib('Zend\Db\Adapter\Adapter',new Adapter($config['db']));
                    }        
                    return $sm->getClassLib('Zend\Db\Adapter\Adapter');
                },
        );
        ServerManager::factory()->addFactories($factories);
    }
    
    public function _initDefaultEntry()
    {
        Router::router()->DefaultModule ='Index';
        Router::router()->DefaultController ='Index';
        Router::router()->DefaultAction ='index';
    }
}