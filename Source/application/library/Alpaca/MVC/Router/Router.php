<?php
namespace Alpaca\MVC\Router;

use Alpaca\MVC\Controller\AlpacaController;
use Alpaca\MVC\View\View;
use Alpaca\Factory\ServerManager;

class Router
{
    public $ModulePostfix = 'Module';

    public $ControllerPostfix = 'Controller';

    public $ActionPostfix = 'Action';

    public $DefaultModule = 'index';

    public $DefaultController = 'index';

    public $DefaultAction = 'index';

    public $Module = null;

    public $Controller = null;

    public $Action = null;

    public $ModuleName = null;

    public $ControllerName = null;

    public $ActionName = null;

    public $ModuleClassName = null;

    public $ControllerClassName = null;
    
    public $Params = Array();
    
    private $controllerClass = null;
    
    private $moduleClass = null;
    
    private $pathSegments = null;
    
    private static $instance;

    public function start()
    {                
        $request_url = $_SERVER['REQUEST_URI'];

        $view = $this->forward($request_url);
        
        $this->display($view);
    }
    
    public function forward($path)
    {        
        //处理请求路由路径，去掉参数
        $pos = stripos($path, '?');
        if ($pos) {
            $path = substr($path, 0, $pos);
        }
        
        //解析路由，生成Module、Controller、Action
        $parserResult = $this->parser($path);
        if($parserResult != true)
        {
            return null;
        }
        
        //设置Module、Controller        
        $this->controllerClass = new $this->ControllerClassName();
        $this->controllerClass->app = $this->app;
        $this->controllerClass->sm = ServerManager::factory();
        $this->controllerClass->params = $this->Params;
          
        $this->moduleClass = new $this->ModuleClassName();
        $this->moduleClass->app = $this->app;
        $this->moduleClass->sm = ServerManager::factory();
        $this->moduleClass->params = $this->Params;
        
        //执行Action之前的事件
        $initResult = $this->init();
                     
        //分发-执行Action 获取视图模型
        if($initResult !== true && $initResult !== false){
            $view = $initResult;
        }elseif($initResult === false){
            return null;
        }else{
            $view = $this->dispatcher();
        }
        
        return $view;
    }
    
    public function display($view)
    {
        //显示视图
        if($view != null){
            $view -> display();
        }
        
        //执行分发后的事件
        $releaseResult = $this->release();
    }
    
    public function parser($path)
    {
        $segments = array();

        $segments = explode('/', $path);
 
        if (empty($segments[3])) {
            array_splice($segments, 1, 0, $this->DefaultModule);
        }
        
        if (empty($segments[3])) {
            array_splice($segments, 2, 0, $this->DefaultController);
        }

        if (empty($segments[3])) {
            array_splice($segments, 3, 0, $this->DefaultController);
        }

        $this->Params = array_slice($segments, 4);
        
        if($this->pathSegments == $segments){
            return false;
        }
        
        $this->pathSegments = $segments;

        // Module
        $this->Module = str_replace(array('.', '-', '_'), ' ', $segments[1]);
        $this->Module = ucwords($this->Module);
        $this->Module = str_replace(' ', '', $this->Module);              
        $this->ModuleName = $this->Module.$this->ModulePostfix;
        $this->ModuleClassName = $this->Module.'\\Module';
                               
        // Controller
        $this->Controller = str_replace(array('.', '-', '_'), ' ', $segments[2]);
        $this->Controller = ucwords($this->Controller);
        $this->Controller = str_replace(' ', '', $this->Controller);   
        $this->ControllerName = $this->Controller.$this->ControllerPostfix;
        $this->ControllerClassName = $this->Module.'\\Controller\\'.$this->ControllerName;
        
        // Action
        $this->Action = $segments[3];
        $this->Action = str_replace(array('.', '-', '_'), ' ', $segments[3]);
        $this->Action = ucwords($this->Action);
        $this->Action = str_replace(' ', '', $this->Action);
        $this->Action = lcfirst($this->Action);        
        $this->ActionName = $this->Action.$this->ActionPostfix;
                        
        if(!class_exists($this->ModuleClassName)){
            $alpacaController = new AlpacaController();
            $alpacaController->moduleNotFoundAction();
            return false;
        }
        
        if(!class_exists($this->ControllerClassName)){      
            $alpacaController = new AlpacaController();
            $alpacaController->controllerNotFoundAction();
            return false;
        }
        
        if(!method_exists(new $this->ControllerClassName(), $this->ActionName))
        {
            $alpacaController = new AlpacaController();
            $alpacaController->actionNotFoundAction();
            return false;
        }
        return true;
    }

