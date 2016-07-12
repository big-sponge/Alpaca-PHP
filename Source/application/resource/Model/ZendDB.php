<?php
namespace Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Factory\ServerManager;
use Alpaca\MVC\Application;
use Zend\Db\Adapter\Adapter;

class ZendDB
{    
    private static $instance;
    
    private $adapter;
    
    private $table;
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function setAdapter($adapter = null)
    {       
        if(!$adapter){
            $config = Application::app()->config;
            $adapter = new Adapter($config['db']); 
        }
        
        self::getInstance()->adapter = $adapter;
        return self::$instance;
    }
    
    public static function getAdapter($adapter)
    {
        return self::getInstance()->adapter;
    }
        
    public static function table($table)
    {     
        if(!self::getInstance()->adapter){
            self::setAdapter();
        }

        $dbAdapter = self::getInstance()->adapter;
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(ServerManager::factory()->create('Model\\Model\\'.ucfirst($table)));
        $tableGateway = new TableGateway("tb_{$table}", $dbAdapter, null, $resultSetPrototype);
        $table =  ServerManager::factory()->create("Model\\Table\\".ucfirst($table)."Table", $tableGateway);
        return $table;
    }    
}