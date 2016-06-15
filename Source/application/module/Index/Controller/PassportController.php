<?php
namespace Index\Controller;

use Alpaca\MVC\View\ViewModel;
use Illuminate\Container\Container;  
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好 
use Model\User;
use Service\JwtAuth\jwtManager;
 
class PassportController
{   

    protected $reutrn_data = [];

    public function init(){
       
        
    }
    
 
    
    public function indexAction()
    {   
    

       $data =array(
        'issuer'=>1,
        'audience'=>'pay.1010shuju.com',
        'id'=>111111,
       );
       $jwtManager = jwtManager::jwt()->creatToken($data);

       var_dump($jwtManager);
        


    }

    public function checkAction()
    {
        

        //获取token
        $token = $this->params[0];

        //解析token
        $tokenInfo = (new Parser())->parse(($token)); // Parses from a string
        $tokenInfo->getHeaders(); // Retrieves the token header
        $tokenInfo->getClaims(); // Retrieves the token claims

        // echo $token->getHeader('jti'); // will print "4f1g23a12aa"
        echo $tokenInfo->getClaim('iss'); // will print "http://example.com"
        // echo $token->getClaim('uid'); // will print "1"



       
    }

 

 

}

 