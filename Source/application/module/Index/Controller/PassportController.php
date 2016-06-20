<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;
use Service\JwtAuth\JwtManager;
use Alpaca\Tools\Validate;
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
        
        $checkData = $this->checkPost($_POST);

        if ($checkData['return_code'] != 1) {
           return View::json($checkData);
        }
        
        $form = $this->sm->form('Index\Form\PassportForm');
        $data = $form->bindAccount($_POST);

        return View::json($data);
    }

    private function checkPost($data)
    {   

        $return_data = array();
        $return_data['return_code'] = 0;

        if (empty($data['bind_user_name'])) {
            $return_data['return_message'] = "bind_user_name不能为空";
            return $return_data;
        } 
        if (empty($data['bind_user_domain'])) {
            $return_data['return_message'] = "bind_user_domain不能为空";
            return $return_data; 
        } 
        if (empty($data['be_bind_user_name'])) {
            $return_data['return_message'] = "be_bind_user_name不能为空";
            return $return_data; 
        }
        if (empty($data['be_bind_user_domain'])) {
            $return_data['return_message'] = "be_bind_user_domain不能为空";
            return $return_data;
        }
        $return_data['return_code'] =1;
        return $return_data;

    }
   
}

 