<?php
spl_autoload_register(function($class){
 
    global $CONFIG;
        
    //有命名空间
    $className = str_replace("\\", "/", $class);
    //无命名空间
    $className = str_replace("_", "/", $className);
    
    //加载模块modules中的类
    if(!empty($CONFIG['application']['module'])){
        $moduleNames = str_replace(",", "|", $CONFIG['application']['module']);
    }else{
        $moduleNames = null;
    }
    if($moduleNames){
 
        $preg_moduleNames ="/(^({$moduleNames}))/";
        if(preg_match($preg_moduleNames,$className)){
            $className = "module/".$className.".php";
            require_once($className);
            return;
        }
    }

    //加载Resources中的类
    if(!empty($CONFIG['application']['resource'])){
        $resourceNames = str_replace(",", "|", $CONFIG['application']['resource']);
    }else{
        $resourceNames = null;
    }
    $resourceNames=str_replace(",", "|", $CONFIG['application']['resource']);
    if($resourceNames){
        $preg_resourceNames ="/(^({$resourceNames}))/";
        if(preg_match($preg_resourceNames,$className)){
            $className = "resource/".$className.".php";
            require_once($className);
            return;
        }
    }
            
    //加载Service中的类
    $serviceNames = 'Service';
    $preg_serviceNames ="/(^({$serviceNames}))/";
    if(preg_match($preg_serviceNames,$className)){       
        $className = lcfirst($className);        
        $className = $className.".php";
        require_once($className);
        return;
    }
    
    //加载library中的类
    if(!empty($CONFIG['application']['library'])){
        $resourceNames = str_replace(",", "|", $CONFIG['application']['library']);
    }else{
        $resourceNames = null;
    }
    $libraryNames = str_replace(",", "|", $CONFIG['application']['library']);
    if($libraryNames){
        $preg_libraryNames ="/(^({$libraryNames}))/";
        if(preg_match($preg_libraryNames,$className)){
            $className = "library/".$className.".php";
            require_once($className);
            return;
        }   
    }
    
});

require_once("library/vendor/autoload.php");
    
