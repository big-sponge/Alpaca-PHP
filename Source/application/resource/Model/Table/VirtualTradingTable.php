<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
use Model\Model\VirtualTrading;
use Model\Model\VirtualAccount;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Operator;


// ZEND DB 中文教程 

// http://zend-framework-2.yangfanweb.cn/blog/381
 
class VirtualTradingTable extends AbstractTable
{
    const TRADING_STATUS_SUCCEED= 1;     //1-成功
    const TRADING_STATUS_FAILED = 2;     //2-失败
    const TRADING_STATUS_FROZEN = 3;     //3-冻结中
    const TRADING_STATUS_INIT = 4;       //4-初始化
    
 	public  $tableGateway;	
 	
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    
    //改变子账户交易状态
    public function changeTradingStatus($virtual_serial_number,$tradingStatus)
    {
        $result=array(
            "state"=>"1",
            "count" => "0",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );        
        
        $tableResult=$this->sql("SELECT * from tb_virtual_trading where `virtual_serial_number`='".$virtual_serial_number."'for UPDATE");
        $resultData = $tableResult["data"]->toArray();
        if (empty($resultData)) {
            $result["state"] = "0";
            $result["msg"] = "FAILED";
            $result["errorMsg"] = "子账户交序列号:[" . $virtual_serial_number . "]不存在";
            return $result;
        }
        
        if ($resultData[0]['trade_status'] == $tradingStatus) {
            $result["state"] = "0";
            $result["msg"] = "FAILED";
            $result["errorMsg"] = "子账户交序列号:[" . $virtual_serial_number . "]交易状态已经改变";
            return $result;
        }
                               
        $virtualTradingUpdate["set"] = array(
            "trade_status" => $tradingStatus,
            "trade_end_time" => date("Y-m-d H:i:s", time()),
        );
                
        $virtualTradingUpdate["where"] = array(
            "virtual_serial_number" => $virtual_serial_number
        );
        $virtualTradingUpdateResult = $this->update($virtualTradingUpdate);
        
        if ($virtualTradingUpdateResult["state"] != 1)
        {
            $result["state"] = "0";
            $result["msg"] = "FAILED";
            $result["errorMsg"] = $virtualTradingUpdateResult["errorMsg"];           
            return $result;
        }
        
        if($virtualTradingUpdateResult["count"] == 0)
        {
            $result["state"] = "0";
            $result["msg"] = "FAILED";
            $result["errorMsg"] = "子账户交易序列号:[".$virtual_serial_number."]不存在";
            return $result;
        }
               
        return $result;
    }

    //创建子账户新的交易记录
    public function createNewTrading($data)
    {
        $virtualTradingInsert["set"] = array(
            "virtual_serial_number" => $data->virtual_serial_number,
            "payer_account_no" => $data->payer_account_no,
            "payer_account_name" => $data->payer_account_name,
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
            "trade_status" => self::TRADING_STATUS_INIT,
            "trade_usage" => "", // ???接口中缺少usage
            "trade_start_time" => date("Y-m-d H:i:s", time()),
            "trade_end_time" => "",
            "trade_amount" => $data->trade_amount,
            "freeze_period" => $data->freeze_period,
            "fee" => "",
            "message" => ""
        );
        
        return $this->insert($virtualTradingInsert);
    }
    
    //根据交易序列号返回交易信息，注：data是 引用传递
    public function getTradingInfo(&$data)
    {        
        $result["result_code"] = "1";
        $result["result_message"] = "操作成功";
        
        $selectQuery["where"] = array(
            "virtual_serial_number" => $data->virtual_serial_number,
        );
        
        $virtualTradingSelectResult = $this->selectOne($selectQuery);
                
        if ($virtualTradingSelectResult["data"] == null) {
            $result["result_code"] = "2";
            $result["result_message"] = "交易号不存在";
            return $result;
        }
        
        $virtualTrading = $virtualTradingSelectResult["data"];
        
        $data->payer_account_no = $virtualTrading->payer_account_no;
        $data->payer_account_name = $virtualTrading->payer_account_name;
        $data->payer_bank = $virtualTrading->payer_bank;
        $data->payer_bank_branch = $virtualTrading->payer_bank_branch;
        $data->payer_cl_ring_no = $virtualTrading->payer_cl_ring_no;
        $data->payee_account_name = $virtualTrading->payee_account_name;
        $data->payee_account_no = $virtualTrading->payee_account_no;
        $data->payee_bank = $virtualTrading->payee_bank;
        $data->payee_bank_branch = $virtualTrading->payee_bank_branch;
        $data->payee_bank_branch = $virtualTrading->payee_bank_branch;
        $data->payee_cl_ring_no = $virtualTrading->payee_cl_ring_no;
        $data->trade_type = $virtualTrading->trade_type;
        $data->trade_way = $virtualTrading->trade_way;
        $data->trade_status = $virtualTrading->trade_status;
        $data->trade_usage = $virtualTrading->trade_usage;
        $data->trade_start_time = $virtualTrading->trade_start_time;
        $data->trade_end_time = $virtualTrading->trade_end_time;
        $data->trade_amount = $virtualTrading->trade_amount;
        $data->freeze_period = $virtualTrading->freeze_period;
        $data->fee = $virtualTrading->fee;
        $data->message = $virtualTrading->message;
        
        return $result;
    }

    //获取用户下所有账户的交易记录    
    public function getAllUserTradingInfo($data)
    {       
        
        $page= !empty($data->page) ? intval($data->page) : 1;
        $rows= !empty($data->rows) ? intval($data->rows) : 10;
        $sort= !empty($data->sort) ? $data->sort : 'virtual_trading_id';
        $order= !empty($data->order) ? $data->order : 'desc';
               
        $pagedQuery= array();
        $pagedQuery["join"]  = array(
            'virtual_account' =>array(
                'name'=>'tb_virtual_account',
                'on' => VirtualTrading::TABLE_NAME.'.payer_account_no='.VirtualAccount::TABLE_NAME.'.virtual_account_no',
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

    //获取子账户交易记录
    public function getVirtualTradingInfo($data)
    {
        $page= !empty($data->page) ? intval($data->page) : 1;
        $rows= !empty($data->rows) ? intval($data->rows) : 10;
        $sort= !empty($data->sort) ? $data->sort : 'virtual_trading_id';
        $order= !empty($data->order) ? $data->order : 'desc';

        $pagedQuery= array();
        $pagedQuery["join"]  = array(
            'virtual_account' =>array(
                'name'=>'tb_virtual_account',
                'on' => VirtualAccount::TABLE_NAME.'.virtual_account_no='.VirtualTrading::TABLE_NAME.'.payer_account_no',
                'columns'=>array(
                    'group_account_id'=>"group_account_id",
                ),
            ),
        );
        $where= new Where();
        if (!empty($data->trade_status)) {
            $where->andPredicate(new Operator("trade_status", Operator::OP_EQ, $data->trade_status));
        }
        if(!empty($data->group_account_id)){
            $where->addPredicate(new Operator("group_account_id", Operator::OP_EQ, $data->group_account_id));
        }
        if (!empty($data->virtual_account_no)) {
            $where->andPredicate(new Operator("payer_account_no", Operator::OP_EQ, $data->virtual_account_no));
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
