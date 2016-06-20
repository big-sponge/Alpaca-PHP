<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class UserTradeRecordTable extends AbstractTable
{

 	public $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getUserTradeRecordInfo($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["where"] = $where;
        return $this->select($selectQuery);
    }

    public function getUserTradeRecordInfoGroup($user_id)
    {
        return $tableResult=$this->sql("SELECT * from tb_user_trade_record WHERE user_trade_date in(SELECT user_trade_date FROM tb_user_trade_record WHERE user_id = '".$user_id."' GROUP BY user_trade_date) AND tb_user_trade_record.user_id = '".$user_id."' ORDER BY user_trade_date DESC, user_trade_time DESC");
//        return $tableResult=$this->sql("SELECT * from tb_user_trade_record WHERE user_id = ".$user_id);
    }
}