<?php
namespace Model\Table;

use Model\Model\Entity;
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
use Model\Model\RelationAccount;
use Model\Model\GroupAccount;
use Model\Model\VirtualEngine;

// ZEND DB 中文教程
// http://zend-framework-2.yangfanweb.cn/blog/381
 
class GroupAccountTable extends AbstractTable
{
    const BALANCE_INCREASE = 1;     //入金，收款
    const BALANCE_DECREASE = 2;     //出金，付款

    const ACCOUNT_STATUS_NORMAL = 1;   //账户状态 1-正常
    const ACCOUNT_STATUS_FROZEN = 2;   //账户状态 2-冻结
    const ACCOUNT_STATUS_CLOSE = 3;    //账户状态 3-销户

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    //通过监管账户账号获取监管账户ID
    public function getIdByNo($group_account_no)
    {
        $selectQuery["where"] = array(
            "group_account_no"=>$group_account_no,
        );
        $result = $this->selectOne($selectQuery);
        if($result["data"] !=null){
            return $result["data"]->group_account_id;
        }else{
            return 0;
        }
    }
        
    //修改监管账户余额
    public function updateBalance($group_account_no,$amount,$direction)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "balance"=>"0",
        );
    
        $tableResult=$this->sql("SELECT * from tb_group_account where `group_account_no`='".$group_account_no."'for UPDATE");
        
        $resultData = $tableResult["data"]->toArray();
                
        if(empty($resultData)){
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]="监管账户不存在[".$group_account_no."]!";
            return $result;
        }
        
        $groupAccount = $resultData[0];

        if($direction == self::BALANCE_INCREASE)
        {
            $balance = $groupAccount["balance"] + $amount;
        }else{
            $balance = $groupAccount["balance"] - $amount;             
            if($balance < 0)
            {
                $result["state"]=0;
                $result["msg"]="FAILED";
                $result["errorMsg"]="可用余额不足";
                return $result;
            }

        }

        $result["balance"]=$balance;
        
        $groupAccountUpdate["set"] = array(
            "balance" => $balance,
        );
    
        $groupAccountUpdate["where"] = array(
            "group_account_no" =>$group_account_no,
        );
        $updateResult = $this->update($groupAccountUpdate);
    
        if($updateResult["state"] != 1)
        {
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]= $updateResult["errorMsg"];
        }
    
        return $result;
    }
        
    //获取监管账户详细，关联账户、虚拟引擎等   
    public function getGroupAccountDetail($where)
    {
        $result["result_code"] = "1";
        $result["result_message"] = "查找成功";
        
        $selectQuery= array();
        $selectQuery["join"]  = array(
            'relation_account' =>array(
                'name'=>'tb_relation_account',
                'on' =>RelationAccount::TABLE_NAME.'.relation_account_id='.GroupAccount::TABLE_NAME.'.relation_account_id',
                'columns'=>array(
                    'relation_account_no'=>"relation_account_no",
                    'relation_account_name'=>"relation_account_name",
                ),
            ),
            'virtual_engine' =>array(
                'name'=>'tb_virtual_engine',
                'on' =>VirtualEngine::TABLE_NAME.'.group_account_id='.GroupAccount::TABLE_NAME.'.group_account_id',
                'columns'=>array(
                    'ip'=>"ip",
                    'port'=>"port",
                    'url'=>"url",
                ),
            ),
        );
        
        $selectQuery["where"] = $where;
        $resultSelect = $this->selectOne($selectQuery);

        if($resultSelect["data"] == null){
            $result["result_code"] = "2";
            $result["result_message"] = "监管账户不存在";
            return $result;
        }
                
        if(empty($resultSelect["data"]->ip)){
            $result["result_code"] = "2";
            $result["result_message"] = "子账户引擎IP为空";
            return $result;
        }
        
        $result["result_code"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"] = $resultSelect["data"];
        return $result;
    }

    //查询用户下所有监管账户的详细信息、关联账户
    public function getGroupAccounts($where)
    {    
        $selectQuery= array();
        $selectQuery["join"]  = array(
            'relation_account' =>array(
                'name'=>'tb_relation_account',
                'on' =>RelationAccount::TABLE_NAME.'.relation_account_id='.GroupAccount::TABLE_NAME.'.relation_account_id',
                'columns'=>array(
                    'relation_account_no'=>"relation_account_no",
                    'relation_account_name'=>"relation_account_name",
                ),
            ),
        );
    
        $selectQuery["where"] = $where;

 

        return $this->select($selectQuery);
    }

    /**
     * 检索监管账户 如果不存在的话则插入一条新的
     * @param $data
     * @return $id
     */
    public function create($data)
    {
        $id = 0;

        $selectQuery["where"]=array(
            'group_account_name' => $data->group_account_name,
            'group_account_no' => $data->group_account_no,
            'entity_id' => $data->entity_id
        );

        $insertQuery["set"]=array(
            "group_account_name" => $data->group_account_name,
            "group_account_no" => $data->group_account_no,
            "balance" => $data->balance,
            "status" => $data->status,
            "open_bank" => $data->open_bank,
            "open_bank_branch" => $data->open_bank_branch,
            "cl_ring_no" => $data->cl_ring_no,
            "id_type" => $data->id_type,
            "id_no" => $data->id_no,
            "id_file_path" => $data->id_file_path,
            "relation_account_id" => $data->relation_account_id,
            "entity_id" => $data->entity_id
        );

        $result = $this->selectOrInsert($selectQuery,$insertQuery);

        if(!empty($result['created'])){
            $id = $result['insertId'];
        }else if(!empty($result['data'])){
            $id = $result['data']->group_account_id;
        }

        return $id;
    }

    //查询监管账户的详细信息、监管账户、关联账户、实体信息
    public function getGroupAccountDetailForAdminEdit($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'entity' =>array(
                'name'=>'tb_entity',
                'on' =>GroupAccount::TABLE_NAME.'.entity_id='.Entity::TABLE_NAME.'.entity_id',
                'columns'=>array(
                    'entity_name'=>"entity_name",
                    'entity_type'=>"entity_type",
                    'entity_id_type'=>"id_type",
                    'entity_id_no'=>"id_no",
                    'register_time'=>"register_time",
                ),
            ),
            'relation_account' =>array(
                'name'=>'tb_relation_account',
                'on' =>GroupAccount::TABLE_NAME.'.relation_account_id='.RelationAccount::TABLE_NAME.'.relation_account_id',
                'columns'=>array(
                    'relation_account_name'=>"relation_account_name",
                    'relation_account_no'=>"relation_account_no",
                    'relation_status'=>"status",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }

}