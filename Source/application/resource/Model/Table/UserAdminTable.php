<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class UserAdminTable extends AbstractTable
{

 	public $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    public function login($loginData)
    {
        $result=array(
            "state"=>"1",
            "code"=>"1",
            "msg" => "SUCCESS",
            "data" => null,
        );

        $selectQuery["where"] = array(
            "admin_email" =>$loginData->admin_email,
        );

        $selectResult = $this->selectOne($selectQuery);
        if(empty($selectResult['data']))
        {

            if ($loginData->admin_email == "admin") 
            {
                $this->inserAccount($loginData->admin_email,'$2y$10$qoTgeL4y5plEc/eBQH9ecOsQcJ9pEpCRvsT81VzV7o9g3dmkxilYK',1);
            }

            $result["state"]='0';
            $result["code"]='2';
            $result["msg"]='失败：用户名不存在';
            return $result;
        }

        if(!password_verify($loginData->login_password,$selectResult['data']->login_password)){
            $result["state"]='0';
            $result["code"]='3';
            $result["msg"]='失败：密码不正确';
            return $result;
        }

        $selectResult['data']->login_password="#";
        $selectResult['data']->pay_password="#";

        $result["state"]='1';
        $result["code"]='1';
        $result["msg"]='登录成功';
        $result["data"]=$selectResult['data'];
        return $result;
    } 


    //"$2y$10$qoTgeL4y5plEc/eBQH9ecOsQcJ9pEpCRvsT81VzV7o9g3dmkxilYK"
    public function inserAccount($admin_email,$password,$role)
    {
        
        $inserData["set"] = array(
                    "admin_email" =>$admin_email,
                    "admin_name" => "系统管理员",
                    "login_password" =>$password,
                    "role"=>$role,
                    "registration_time"=>date('Y-m-d H:i:s'),
                    "last_login_time" => date('Y-m-d H:i:s'),
                );

        return $this->insert($inserData);
    }   
}