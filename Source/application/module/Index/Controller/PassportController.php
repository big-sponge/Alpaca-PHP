<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;
use Illuminate\Container\Container;  
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好 
use Model\User;
use Service\JwtAuth\jwtManager;
 
class PassportController
{   

    protected $return_data = [];

    public function init(){
       
        
    }
    
 
    
    public function indexAction()
    {   
        


        $data =array(
            'issuer'=>1,
            'audience'=>'pay.1010shuju.com',
            'id'=>111111,
        );
        $token = jwtManager::jwt()->creatToken($data);
        
        $toekn = $token->getToeknString();
        
        $this->return_data['return_code'] = 1;
        $this->return_data['return_message'] = "生成成功";
        $this->return_data['return_toekn'] = $toekn;

        return ViewModel::json($this->return_data);

    }

    public function checkAction()
    {
        

        //获取token
        $token = $this->params[0];
        $tokenInfo = jwtManager::jwt()->parserToekn($token);
         
        if ($tokenInfo) {

            $this->return_data['return_code'] = 0;
            $this->return_data['return_message'] = "token不存在或者过期";
            return ViewModel::json($this->return_data);
        }
         


       
    }

 

 

}

 