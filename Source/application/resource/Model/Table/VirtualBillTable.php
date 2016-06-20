<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class VirtualBillTable extends AbstractTable
{
    const TRADE_PAYER = 1;          //付款
    const TRADE_PAYEE = 2;          //收款
    const TRADE_IN = 3;             //充值
    const TRADE_OUT = 4;            //提现
    const TRADE_PROFIT = 5;         //结息
    
 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    //添加付款账单
    public function addPayerBill($data){
        
        if(empty($data->payer_usage)){
            $data->payer_usage="";
        }
        
        if(empty($data->payer_trade_type)){
            $data->payer_trade_type=self::TRADE_PAYER;
        }
        
        $virtualBillInsert["set"]=array(
            "virtual_account_id"=>$data->payer_account_id,
            "virtual_serial_number"=>$data->virtual_serial_number,
            "trade_time"=>date("Y-m-d H:i:s",time()),
            "trade_type"=>$data->payer_trade_type,
            "amount"=>$data->trade_amount,
            "account_balance"=>$data->payer_account_total_balance,
            "opposite_account_type"=>$data->payee_account_type,
            "opposite_account_no"=>$data->payee_account_no,
            "opposite_account_name"=>$data->payee_account_name,
            "direction"=>'2',
            "usage"=>$data->payer_usage,
        
        );
        $virtualBillInsertResult = $this->insert($virtualBillInsert);
        
        return $virtualBillInsertResult;
    }
    
    //添加收款账单
    public function addPayeeBill($data){

        if(empty($data->payer_usage)){
            $data->payee_usage="";
        }
        
        if(empty($data->payee_trade_type)){
            $data->payee_trade_type=self::TRADE_PAYEE;
        }
        
        $virtualBillInsert["set"] = array(
            "virtual_account_id" => $data->payee_account_id,
            "virtual_serial_number" => $data->virtual_serial_number,
            "trade_time" => date("Y-m-d H:i:s", time()),
            "trade_type" => $data->payee_trade_type,
            "amount" => $data->trade_amount,
            "account_balance" => $data->payee_account_total_balance,
            "opposite_account_type" => $data->payer_account_type,
            "opposite_account_no" => $data->payer_account_no,
            "opposite_account_name" => $data->payer_account_name,
            "direction" => '1',
            "usage" => $data->payee_usage,
        );
        $virtualBillInsertResult = $this->insert($virtualBillInsert);
        
        return $virtualBillInsertResult;
    }
}