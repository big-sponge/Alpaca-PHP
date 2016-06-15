<?php
namespace Alpaca\Factory;

class ServerManager
{    
    private $factories = array();
    
    private $formEvent = array();
    
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

    public function addFormEvent($formEvent)
    {
        array_push($this->formEvent, $formEvent);
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


