<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;
use Service\JwtAuth\JwtManager;
use Alpaca\Tools\Validate;
class PassportController
{   

    protected $return_data = [];
    
    protected $request_data = [];

    public function init()
    {
        $this->dataFilter();
    }
   
    //处理POST数据
    private function dataFilter()
    {        
        if(empty($_POST)){
            return;
        }
        foreach ($_POST as $name => $value){
            $this->request_data[$name] = addslashes(htmlspecialchars(trim($value)));
        }

    }
     
    public function indexAction()
    {       
        
        if (empty($this->params)||empty($this->params[0])) {
            $this->return_data['return_code'] = 0;
            $this->return_data['return_message'] = "账户必须填写";
            return View::json($this->return_data); 
        }

        $user_name = $this->params[0];
        $data =array(
            'issuer'=> $user_name,
            'audience'=>$_SERVER["HTTP_HOST"],
            'id'=>mt_rand(0,100000)*mt_rand(0,100000),
        );

        $user_data = User::where('user_name',$user_name);

        $token = JwtManager::jwt()->creatToken($data);
        $toekn = $token->getToeknString();
        
        $this->return_data['return_code'] = 1;
        $this->return_data['return_message'] = "生成成功";
        $this->return_data['return_toekn'] = $toekn;
        $this->return_data['return_bind_domain']="";

        return View::json($this->return_data);
    }

    public function checkAction()
    {        
        //获取token
        $token = $_GET['token'];
        $tokenInfo = jwtManager::jwt()->parserToekn($token);

        if (!$tokenInfo) {
            $this->return_data['return_code'] = 0;
            $this->return_data['return_message'] = "token不存在或者过期";
            return View::json($this->return_data);
        }

        $this->return_data['return_code'] = 1;
        $this->return_data['return_message'] = "登录中";
        $this->return_data['return_user_name'] = $tokenInfo->getClaim('iss');

        return View::json($this->return_data);
    }
    public function bindAccountAction()
    {
        return View::html();
    }
    
    public function postbindAccountAction()
    {   
        $form = $this->sm->form('Index\Form\PassportForm');
        $data = $form->bindAccount($this->request_data);
        return View::json($data);
    }
  
}

 