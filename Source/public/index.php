<?php

use Alpaca\MVC\Application;
/* 错误提示 */
if (!empty($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] == 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
} 

/* 指向public的上一级 */
define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); 

/* 加载系统配置文件*/
global $CONFIG;
$config = require APP_PATH."/conf/config.php";
$CONFIG = $config;


/* 加载 AutoLoader */
require APP_PATH . '/application/init_autoloader.php';

/* 启动Alpaca */
Application::app($config)->bootstrap()->run();




