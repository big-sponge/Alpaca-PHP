<?php
namespace Alpaca\MVC\View;


use Alpaca\MVC\Router\Router;
class View
{    
    const VIEW_TYPE_HTML = 1;
    
    const VIEW_TYPE_JSON = 2;   

    const VIEW_TYPE_IMAGE = 3;
    
    public static $DefaultViewCaptureTo = "content";
     
    public static $TemplatePostfix ='.phtml';
          
    public $CaptureTo = 'content';
      
    public $Template = '';
    
    public $EnableView = true;
    
    public $Data = array();
    
    public $Children = array();
    
    public $ChildData = array();
    
    public $UseLayout = false;
    
    public $Layout = null;
    
    public $LayoutData = array();
    
    public $PartData = array();
        
    public $getTemplate = null;
    
    public $loadData = null;
    
    public $Type = null;
    
    public $Html = null;
    
    public $IsJsonp = true;
    
    public $Final = false;
        
    public function __construct( $data = null , $type =self::VIEW_TYPE_HTML)
    {
        if($type == self::VIEW_TYPE_JSON)
        {
            if(is_string($data)){
                $data = ['json'=>$data];
            }elseif(is_array($data)){
                $data = ['json'=>json_encode($data,JSON_UNESCAPED_UNICODE)];
            }    
            $this->Data = $data;
            
        }else{
            $this->setData($data);
        }
        
        $this->Type = $type;
        
        return $this;
    }
   
    public function render($data = null)
    {
        //render children
        if($this->hasChildren()){
            foreach ($this->Children as $child){               
                $captureTo = $child->getCaptureTo();            
                $childData = null;
                if(!empty($this->ChildData[(string) $captureTo])){
                    $childData = $this->ChildData[(string) $captureTo];
                }
                $this->$captureTo = $child->render($childData);
            }
        }
        
        //render itself        
        if(!empty($this->Data)){
            foreach ($this->Data as $key => $value){
                $this->$key = $value;
            }
        }

        
        if(!empty($data)){
            foreach ($data as $key => $value){
                $this->$key = $value;
            } 
        }        
        
        try {
            ob_start();
            $includeReturn = include $this->Template;
            $this->Html = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }
        
        return $this->Html;
    }
        
    public function setTemplate($template)
    {
        $this->Template = (string) $template;
        return $this;
    }
    
    public function getCaptureTo()
    {
        return $this->CaptureTo;
    }
    
    public function setCaptureTo($capture)
    {
        $this->CaptureTo = (string) $capture;
        return $this;
    }
    
    public function setType($type)
    {
        $this->Type = $type;
        return $this;
    }
    
    public function setDataOne($name, $value)
    {
        $this->Data[(string) $name] = $value;
        return $this;
    }
    
    public function setData(array $data =null )
    {   
        if (empty( $data )) {
            return $this;
        }
        foreach ($data as $key => $value) {
            $this->setDataOne($key, $value);
        }
        return $this;
    }
    
    public function setIsJsonp($value)
    {
        $this->IsJsonp = $value;
        return $this;
    }
    
    public function setFinal($value){
        $this->Final = $value;
        return $this;
    }
    
    public function setUseLayout($value){
        $this->UseLayout = $value;
        if($this->UseLayout && empty($this->Layout)){
            $this->setLayout(static::layout());
        }
        return $this;
    }
    
    public function setLayout(View $layout, array $data = null)
    {        
        if($data != null){
            $layout->setData($data);
        }        
        $this->UseLayout = true;
        $this->Layout= $layout;
        $this->Layout->addChild($this); 
        return $this;
    }
        
