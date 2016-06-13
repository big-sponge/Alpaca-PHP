<?php
namespace Test2;
use Test\Form\TestForm;

class Module
{   
    public function getFactories()
    {
        return array(
            'factories' => array(   
                'Test\Form\TestForm2' =>  function() {
                    $form = new TestForm();
                    return $form;
                },
            ),
        );
    }    
}
