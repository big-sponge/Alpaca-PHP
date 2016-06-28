<?php
namespace Alpaca\Factory;

class ServerManager
{    
    private $factories = array();
    
    private $formEvent = [];
    
    private $classEvent = [];
    
    private $serviceEvent = [];
    
    private $controllerEvent = [];
    
    private $moduleEvent = [];
    
    private static $instance;

    
    public function __construct(array $factories = null)
    {
        $this->factories = $factories;
    }
    
    public function setAsGlobal()
    {
        self::$instance = $this;
        return $this;
    }

    public function addClassEvent($name,$event)
    {
        $this->classEvent[(string) $name] = $event;
        return $this;
    }
    
    public function addClassEvents(array $events)
    {
        if (empty( $events )) {
            return $this;
        }
        foreach ($events as $key => $value) {
            $this->addClassEvent($key, $value);
        }
        return $this;
    }

    public function addFormEvent($name,$event)
    {
        $this->formEvent[(string) $name] = $event;
        return $this;
    }
    
    public function addFormEvents(array $events)
    {
        if (empty( $events )) {
            return $this;
        }
        foreach ($events as $key => $value) {
            $this->addFormEvent($key, $value);
        }
        return $this;
    }
    
    public function addServiceEvent($name,$event)
    {
        $this->serviceEvent[(string) $name] = $event;
        return $this;
    }
    
    public function addServiceEvents(array $events)
    {
        if (empty( $events )) {
            return $this;
        }
        foreach ($events as $key => $value) {
            $this->addServiceEvent($key, $value);
        }
        return $this;
    }
    
    public function setFactories($factories)
    {
        $this->factories = $factories;
        return $this;
    }
        
    public function addFactories($factories)
    {
        if(empty($this->factories)){
            $this->factories = array();
        }
        $this->factories = array_merge($this->factories,$factories);
        return $this;
    }
    
    public function get($class)
    {
        if(empty($this->factories[$class])){
            die("Error: Factories \"{$class}\" not found!");
        }       
        return $this->factories[$class](self::factory());
    }

    public function module($module)
    {
        $class = new $module();    
        if(!empty($this->moduleEvent)){
            foreach ($this->moduleEvent as $key => $value){
                $class->$key = $value;
            }
        } 
        return $class;
    }
    
    public function controller($controller)
    {
        $class = new $controller();
        if(!empty($this->controllerEvent)){
            foreach ($this->controllerEvent as $key => $value){
                $class->$key = $value;
            }
        }
        return $class;
    }
        
    public function form($form)
    {
        $class = new $form();
        
        if(!empty($this->formEvent)){
            foreach ($this->formEvent as $key => $value){               
                $class->$key = $value;
            }
        }
    
        return $class;
    }
    
    public function create($className)
    {
        $class = new $className();
        
        if(!empty($this->classEvent)){
            foreach ($this->classEvent as $key => $value){
                $class->$key = $value;
            }
        }       
        return $class;
    }
       
    public static function factory(array $factories = null)
    {
        return self::getInstance($factories);
    }
    
    private static function getInstance(array $factories = null)
    {
        if(!self::$instance){
            self::$instance = new ServerManager($factories);
        }
        return self::$instance;
    }
        
}