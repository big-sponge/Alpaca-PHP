<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;



// ZEND DB 中文教程 

// http://zend-framework-2.yangfanweb.cn/blog/381
 
class GroupBillTable extends AbstractTable
{

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    //监管账户记账-子账户转子账户
    public function addBillV2V($data)
    {        
        $result["state"] = "1";
        $result["msg"] = "操作成功";
        $result["errorMsg"] ="";
        
        
        $groupBillInsert["set"] = array(
            "group_account_id" => $data->group_account_id,
            "group_serial_number" => "",
            "trade_time" => date("Y-m-d H:i:s", time()),
            "trade_type" => $data->trade_type,
            "amount" => $data->trade_amount,
            "account_balance" => '1',
            "opposite_account_no" => $data->relation_account_no,
            "opposite_account_name" => $data->relation_account_name,
            "direction" => '2',
            "usage" => ""
        );
        $groupBillInsertResult = $this->insert($groupBillInsert);
        $result["state"] = $result["state"] && $groupBillInsertResult["state"];
        $result["msg"] = $result["msg"]."添加监管账户表账目表".$groupBillInsertResult["msg"].";";
        $result["errorMsg"] = $result["errorMsg"]."添加监管账户表账目表".$groupBillInsertResult["errorMsg"].";";
        
        $groupBillInsertPayee["set"] = array(
            "group_account_id" => $data->group_account_id,
            "group_serial_number" => "",
            "trade_time" => date("Y-m-d H:i:s", time()),
            "trade_type" => $data->trade_type,
            "amount" => $data->trade_amount,
            "account_balance" => '1',
            "opposite_account_no" => $data->relation_account_no,
            "opposite_account_name" => $data->relation_account_name,
            "direction" => '1',
            "usage" => ""
        );
        $groupBillInsertResultPayee = $this->insert($groupBillInsertPayee);
        $result["state"] = $result["state"] && $groupBillInsertResultPayee["state"];
        $result["msg"] = $result["msg"]."添加监管账户表账目表".$groupBillInsertResultPayee["msg"].";";
        $result["errorMsg"] = $result["errorMsg"]."添加监管账户表账目表".$groupBillInsertResultPayee["errorMsg"].";";
        
        return $result;
    }
    
    //监管账户记账-子账户转实体账户
    public function addBillV2A($data)
    {
        $groupBillInsert["set"] = array(
            "group_account_id" => $data->group_account_id,
            "group_serial_number" => "11",
            "trade_time" => date("Y-m-d H:i:s", time()),
            "trade_type" => $data->trade_type,
            "amount" => $data->trade_amount,
            "account_balance" => $data->group_account_balance,
            "opposite_account_no" => $data->payee_account_no,
            "opposite_account_name" => $data->payee_account_name,
            "direction" => '2',
            "usage" => ""
        );
        $groupBillInsertResult = $this->insert($groupBillInsert);        
        return $groupBillInsertResult;
    }
}