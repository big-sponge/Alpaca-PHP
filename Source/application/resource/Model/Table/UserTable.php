<?php
namespace Model\Table;
 
use Model\Model\Entity;
use Model\Model\PersonalInfo;
use Model\Model\User;
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class UserTable extends AbstractTable
{

    const USER_STATUS_NORMAL = 1;   //用户状态 1-正常
    const USER_STATUS_FROZEN = 2;   //用户状态 2-禁用
    const USER_STATUS_CLOSE = 3;    //用户状态 3-注销

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
            "email" =>$loginData->login_name,
        );  

              
        
        $selectResult = $this->selectOne($selectQuery);        
        if(empty($selectResult['data']))
        {
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

    public function getUserEntityInfoByUserId($where){
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'entity' =>array(
                'name'=>'tb_entity',
                'on' =>User::TABLE_NAME.'.entity_id='.Entity::TABLE_NAME.'.entity_id',
                'columns'=>array(
                    'entity_name'=>"entity_name",
                    'entity_type'=>"entity_type",
                    'id_type'=>"id_type",
                    'id_no'=>"id_no",
                ),
            ),
            'personal_info' =>array(
                'name'=>'tb_personal_info',
                'on' =>User::TABLE_NAME.'.personal_info_id='.PersonalInfo::TABLE_NAME.'.personal_info_id',
                'columns'=>array(
                    'mobile_no'=>"mobile_no",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }
    public function getAllUserDetailInfoEdit($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'entity' =>array(
                'name'=>'tb_entity',
                'on' =>User::TABLE_NAME.'.entity_id='.Entity::TABLE_NAME.'.entity_id',
                'columns'=>array(
                    'entity_name'=>"entity_name",
                    'entity_type'=>"entity_type",
                    'id_type'=>"id_type",
                    'id_no'=>"id_no",
                ),
            ),
            'personal_info' =>array(
                'name'=>'tb_personal_info',
                'on' =>User::TABLE_NAME.'.personal_info_id='.PersonalInfo::TABLE_NAME.'.personal_info_id',
                'columns'=>array(
                    'name'=>"name",
                    'mobile_no'=>"mobile_no",
                    'checking_status'=>"checking_status",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }

    public function selectUserCheck($value)
    {
        
        try {

                $returnData=array();
                $returnData["return_code"]=1;
                $returnData["return_data"]=[];

                $tableResult=$this->sql("select * from tb_user as a left JOIN tb_virtual_account as b
                                     on a.entity_id = b.entity_id where a.email='$value'");
                $resultData = $tableResult["data"]->toArray();

                if (empty($resultData[0])) {
                    $returnData["return_code"] = 0;
                    return $returnData;
                }

                $returnData["return_data"] = $resultData[0];

                return $returnData;

    
        } catch (Exception $e) {
            
            $returnData["return_code"] = 0;
            return $returnData;

        }

 


        


    }

}