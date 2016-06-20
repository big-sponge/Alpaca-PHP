<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;



// ZEND DB 中文教程 

// http://zend-framework-2.yangfanweb.cn/blog/381
 
class RelationAccountTable extends AbstractTable
{

    const ACCOUNT_STATUS_NORMAL = 1;
    const ACCOUNT_STATUS_FROZEN = 2;
    const ACCOUNT_STATUS_CLOSE = 3;

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    public function test()
    {
        echo "RelationAccountTable OK";
    }

    public function createNewRelationAccount($data)
    {
        $relationAccountInsert["set"] = array(
            "relation_account_name" => $data->relation_account_name,
            "relation_account_no" => $data->relation_account_no,
            "balance" => $data->balance,
            "status" => self::ACCOUNT_STATUS_NORMAL,
            "id_type" => $data->id_type,
            "id_no" => $data->id_no,
            "id_file_path" => $data->id_file_path
        );

        return $this->insert($relationAccountInsert);
    }
}