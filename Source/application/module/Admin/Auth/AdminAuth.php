<?php
namespace Admin\Auth;

use Zend\Session\SessionManager;

class AdminAuth
{
    const LOGIN = "admin_is_login";

    public $session;

    private static $instance = null;
        
    public static function auth()
    {
        return self::getInstance();
    }

    public function initSession()
    {
        session_start();
    }

    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new AdminAuth();
            $config = self::$instance->sessionConfig();
            if (isset($config['session_admin'])) {
                $session_admin = $config['session_admin'];
                $session_admin_config = null;
                if (isset($session_admin['config'])) {
                    $class = isset($session_admin['config']['class']) ? $session_admin['config']['class'] : 'Zend\Session\Config\SessionConfig';
                    $options = isset($session_admin['config']['options']) ? $session_admin['config']['options'] : array();
                    $session_admin_config = new $class();
                    $session_admin_config->setOptions($options);
                }
            }
            self::$instance->session = new SessionManager($session_admin_config);
        }
        return self::$instance;
    }

    private function sessionConfig()
    {
        return array(
            'session_admin' => array(
                'config' => array(
                    'class' => 'Zend\Session\Config\SessionConfig',
                    'options' => array(
                        'name' => 'PHPSESSID',
                        'use_trans_sid' => '1',
                        'save_handler' => 'files',
                        'save_path' => APP_PATH . '/session_admin/',
                        'use_only_cookies' => '0',
                        'UseCookies' => '1',
                        'CookiePath' => '/',
                        'CookieDomain' => '',
                        'CookieLifetime' => '14000',
                        'GcMaxlifetime' => '14000',
                        'GcDivisor' => '1',
                        'GcProbability' => '1',
                        'serialize_handler' => 'php_serialize'
                    )
                )
            )
        );
    }
        
    public function Login($data)
    {
        $_SESSION[self::LOGIN]=true;
        $_SESSION['user'] = $data;
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        }else{
            $_SESSION['HTTP_USER_AGENT'] = "Unknow";
        }
        $_SESSION['REMOTE_ADDR'] = $_SERVER["REMOTE_ADDR"];
        return true;
    }

    public function isLogin()
    {
        if(!empty($_SESSION[self::LOGIN])){
            return true;
        }else{
            session_unset();
            session_destroy();
            return false;
        }
    }

    public function checkAuthority($method)
    {
        $result = array(
            "state"=>"1",
            "power" => "0",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );

        try {
            if($method=="loginAction")
            {
                $result["Msg"]="loginAction";
            
            }else{
                if($this->isLogin()==false)
                {
                    $result["state"]="0";
                    $result["msg"]="No Login!";
                }
            }
        } catch (\Exception $e) {
            $result["state"]="0";
            $result["errorMsg" ] = $e->getMessage();
            $result["msg" ] = "Exception!";
        }
        return $result;
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

            if($method == 'getSeccodeAction'){
                return $result;
            }
    
            if($method == 'checkLoginAction'){
                return $result;
            }

            //注册接口，直接跳过
            if($method == 'registAction'){
                return $result;
            }

            //检查用户是否登录
            if ($this->isLogin() == false){
                $result["state"] = "2";
                $result["msg"] = "没有登录！";
                return $result;
            }

            if($method == 'indexAction'){
                $result["state"] = "2";
                $result["msg"] = "没有登录！";
                return $result;
            }

            //检查用户是否有权限操作Action
            if ($this->checkPermission($method) == false){
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

    public function checkPermission($method)
    {
        return true;
    }

    public function logout()
    {
        session_unset();

        if(isset($_COOKIE[session_name()]))
        {
            setcookie(session_name(),'',time()-4200,'/');
        }

        session_destroy();
        return true;
    }

}



