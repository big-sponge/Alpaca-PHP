<?php
namespace Alpaca\MVC;

use Alpaca\MVC\Router\Router;

class Application
{
    public $config;    
        
    private static $instance;
    
    public function __construct(array $config = null)
    {     
        $this->config = $config;
        return $this;
    }
        
    public function run()
    {        
        Router::router()->start();
    }

    public function bootstrap(){
    
        require_once APP_PATH . '/application/Bootstrap.php';
        
        $bootstrap = new \Bootstrap();
        
        $methods = get_class_methods($bootstrap);
        if(!$methods){
            return $this;
        }
               
        foreach ($methods as $method){
            if(preg_match("/(^(_init))/",$method)){
                $bootstrap->$method();
            }
        }
        return $this;
    }  

    public function getModules()
    {        
        if(empty($this->config['application']['module'])){
            return null;
        }
        return array_map("trim", explode(',',$this->config['application']['module']));
    }
    
    public static function app(array $config = null)
    {
        return self::getInstance($config);
    }
    
    private static function getInstance(array $config = null)
    {
        if(!self::$instance){
            self::$instance = new Application($config);
        }
        return self::$instance;
    }
}
