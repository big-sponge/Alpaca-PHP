<?php
namespace Index\Controller;

use Alpaca\MVC\View\View;
use Service\JwtAuth\JwtManager;
use Model\User;
use Model\Relation;
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

        $bind_user_name = $_POST['bind_user_name'];
        $bind_user_domain = $_POST['bind_user_domain'];
        $be_bind_user_name = $_POST['be_bind_user_name'];
        $be_bind_user_domain = $_POST['be_bind_user_domain'];

        $relationData = Relation::where("bind_account",$bind_user_name)->first();
        $user_id;
        if (empty($relationData)) {
            $User = new User();
            $User->user_name = $bind_user_name;
            $user_id = empty($User->save())?0:$User->id;

            


        }else{



       }

        return View::html();
    }
   
}

 