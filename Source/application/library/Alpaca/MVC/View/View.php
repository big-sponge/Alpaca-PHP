<?php
namespace Alpaca\MVC\View;


class View
{    
    const VIEW_TYPE_HTML = 1;
    
    const VIEW_TYPE_JSON = 2;   

    const VIEW_TYPE_IMAGE = 3;
    
    
    public static $App;
    
    public $CaptureTo = 'content';
      
    public $Template = '';
    
    public $EnableView = true;
    
    public $Data = array();
    
    public $UseLayout = false;
    
    public $Layout = null;
    
    public $LayoutData = null;
    
    public $Children = array();
    
    public $ChildrenData = array();
    
    public $getTemplate = null;
    
    public $loadData = null;
    
    public $Type = null;
    
    public $Html = null;
    
    public $IsJsonp = true;
        
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
                if(!empty($this->ChildrenData[(string) $captureTo])){
                    $childData = $this->ChildrenData[(string) $captureTo];
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
    
    public function setUseLayout($value){
        $this->UseLayout = $value;
        return $this;
    }
    
    public function setLayout($layout)
    {
        $this->Layout= $layout;
        return $this;
    }
    
    public function setLayoutDataOne($name, $value)
    {
        $this->Layout->Data[(string) $name] = $value;
        return $this;
    }
    
    public function setLayoutData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setLayoutDataOne($key, $value);
        }
        return $this;
    }
    
    public function setSisterDataOne($sister,$name, $value)
    {
        $this->Layout->childData[(string) $sister][(string) $name] = $value;
        return $this;
    }
    
    public function setSisterData($sister, array $data)
    {
        foreach ($data as $key => $value) {
            $this->setSisterDataOne($sister,$key, $value);
        }
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
        $this->childData[(string) $child][(string) $name] = $value;
        return $this;
    }
    
    public function setChildData($child, array $data)
    {
        foreach ($data as $key => $value) {
            $this->setChildDataOne($child,$key, $value);
        }
        return $this;
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

 
    public function displayToHtml()
    {
        if($this->UseLayout){
            echo $this->layout->render();
        }else{
            echo $this->render();
        }
    }
     
    public function displayToImage()
    {
        if($this->UseLayout){
            echo $this->layout->render();
        }else{
            echo $this->render();
        }
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
           
    
    public static $DefaultViewCaptureTo = "content";
    	
    public static $TemplatePostfix ='.phtml';
        
    public static function getDefaultView($view)
    {
        return null;
    }
    	
    public static function getDefaultViewCaptureTo()
    {
        return Alpaca.View.DefaultViewCaptureTo;
    }
    	
    public static function getDefaultViewTemplate()
    {
        $module = self::$App->router->Module;
        $controller = self::$App->router->Controller;
        $action = self::$App->router->Action;
        $templatePostfix = self::$TemplatePostfix;
        return APP_PATH."/application/module/{$module}/view/{$controller}/{$action}{$templatePostfix}";
    }
    	
    public static function getDefaultLayout($layout)
    {
        return new View();
    }
    	
    public static function getDefaultLayoutTemplate()
    {       
        $module = self::$App->router->Module;
        $templatePostfix = self::$TemplatePostfix;
        return APP_PATH."/application/module/{$module}/view/Layout/layout{$templatePostfix}";
    }
    	
    public static function getDefaultLayoutCaptureTo()
    {
        return self::$DefaultViewCaptureTo;
    }
       
}