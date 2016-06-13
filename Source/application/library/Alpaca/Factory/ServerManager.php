<?php
namespace Alpaca\Factory;

class ServerManager
{    
    private $factories;
    
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }
    
    public function addFactories($class)
    {
        return $this->factories[$class]();
    }
    
    public function get($class)
    {
        return $this->factories[$class]();
    }
}


