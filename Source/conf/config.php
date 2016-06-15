<?php
return array(   
    'application' => array(
        "directory" => APP_PATH."/application/",
        "module" => 'Index',
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

    'database'=>array(
        'driver'    => 'mysql',
        'host'      => '123.56.190.70',
        'database'  => 'db_passport',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ),

    'jwt' =>array(
        "sub"=>"",
        "iss"=>"",
        "iat"=>time(),
        "exp"=>time() + 3600,
        "nbf"=>time() + 60,
        "secret"=>"Alpaca-php"
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
    ),
);
