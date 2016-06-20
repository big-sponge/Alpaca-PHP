<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;


class EntityTable extends AbstractTable
{
    const ENTITY_TYPE_PERSONAL = 1;    //实体类型 1-个人
    const ENTITY_TYPE_COMPANY = 2;     //实体类型 2-企业

 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    //查找实体，如果不存在则创建新实体
    public function create($data)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );

        $id = 0;
        $selectQuery["where"]=array(
            'entity_type'=>$data->entity_type,
            'id_type'=>$data->id_type,
            'id_no'=>$data->id_no,
        );
   
        $insertQuery["set"]=array(
            'entity_name'=>$data->entity_name,
            'entity_type'=>$data->entity_type,
            'id_type'=>$data->id_type,
            'id_no'=>$data->id_no,
            "register_time"=>date('Y-m-d H:i:s',time())
        );

        $result = $this->selectOrInsert($selectQuery,$insertQuery);
           if(!empty($result['created'])){
               //$result['insertId'];
            }else if(!empty($result['data'])){
               $result['insertId'] = $result['data']->entity_id;
            }

        return $result;
    }

    public function getAllEntityDetailInfoEdit($data)
    {
        $selectQuery["where"]=array(
            'entity_id'=>$data->entity_id,
        );
        return $this->selectOne($selectQuery);
    }
}