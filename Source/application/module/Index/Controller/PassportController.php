<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;
use Service\JwtAuth\JwtManager;
 
class PassportController
{   

    protected $return_data = [];

    public function init(){
              
    }
   
    public function indexAction()
    {       
        
        if (empty($this->params)||empty($this->params[0])) {

            $this->return_data['return_code'] = 0;
            $this->return_data['return_message'] = "账户必须填写";
            return ViewModel::json($this->return_data); 
        }

        $user_name = $this->params[0];
     
        $data =array(
            'issuer'=> $user_name,
            'audience'=>$_SERVER["HTTP_HOST"],
            'id'=>mt_rand(0,100000)*mt_rand(0,100000),
        );

        $token = JwtManager::jwt()->creatToken($data);
        
        $toekn = $token->getToeknString();
        
        $this->return_data['return_code'] = 1;
        $this->return_data['return_message'] = "生成成功";
        $this->return_data['return_toekn'] = $toekn;

        return ViewModel::json($this->return_data);

    }

    public function checkAction()
    {        
        //获取token
        $token = $_GET['token'];
        $tokenInfo = jwtManager::jwt()->parserToekn($token);

        var_dump($tokenInfo);
        die();
         
        if (!$tokenInfo) {
            $this->return_data['return_code'] = 0;
            $this->return_data['return_message'] = "token不存在或者过期";
            return ViewModel::json($this->return_data);
        }

        $this->return_data['return_code'] = 1;
        $this->return_data['return_message'] = "已经登录";
        $this->return_data['return_toekn'] = $tokenInfo->getClaim('issuer');

        return ViewModel::json($this->return_data);
    }
   
}

 