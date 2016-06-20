<?php
namespace Model\Table;

use Model\Model\GroupAccount;
use Model\Model\VirtualEngine;
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;
 
class VirtualEngineTable extends AbstractTable
{

    const ACCOUNT_STATUS_NORMAL = 1;   //账户状态 1-正常
    const ACCOUNT_STATUS_FROZEN = 2;   //账户状态 2-冻结
    const ACCOUNT_STATUS_CLOSE = 3;    //账户状态 3-销户

 	public  $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    //获取没有使用的虚拟引擎（group_account_id 字段为空）
    public function getCaymanURLByEngineId($virtual_engine_id)
    {
        $result["result_code"] = "1";
        $result["result_message"] = "获取成功！";

        $selectQuery["where"] = array("virtual_engine_id"=>$virtual_engine_id);
        $veResult = $this->selectOne($selectQuery);

        if(empty($veResult["data"])){
            $result["result_code"] = "72";
            $result["result_message"] = "获取虚拟引擎配置失败，请联系系统管理员。";
            return $result;
        }

        if(!empty($veResult["data"]->group_account_id)){
            $result["result_code"] = "73";
            $result["result_message"] = "虚拟引擎配置已经使用，请联系系统管理员。";
            return $result;
        }

        $result["caymanURL"] = "http://".$veResult["data"]->ip.":".$veResult["data"]->port."/".$veResult["data"]->url."/";
        return $result;
    }

    public function createNewVirtualEngine($data)
    {
        $entityInsert["set"] = array(
            "project_name" => $data->project_name,
            "group_account_id" => $data->group_account_id,
            "ip" => $data->ip,
            "port" => $data->port,
            "url" => $data->url,
            "ip_address" => $data->ip_address,
            "status"=>self::ACCOUNT_STATUS_NORMAL
        );

        return $this->insert($entityInsert);
    }

    public function getById($virtual_engine_id)
    {
        $selectQuery["where"] = array(
            "virtual_engine_id"=>$virtual_engine_id,
        );
        return $this->selectOne($selectQuery);
    }

    public function getVirtualEngineDetailForAdminEdit($where){
        $result["state"] = "1";
        $result["result_message"] = "查找成功";
        $result["data"]= null;

        $selectQuery= array();
        $selectQuery["join"]  = array(
            'group_account' =>array(
                'name'=>'tb_group_account',
                'on' =>VirtualEngine::TABLE_NAME.'.group_account_id='.GroupAccount::TABLE_NAME.'.group_account_id',
                'columns'=>array(
                    'group_account_name'=>"group_account_name",
                    'group_account_no'=>"group_account_no",
                    'open_bank'=>"open_bank",
                    'open_bank_branch'=>"open_bank_branch",
                ),
            ),
        );

        $selectQuery["where"] = $where;
        return $this->selectOne($selectQuery);
    }

    public function getVirtualEngineDetailInfoEdit($data)
    {
        $selectQuery["where"]=array(
            'virtual_engine_id'=>$data->virtual_engine_id,
        );
        return $this->selectOne($selectQuery);
    }

        public function deleteVirtualEngineDetailInfo($data)
    {
        $updateQuery["where"]=array(
            'virtual_engine_id'=>$data->virtual_engine_id,
        );
        return $this->update($updateQuery);
    }

//    public function deleteVirtualEngineDetailInfo($data)
//    {
//        $deleteQuery=array(
//            'virtual_engine_id'=>$data->virtual_engine_id,
//        );
//        return $this->delete($deleteQuery);
//    }

}