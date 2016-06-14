<?php
namespace Index;
use Test\Form\TestForm;
use Zend\Session\SessionManager;
use Test\Auth\Auth;
use Sponge\Factory\Factory;

class Module
{   
    
    public function getFactories()
    {
        return array(
            'factories' => array(   
                'Test\Form\TestForm' =>  function($sm) {
                    $form = new TestForm();
                    return $form;
                },
                'Test\Auth\Auth' => function (){
                    $auth = new Auth();
                    $session = $sm->get('Test\Auth\SessionManager');
                    $auth->session = $session;            
                    return $auth; 
                },
                'Test\Auth\SessionManager' => function (){
                    $sessionManager = null;   
                    $config =\Yaf_Registry::get('config');
                    if (isset($config['session'])) {
                        $session = $config['session'];
                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class']) ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }
                    }
                    $sessionManager = new SessionManager($sessionConfig);
                    return $sessionManager;
                },
                'Test\Test\Sm' => function ($sm){

                    return $sm->get('Test\Test\Sm2');
                },
                
                'Test\Test\Sm2' => function (){
                
                return "ddd 33 kk";
                },
           ),
        );
    }    
}
