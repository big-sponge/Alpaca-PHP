<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
use Model\Model\VirtualAccount;
use Model\Model\GroupAccount;
use Model\Model\RelationAccount;
use Model\Model\VirtualEngine;
use Model\Model\BankAccount;
 
class VirtualAccountTable extends AbstractTable
{    
    const BALANCE_INCREASE = 1;           //入金，收款
    const BALANCE_DECREASE = 2;           //出金，付款
    
    const ACCOUNT_TYPE_PERSONAL = 1;      //账户类型-个人账户
    const ACCOUNT_TYPE_FIRM = 2;          //账户类型-公司账户
    const ACCOUNT_TYPE_PROFIT = 3;        //账户类型-内部账户-结息账户
    const ACCOUNT_TYPE_FREEZE = 4;        //账户类型-内部账户-冻结账户
    const ACCOUNT_TYPE_UNKNOWN = 5;       //账户类型-内部账户-不明款项
    
    const ACCOUNT_STATUS_NORMAL = 1;       //账户状态-正常
    const ACCOUNT_STATUS_FREEZE = 2;       //账户状态-冻结
    const ACCOUNT_STATUS_CLOSE = 3;       //账户状态-销户
    const ACCOUNT_STATUS_INACTIVE= 4;       //账户状态-未激活
    
        
 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
        
    //新建子账户
    public function create($data)
    {   
        
        //4.写入子账户表
        $insertQuery["set"]= array(
            'virtual_account_name'=>$data->virtual_account_name,
            'virtual_account_no'=>$data->virtual_account_no,
            'virtual_account_type'=>$data->virtual_account_type,
            'group_account_id'=>$data->group_account_id,
            'total_balance'=>'0',
            'available_balance'=>'0',
            'freeze_amount'=>'0',
            'id_type'=>$data->id_type,
            'id_no'=>$data->id_no,
            'id_file_path'=>"",
            'usage'=>$data->usage,
            'open_time'=>date("Y-m-d H:m:s",time()),
            'close_time'=>'',
            'active_time'=>'',
            'status'=>'1',
            'bank_account_id'=>'0',
            'entity_id'=>$data->entity_id,
        );
               
        return $this->insert($insertQuery);
    }
        
    //通过子账户账号获取子账户ID
    public function getIdByNo($virtual_account_no)
    {
        $selectQuery["where"] = array(
            "virtual_account_no"=>$virtual_account_no,
        );
        $result = $this->selectOne($selectQuery);
        if($result["data"] !=null){
            return $result["data"]->virtual_account_id;
        }else{
            return 0;
        }
    }
    
    //查找子账户详情  - 归属的监管账户、关联账户、虚拟引擎
    public function getVirtualAccountDetail($where)
    {               
        $result["result_code"] = "1";
        $result["result_message"] = "查找成功";
        
        $selectQuery= array();         
        $selectQuery["join"]  = array(
            'bank_account' =>array(
                'name'=>'tb_bank_account',
                'on' =>VirtualAccount::TABLE_NAME.'.bank_account_id='.BankAccount::TABLE_NAME.'.bank_account_id',
                'columns'=>array(
                    'bank_account_no'=>"bank_account_no",
                ),
            ),            
            'group_account' =>array(
                'name'=>'tb_group_account',
                'on' =>VirtualAccount::TABLE_NAME.'.group_account_id='.GroupAccount::TABLE_NAME.'.group_account_id',
                'columns'=>array(
                    'group_account_no'=>"group_account_no",
                    'group_account_name'=>"group_account_name",
                    'open_bank'=>"open_bank",
                    'open_bank_branch'=>"open_bank_branch",
                    'cl_ring_no'=>"cl_ring_no",
                    'balance'=>"balance",
                    'group_entity_id'=>"entity_id",
                ),
            ),
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
            $result["result_message"] = "子账户不存在";
            return $result;
        }
        
        if(empty($resultSelect["data"]->group_account_no)){
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
    
    //修改子账户余额   
    public function updateBalance($virtual_account_no,$amount,$direction)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "total_balance"=>"0",
            "available_balance"=>"0",
        );

        $tableResult=$this->sql("SELECT * from tb_virtual_account where `virtual_account_no`='".$virtual_account_no."'for UPDATE");
        $virtualAccount = $tableResult["data"]->toArray()[0];

        if($direction == self::BALANCE_INCREASE)
        {
            $total_balance = $virtualAccount["total_balance"] + $amount;
            $available_balance = $virtualAccount["available_balance"] + $amount;
        }else{
            $total_balance = $virtualAccount["total_balance"] - $amount;
            $available_balance = $virtualAccount["available_balance"] - $amount;
           
            if($total_balance < 0 || $available_balance <0)
            {
                $result["state"]=0;
                $result["msg"]="FAILED";
                $result["errorMsg"]="可用余额不足";
                return $result;
            }
        }
        
        $result["total_balance"]=$total_balance;
        $result["available_balance"]=$available_balance;
        
        $virtualAccountUpdate["set"] = array(
            "total_balance" => $total_balance,
            "available_balance" => $available_balance,
        );
        
        $virtualAccountUpdate["where"] = array(
            "virtual_account_no" =>$virtual_account_no,
        );
        $updateResult = $this->update($virtualAccountUpdate);
        
        if($updateResult["state"] != 1)
        {
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]= $updateResult["errorMsg"];
        }
        