    public function init()
    {
        $controllerClass = $this->controllerClass;
        $moduleClass = $this->moduleClass;
                       
        $init ="init";
        $initResult = null;
        
        //执行模块init方法，如果该方法存在
        if(method_exists($moduleClass, $init)){
            $initResult = $moduleClass->$init();
        }
        if($initResult){
            return $initResult;
        }
        
        if($initResult === false){
            return false;
        }
        
        //执行控制器init方法，如果该方法存在
        if(method_exists($controllerClass, $init)){
            $initResult = $controllerClass->$init();
        }
        if($initResult){
            return $initResult;
        }

        if($initResult === false){
            return false;
        }
        
        return true;
    }
    
    public function dispatcher()
    {
        $controllerClass = $this->controllerClass;
        $moduleClass = $this->moduleClass;
                        
        View::$App = $this->app;
        
        $action = $this->ActionName;         
        $view = $controllerClass->$action();
        
        //View
        if(!$view){            
            $getDefaultView ="getDefaultView";
            if(method_exists($controllerClass, $getDefaultView)){
                $view = $controllerClass->$getDefaultView($view);
            }elseif(method_exists($moduleClass, $getDefaultView)){
                $view = $moduleClass->$getDefaultView($view);
            }else{
                return null;
            }        
        }
                
        //View - Template
        if(!$view->Template){
            $getDefaultViewTemplate ="getDefaultViewTemplate";
            if(method_exists($controllerClass, $getDefaultViewTemplate)){
                $view->Template = $controllerClass->$getDefaultViewTemplate();
            }else if(method_exists($moduleClass, $getDefaultViewTemplate)){
                $view->Template = $moduleClass->$getDefaultViewTemplate();
            }else{
                $view->Template = View::getDefaultViewTemplate();
            }
        }
        	
        //View - CaptureTo
        if(!$view->CaptureTo){
            $getDefaultViewCaptureTo ="getDefaultViewCaptureTo";
            if(method_exists($controllerClass, $getDefaultViewCaptureTo)){
                $view->CaptureTo = $controllerClass->$getDefaultViewCaptureTo();
            }else if(method_exists($moduleClass, $getDefaultViewCaptureTo)){
                $view->CaptureTo = $moduleClass->$getDefaultViewCaptureTo();
            }else{
                $view->CaptureTo =View::getDefaultViewCaptureTo();
            }
        }
        
        //Layout
        if($view->UseLayout){
            //Layout
            if(!$view->Layout){
                $getDefaultLayout ="getDefaultLayout";
                if(method_exists($controllerClass, $getDefaultLayout)){
                    $view->Layout = $controllerClass->$getDefaultLayout();
                }else if(method_exists($moduleClass, $getDefaultLayout)){
                    $view->Layout = $moduleClass->$getDefaultLayout();
                }else{
                    $view->Layout =View::$getDefaultLayout();
                }
            }
        
            //Layout - Template
            if(!$view->Layout->Template){               
                $getDefaultLayoutTemplate ="getDefaultLayoutTemplate";
                if(method_exists($controllerClass, $getDefaultLayoutTemplate)){
                    $view->Layout->Template = $controllerClass->$getDefaultLayoutTemplate();
                }else if(method_exists($moduleClass, $getDefaultLayoutTemplate)){
                    $view->Layout->Template = $moduleClass->$getDefaultLayoutTemplate();
                }else{
                    $view->Layout->Template =View::$getDefaultLayoutTemplate();
                }
            }
        }
        
        //执行控制器onDisplay方法，如果该方法存在
        $onDisplay = "onDisplay";
        if(method_exists($controllerClass, $onDisplay)){
            $view = $controllerClass->$onDisplay($view);
        }
        	
        //执行模块onDisplay方法，如果该方法存在
        if(method_exists($controllerClass, $onDisplay)){
            $view = $controllerClass->$onDisplay();
        }
           
        return $view;
    }
  
    public function release()
    {
        $controllerClass = $this->controllerClass;
        $moduleClass = $this->moduleClass;
        $release ="release";
        $releaseResult = null;
        
        //执行模块init方法，如果该方法存在
        if(method_exists($moduleClass, $release)){
            $releaseResult = $moduleClass->$release();
        }
        if($releaseResult){
            return false;
        }
        
        //执行控制器init方法，如果该方法存在
        if(method_exists($controllerClass, $release)){
            $releaseResult = $controllerClass->$release();
        }
        if($releaseResult){
            return false;
        }
        
        return true;
    }

    public function setAsGlobal()
    {
        self::$instance = $this;
        return $this;
    }
    
    public static function router()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new Router();
        }
        return self::$instance;
    }
}