    public function setLayoutData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setLayoutDataOne($key, $value);
        }
        return $this;
    }

    public function setLayoutDataOne($name, $value)
    {
        $this->LayoutData[$name]= $value;
        return $this;
    }
    
    public function setPart(View $part,array $data = null)
    {
        if($data != null){
            $part->setData($data);
        }
        $this->Layout->addChild($part);
        return $this;
    }    
    
    public function setPartData($part, array $data)
    {
        foreach ($data as $key => $value) {
            $this->setPartDataOne($part,$key, $value);
        }
        return $this;
    }

    public function setPartDataOne($capture, $name, $value)
    {
        $this->PartData[$capture][$name]= $value;
        return $this;
    }
        
    public function addChild($child, $captureTo = null)
    {
        if (null !== $captureTo) {
            $child->setCaptureTo($captureTo);
        }
        $this->Children[] = $child;  
        return $this;
    }
        
    public function getChildren()
    {
        return $this->Children;
    }
    
    public function hasChildren()
    {
        return (0 < count($this->Children));
    }
    
    public function setChildDataOne($child,$name, $value)
    {
        $this->ChildData[(string) $child][(string) $name] = $value;
        return $this;
    }
    
    public function setChildData($child, array $data)
    {
        foreach ($data as $key => $value) {
            $this->setChildDataOne($child,$key, $value);
        }
        return $this;
    }   
                   
    public static function view()
    {
        $view = new View();
        $view->setTemplate(static::defaultViewTemplate());
        return $view;
    }

    public static function layout()
    {
        $view = new View();
        $view->setTemplate(static::defaultLayoutTemplate());
        return $view;
    }
    
    public static function part($name,$captureTo = null)
    {
        $view = new View();
        if($captureTo == null){
            $captureTo = $name;
        }
        $view->setCaptureTo($captureTo);
        $view->setTemplate($view->defaultPartTemplate($name));
        return $view;
    }
    
    public static function defaultViewCaptureTo()
    {
        return self::$DefaultViewCaptureTo;
    }

    public static function ViewLayoutCaptureTo()
    {
        return self::$DefaultViewCaptureTo;
    }
    
    public static function defaultViewTemplate()
    {
        $module = Router::router()->Module;
        $controller = Router::router()->Controller;
        $action = Router::router()->Action;
        $templatePostfix = self::$TemplatePostfix;
        return APP_PATH."/application/module/{$module}/view/{$controller}/{$action}{$templatePostfix}";
    }
    
    public static function defaultLayoutTemplate()
    {       
        $module = Router::router()->Module;
        $templatePostfix = self::$TemplatePostfix;
        return APP_PATH."/application/module/{$module}/view/Layout/layout{$templatePostfix}";
    }

    public static function defaultPartTemplate($name)
    {
        $module = Router::router()->Module;
        $templatePostfix = self::$TemplatePostfix;
        return APP_PATH."/application/module/{$module}/view/Layout/Part/{$name}{$templatePostfix}";
    }   

    public static function html( $data = null , $type = self::VIEW_TYPE_HTML)
    {
        return new View($data, $type);
    }
    
    public static function json( $data = null , $type = self::VIEW_TYPE_JSON)
    {
        return new View($data, $type);
    }
    
    public static function image( $data = null , $type = self::VIEW_TYPE_IMAGE)
    {
        return new View($data, $type);
    }
    
    public function display()
    {
        if($this->Type ==self::VIEW_TYPE_HTML){
            $this->displayToHtml();
        }elseif($this->Type ==self::VIEW_TYPE_JSON){
            $this->displayToJson();
        }else{
            $this->displayToHtml();
        }
    }

    public function displayToHtml()
    {
        if($this->UseLayout){
            if($this->LayoutData){
                $this->Layout->setData($this->LayoutData);
            }
            if($this->PartData){
                foreach ($this->PartData as $key => $value )
                {
                    $this->Layout->setChildData($key, $value);
                }
            }
            echo $this->Layout->render();
        }else{
            echo $this->render();
        }
    }
     
    public function displayToImage()
    {
        if($this->UseLayout){
            echo $this->Layout->render();
        }else{
            echo $this->render();
        }
    }
        
    public function displayToJson()
    {
        header('Content-Type: application/json;charset=utf-8');
        if($this->IsJsonp){
            $cb = isset($_GET['callback']) ? $_GET['callback'] : null;
            if($cb){
                echo "{$cb}(".$this->Data['json'].")";
            }else{
                echo $this->Data['json'];
            }
        }
    
        if(!$this->IsJsonp){
            echo $this->Data['json'];
        }
    }
}