        return $result;
    }   
       
    //子账户余额-冻结
    public function freezeBalance($virtual_account_no,$amount)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "total_balance" => 0,
            "available_balance" => 0,
        );
    
        $tableResult=$this->sql("SELECT * from tb_virtual_account where `virtual_account_no`='".$virtual_account_no."'for UPDATE");
        $virtualAccount = $tableResult["data"]->toArray()[0];
    
        $available_balance = $virtualAccount["available_balance"] - $amount;
        $freeze_amount = $virtualAccount["freeze_amount"] + $amount;
        
        if ($available_balance < 0) {
            $result["state"] = 0;
            $result["msg"] = "FAILED:可用余额不足";
            $result["errorMsg"] = "可用余额不足";
            return $result;
        }
               
        $virtualAccountUpdate["set"] = array(
            "available_balance" => $available_balance,
            "freeze_amount" => $freeze_amount,
        );
    
        $virtualAccountUpdate["where"] = array(
            "virtual_account_no" =>$virtual_account_no,
        );
        
        $updateResult = $this->update($virtualAccountUpdate);
    
        if($updateResult["state"] != 1)
        {
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]= $updateResult["errorMsg"];
        }
    
        return $result;
    }
    
    //子账户余额-解冻到余额
    public function unfreezeToBalance($virtual_account_no,$amount)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "total_balance" => 0,
            "available_balance" => 0,
        );
    
        $tableResult=$this->sql("SELECT * from tb_virtual_account where `virtual_account_no`='".$virtual_account_no."'for UPDATE");
        $virtualAccount = $tableResult["data"]->toArray()[0];
    
        $available_balance = $virtualAccount["available_balance"] + $amount;
        $freeze_amount = $virtualAccount["freeze_amount"] - $amount;
    
        if ($freeze_amount < 0) {
            $result["state"] = 0;
            $result["msg"] = "FAILED";
            $result["errorMsg"] = "冻结金额不匹配";
            return $result;
        }
    
        $result["total_balance"] = $virtualAccount["total_balance"];
        $result["available_balance"] = $available_balance;
        
        $result["total_balance"] = $virtualAccount["total_balance"];
        $result["available_balance"] = $available_balance;
        
        $virtualAccountUpdate["set"] = array(
            "available_balance" => $available_balance,
            "freeze_amount" => $freeze_amount,
        );
    
        $virtualAccountUpdate["where"] = array(
            "virtual_account_no" =>$virtual_account_no,
        );
        $updateResult = $this->update($virtualAccountUpdate);
    
        if($updateResult["state"] != 1)
        {
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]= $updateResult["errorMsg"];
        }
    
        return $result;
    }
    
    //子账户余额-解冻到付款
    public function unfreezeToPay($virtual_account_no,$amount)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "total_balance" => 0,
            "available_balance" => 0,
        );
    
        $tableResult=$this->sql("SELECT * from tb_virtual_account where `virtual_account_no`='".$virtual_account_no."'for UPDATE");
        $virtualAccount = $tableResult["data"]->toArray()[0];    
        $freeze_amount = $virtualAccount["freeze_amount"] - $amount;
        $total_balance = $virtualAccount["total_balance"] - $amount;
    
        if ($freeze_amount < 0) {
            $result["state"] = 0;
            $result["msg"] = "FAILED";
            $result["errorMsg"] = "冻结金额不匹配";
            return $result;
        }

        $result["total_balance"] = $total_balance;
        $result["available_balance"] = $virtualAccount["available_balance"];
        
        $virtualAccountUpdate["set"] = array(
            "freeze_amount" => $freeze_amount,
        );
    
        $virtualAccountUpdate["where"] = array(
            "virtual_account_no" =>$virtual_account_no,
        );
        $updateResult = $this->update($virtualAccountUpdate);
    
        if($updateResult["state"] != 1)
        {
            $result["state"]=0;
            $result["msg"]="FAILED";
            $result["errorMsg"]= $updateResult["errorMsg"];
        }    
        return $result;
    }

    //是否有权限操作该子账户
    public function checkAuthority($virtual_account_no,$entity_id)
    {
        $resultCheck= array();
        $selectQuery["where"] = array(
            "virtual_account_no"=>$virtual_account_no,
            "entity_id"=>$entity_id,
        );
        $result = $this->selectOne($selectQuery);
        if($result["data"] !=null){            
            $resultCheck["result_code"]="1";
        }else{
            $resultCheck["result_code"]="0";
            $resultCheck["result_message"]="没有权限操作该账户";
        }
        
        return $resultCheck;
    }        

    //查询用户下所有子账户的详细信息、监管账户、关联账户、绑定的银行账户等
    public function getVirtualAccounts($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;
    
        $selectQuery= array();
        $selectQuery["join"]  = array(
            'bank_account' =>array(
                'name'=>'tb_bank_account',
                'on' =>VirtualAccount::TABLE_NAME.'.bank_account_id='.BankAccount::TABLE_NAME.'.bank_account_id',
                'columns'=>array(
                    'bank_account_no'=>"bank_account_no",
                    'bc_open_bank'=>"open_bank",
                    'bc_open_bank_branch'=>"open_bank_branch",
                    'bc_cl_ring_no'=>"cl_ring_no",
                ),
            ),
            'group_account' =>array(
                'name'=>'tb_group_account',
                'on' =>VirtualAccount::TABLE_NAME.'.group_account_id='.GroupAccount::TABLE_NAME.'.group_account_id',
                'columns'=>array(
                    'group_account_no'=>"group_account_no",
                    'group_account_name'=>"group_account_name",
                ),
            ),
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

    //查询子账户的详细信息、监管账户、绑定的银行账户
    public function getVirtualAccountDetailForAdminEdit($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'bank_account' =>array(
                'name'=>'tb_bank_account',
                'on' =>VirtualAccount::TABLE_NAME.'.bank_account_id='.BankAccount::TABLE_NAME.'.bank_account_id',
                'columns'=>array(
                    'bank_account_no'=>"bank_account_no",
                    'bank_account_name'=>"bank_account_name",
                    'bank_account_type'=>"bank_account_type",
                    'bc_open_bank'=>"open_bank",
                    'bc_open_bank_branch'=>"open_bank_branch",
                    'bc_bind_time'=>"bind_time",                   
                ),
            ),
            'group_account' =>array(
                'name'=>'tb_group_account',
                'on' =>VirtualAccount::TABLE_NAME.'.group_account_id='.GroupAccount::TABLE_NAME.'.group_account_id',
                'columns'=>array(
                    'group_account_name'=>"group_account_name",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }
}