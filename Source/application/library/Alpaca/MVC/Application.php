<?php
namespace Alpaca\MVC;

use Alpaca\MVC\Router\Router;

class Application
{    
   
    public $config;    
    
    public $router;
        
    
    public function __construct(array $config)
    {     
        $this->config = $config;
        $this->router = new Router();
        return $this;
    }
    
    public function run()
    {        
        $this->router->app = $this;
        $this->router->start();
    }

    public function bootstrap(){
    
        require_once APP_PATH . '/application/Bootstrap.php';
        
        $bootstrap = new \Bootstrap();
        
        $methods = get_class_methods($bootstrap);
        if(!$methods){
            return $this;
        }
       
        $bootstrap->app = $this;
        
        foreach ($methods as $method){
            if(preg_match("/(^(_init))/",$method)){
                $bootstrap->$method();
            }
        }
        return $this;
    }        
}
