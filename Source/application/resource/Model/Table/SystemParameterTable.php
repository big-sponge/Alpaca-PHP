<?php
namespace Model\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Alpaca\Db\Table\AbstractTable;

// ZEND DB 中文教程 
// http://zend-framework-2.yangfanweb.cn/blog/381
 
class SystemParameterTable extends AbstractTable
{
 	public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
  
    //生成子账户流水号
    public function generateVirturlSerialNumber()
    {
        $this->begin();
        $tableResult=$this->sql("SELECT * from tb_system_parameter where `key`='group_serial_number'for UPDATE");

        $resultData = $tableResult["data"]->toArray();
        
        if (empty($resultData)) {                
            $insert["set"] = array(
                "name"=>"子账户交易流水表",
                "key"=>"group_serial_number",
                "value"=>serialize(array(
                    "date"=>date("Y-m-d",time()),
                    "flow"=>1,                   
                )),               
            );  
            $this->insert($insert);
            $flow = 1;
        }else{
            $value = unserialize($resultData[0]['value']);     

            if($value["date"] == date("Y-m-d",time())){
                $value["flow"] = $value["flow"] + 1;
            }else{
                $value["flow"] = 1;
                $value["date"] = date("Y-m-d",time());
            }
                        
            $update["set"] = array(
                "value"=>serialize($value),
            );
            $update["where"] = array(
                "key"=>"group_serial_number",
            );  
            $this->update($update);
            
            $flow = $value["flow"];
        }
       
        $this->commit();
        
        $flow = sprintf(date("YmdHis",time()).'%06d', $flow);
        return $flow;
    }
}
