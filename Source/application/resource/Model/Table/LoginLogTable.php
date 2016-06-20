<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;



// ZEND DB 中文教程 

// http://zend-framework-2.yangfanweb.cn/blog/381
 
class LoginLogTable extends AbstractTable
{

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    public function test()
    {
        echo "LoginLogTable OK";
    }
}