<?php
return array(   
    'application' => array(
        "directory" => APP_PATH."/application/",
        "module" => 'Index,Test,Test2',
        "resource" => 'Model',
        "library" => 'Alpaca,Zend',
     ), 
       
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=db_alpaca;host=localhost',
        'username' => 'root',
        'password' => '123456',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    
    // 推荐在php.ini中配置session，可以提升响应时间20ms左右
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'PHPSESSID',
                'use_trans_sid' => '1',
                'save_handler' => 'files',
                'save_path' => APP_PATH.'/session/',
                'use_only_cookies' => '0',
                'UseCookies' => '1',
                'CookiePath' => '/',
                'CookieDomain' => '',
                'CookieLifetime' => '14000',
                'GcMaxlifetime' => '14000',
                'GcDivisor' => '1',
                'GcProbability' => '1', 
                'serialize_handler'=>'php_serialize',
            )      
        ),
    )
);
