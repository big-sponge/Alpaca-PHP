<?php
namespace Index\Form;
use Service\JwtAuth\JwtManager;
use Alpaca\MVC\Form\AlpacaForm;
use Model\User;
use Model\Relation;
use Model\Domain;
use Illuminate\Database\Capsule\Manager as DB;

class PassportForm extends AlpacaForm
{
    public function bindAccount($post)
    {
        $return_data = array();
        $return_data["return_code"] = 0;
        
        $checkData = $this->checkBindAccount($post);       
        if ($checkData['return_code'] != 1) {
            return $checkData;
        }
                    
        $bind_user_name = $post['bind_user_name'];
        $bind_user_domain = $post['bind_user_domain'];
        $be_bind_user_name = $post['be_bind_user_name'];
        $be_bind_user_domain = $post['be_bind_user_domain'];
        
        // 1插入用户信息
        $relationData = Relation::where("bind_account", $bind_user_name)->first();        
        $user_id = 0;
        if (empty($relationData)) {
            $user_array = array(
                "user_name" => $bind_user_name
            );
            $user_result = User::insertUser($user_array);
            
            if (! empty($user_result["return_code"])) {
                $user_id = $user_result["return_inserId"];
            }
        } else {
            $user_id = $relationData->relation_account;
        }
        DB::beginTransaction();
        
        // 2插入绑定网站
        $domain_array = array(
            "domain" => $bind_user_domain,
            "descriptions" => "介绍"
        );
        $bind_result = Domain::insertDomain($domain_array);
        
        // 2.1插入绑定网站
        $domain_array = array(
            "domain" => $be_bind_user_domain,
            "descriptions" => "介绍"
        );
        $be_bind_result = Domain::insertDomain($domain_array);
        
        // 3插入关联
        $relation_array = array(
            "relation_account" => $user_id,
            "bind_account" => $bind_user_name,
            "domain_id" => empty($bind_result["return_inserId"]) ? 0 : $bind_result["return_inserId"]
        );
        $bind_relation_result = Relation::insertRelation($relation_array);
        
        // 3.1插入关联
        $relation_array = array(
            "relation_account" => $user_id,
            "bind_account" => $be_bind_user_name,
            "domain_id" => empty($be_bind_result["return_inserId"]) ? 0 : $be_bind_result["return_inserId"]
        );
        $be_bind_relation_result = Relation::insertRelation($relation_array);
        
        // 4 判断结果
        if (empty($bind_result["return_code"]) || empty($be_bind_result["return_code"]) || empty($bind_relation_result["return_code"]) || empty($be_bind_relation_result["return_code"])) {
            DB::rollBack();
            $return_data["return_message"] = json_encode($bind_result) . json_encode($be_bind_result) . json_encode($bind_relation_result) . json_encode($be_bind_relation_result);
        } else {
            DB::commit();
            $return_data["return_code"] = 1;
        }
        
        return $return_data;        
    }
    
    private function checkBindAccount($data)
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



    public function createJwt($data)
    {   
        $return_data = array();
        if (empty($data)||empty($data[0])) {
            $return_data['return_code'] = 0;
            $return_data['return_message'] = "账户必须填写";
            return View::json($return_data); 
        }

        $user_name = $data[0];
        $data =array(
            'issuer'=> $user_name,
            'audience'=>$_SERVER["HTTP_HOST"],
            'id'=>mt_rand(0,100000)*mt_rand(0,100000),
        );

        $user_data = User::where('user_name',$user_name);

        $token = JwtManager::jwt()->creatToken($data);
        $toekn = $token->getToeknString();
        
        $return_data['return_code'] = 1;
        $return_data['return_message'] = "生成成功";
        $return_data['return_toekn'] = $toekn;
        $return_data['return_bind_domain']="";
        return $return_data;
    }

    public function parserJwt($token)
    {   

        $return_data = array();

        $tokenInfo = jwtManager::jwt()->parserToekn($token);

        if (!$tokenInfo) {
            $return_data['return_code'] = 0;
            $return_data['return_message'] = "token不存在或者过期";
            return $return_data;
        }

        $return_data['return_code'] = 1;
        $return_data['return_message'] = "登录中";
        $return_data['return_user_name'] = $tokenInfo->getClaim('iss');

        return $return_data;
    }
}

