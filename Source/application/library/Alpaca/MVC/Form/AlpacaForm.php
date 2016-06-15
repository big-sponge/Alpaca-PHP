<?php
namespace Alpaca\MVC\Form;


class AlpacaForm
{    
    private static $instance;
    
    public static function form()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }      
}
