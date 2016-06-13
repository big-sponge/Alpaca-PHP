<?php
namespace Test\Auth;

class Auth
{               
    public $session;
    
    public function initSession()
    {  
        session_start();
    }
   
    public function Login($data)
    {                        
        $_SESSION['isLogin']=true;      
        $_SESSION['user'] = $data;  
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        }else{
            $_SESSION['HTTP_USER_AGENT'] = "Unknow";
        }
        $_SESSION['REMOTE_ADDR'] = $_SERVER["REMOTE_ADDR"];
        return true;
    }

    public function Logout()
    {
        session_unset();
        
        if(isset($_COOKIE[session_name()]))
        {
            setcookie(session_name(),'',time()-4200,'/');
        }
        
        session_destroy();
        return true;
    }
           
    public function isLogin()
    {           
        if(!empty($_SESSION['isLogin'])){
            return true;
        }else{
            session_unset();
            session_destroy();
            return false;
        }
        return false;
    }

    public function checkPermission($method)
    {
        return true;
    }
    
    public function getUserInfo()
    {
        $userInfo = null;      
        if(isset($_SESSION['Userinfo']))
        {
            $userInfo = $_SESSION['Userinfo'];
        }        
        return $userInfo;
    }
       
    public function checkAuth($method)
    {                       
        $result = array(
            "state"=>"1",
            "power" => "0",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );
         
        try {            
            //登录接口，直接跳过
            if($method == 'loginAction'){
                return $result;
            }

            //注册接口，直接跳过
            if($method == 'registerAction'){
                return $result;
            }

            //检查用户是否登录
            if ($this->isLogin() == false) {
                $result["state"] = "2";
                $result["msg"] = "没有登录！";
                return $result;
            }
            
            //检查用户是否有权限操作Action
            if ($this->checkPermission($method) == false) {
                $result["state"] = "3";
                $result["msg"] = "没有权限！";
                return $result;
            }

        } catch (\Exception $e) {
            $result["state"]="0";
            $result["errorMsg" ] = $e->getMessage();
            $result["msg" ] = "Exception!";           
        }
        
        return $result;
    }
    
}



