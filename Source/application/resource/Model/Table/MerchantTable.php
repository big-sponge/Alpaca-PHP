<?php
namespace Model\Table;
 
use Model\Model\Merchant;
use Model\Model\User;
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class MerchantTable extends AbstractTable
{

 	public $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getMerchantDetailInfoForEdit($where)
    {
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'entity' =>array(
                'name'=>'tb_user',
                'on' =>Merchant::TABLE_NAME.'.user_id='.User::TABLE_NAME.'.user_id',
                'columns'=>array(
                    'user_email'=>"email",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }

}