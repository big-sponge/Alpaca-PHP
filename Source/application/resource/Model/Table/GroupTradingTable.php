<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
use Model\Model\GroupAccount;
use Model\Model\GroupTrading;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Operator;
 
class GroupTradingTable extends AbstractTable
{

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    public function test()
    {
        echo "GroupTradingTable OK";
    }
    
    //子账户内部转账
    public function addTradingV2V($data)
    {
        $result["state"] = '1';
        $result["msg"] = "操作成";
        $result["errorMsg"] ="";
        
        $groupTradingInsert["set"] = array(
            "group_serial_number" => "888",
            "virtual_serial_number" => $data->virtual_serial_number,
            "payer_account_no" => $data->group_account_no,
            "payer_account_name" => $data->group_account_name,
            "payer_bank" => $data->payer_bank,
            "payer_bank_branch" => $data->payer_bank_branch,
            "payer_cl_ring_no" => $data->payer_cl_ring_no,
            "payee_account_name" => $data->relation_account_name,
            "payee_account_no" => $data->relation_account_no,
            "payee_bank" => $data->payee_bank,
            "payee_bank_branch" => $data->payee_bank_branch,
            "payee_cl_ring_no" => $data->payee_cl_ring_no,
            "trade_type" => $data->trade_type,
            "trade_way" => $data->trade_way,
            "trade_status" => '4',
            "trade_usage" => "", // ???接口中缺少usage
            "trade_start_time" => date("Y-m-d H:i:s", time()),
            "trade_end_time" => '',
            "trade_amount" => $data->trade_amount,
            "freeze_period" => $data->freeze_period,
            "fee" => '',
            "message" => ""
        );
        $groupTradingInserteResult = $this->insert($groupTradingInsert);
        $result["state"] = $result["state"] && $groupTradingInserteResult["state"];
        $result["msg"] = $result["msg"]."添加监管账户交易记录 ".$groupTradingInserteResult["msg"].";";
        $result["errorMsg"] = $result["errorMsg"]."添加监管账户交易记录".$groupTradingInserteResult["errorMsg"].";";
        
        $groupTradingInsert["set"] = array(
            "group_serial_number" => "888",
            "virtual_serial_number" => $data->virtual_serial_number,
            "payer_account_no" => $data->relation_account_no,
            "payer_account_name" => $data->relation_account_name,
            "payer_bank" => $data->payer_bank,
            "payer_bank_branch" => $data->payer_bank_branch,
            "payer_cl_ring_no" => $data->payer_cl_ring_no,
            "payee_account_name" => $data->group_account_name,
            "payee_account_no" => $data->group_account_no,
            "payee_bank" => $data->payee_bank,
            "payee_bank_branch" => $data->payee_bank_branch,
            "payee_cl_ring_no" => $data->payee_cl_ring_no,
            "trade_type" => $data->trade_type,
            "trade_way" => $data->trade_way,
            "trade_status" => '4',
            "trade_usage" => "", // ???接口中缺少usage
            "trade_start_time" => date("Y-m-d H:i:s", time()),
            "trade_end_time" => '',
            "trade_amount" => $data->trade_amount,
            "freeze_period" => $data->freeze_period,
            "fee" => '',
            "message" => ""
        );
        $groupTradingInserteResult = $this->insert($groupTradingInsert);
        
        $result["state"] = $result["state"] && $groupTradingInserteResult["state"];
        $result["msg"] = $result["msg"]."添加监管账户交易记录 ".$groupTradingInserteResult["msg"].";";
        $result["errorMsg"] = $result["errorMsg"]."添加监管账户交易记录".$groupTradingInserteResult["errorMsg"].";";
        
        return $result;
    }
    
    //子账户转实体银行账户
    public function addTradingV2A($data)
    {
        $groupTradingInsert["set"] = array(
            "group_serial_number" => "888",
            "virtual_serial_number" => $data->virtual_serial_number,
            "payer_account_no" => $data->group_account_no,
            "payer_account_name" => $data->group_account_name,
            "payer_bank" => '',
            "payer_bank_branch" => '',
            "payer_cl_ring_no" => '',
            "payee_account_name" => $data->payee_account_name,
            "payee_account_no" => $data->payee_account_no,
            "payee_bank" => $data->payee_bank,
            "payee_bank_branch" => $data->payee_bank_branch,
            "payee_cl_ring_no" => $data->payee_cl_ring_no,
            "trade_type" => $data->trade_type,
            "trade_way" => $data->trade_way,
            "trade_status" => '4',
            "trade_usage" => "", // ???接口中缺少usage
            "trade_start_time" => date("Y-m-d H:i:s", time()),
            "trade_end_time" => '',
            "trade_amount" => $data->trade_amount,
            "freeze_period" => $data->freeze_period,
            "fee" => '',
            "message" => ""
        );
        $groupTradingInserteResult = $this->insert($groupTradingInsert);
        return $groupTradingInserteResult;
    }

    //获取用户下所有账户的交易记录
    public function getAllUserTradingInfo($data)
    {
        
        $page = !empty($data->page)? intval($data->page) : 1;
        $rows = !empty($data->rows)? intval($data->rows) : 10;
        $sort = !empty($data->sort)? $data->sort : 'group_trading_id';
        $order = !empty($data->order)? $data->order : 'desc';
             
        $pagedQuery= array();
        $pagedQuery["join"]  = array(
            'virtual_account' =>array(
                'name'=>'tb_group_account',
                'on' => GroupTrading::TABLE_NAME.'.payer_account_no='.GroupAccount::TABLE_NAME.'.group_account_no',
                'columns'=>array(
                    'entity_id'=>"entity_id",
                ),
            ),
        );
    
        $where= new Where();
        $where->andPredicate(new Operator("entity_id", Operator::OP_EQ, $data->entity_id));
    
        if (!empty($data->payer_account_no)) {
            $where->andPredicate(new Operator("payer_account_no", Operator::OP_EQ, $data->payer_account_no));
        }
    
        if (!empty($data->trade_status)) {
            $where->andPredicate(new Operator("trade_status", Operator::OP_EQ, $data->trade_status));
        }
    
        $pagedQuery["where"] = $where;
         
        $pagedQuery["paged"] =array('page'=>$page,'size'=>$rows);
    
        if($sort=="trade_status_text"){
            $sort="trade_status";
        }
    
        $pagedQuery["order"] =array('order'=>array('sort'=>$sort,'order'=>$order));
    
        return $this->selectPaged($pagedQuery);
    }

}