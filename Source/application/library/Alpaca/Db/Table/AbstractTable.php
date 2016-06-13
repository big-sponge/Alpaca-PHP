<?php
namespace Alpaca\Db\Table;
 
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

//Cheng , Base table. 
class AbstractTable
{
    public  $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }    
       
    //插入示例
    public function insert($insertQuery)
    {    
        $result=array(
            "state"=>"1",
            "count" => "0",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );
        try {                        
            $result["count"]=$this->tableGateway->insert($insertQuery["set"]);           
            $result["insertId"] = $this->tableGateway->adapter->getDriver()->getConnection()->getLastGeneratedValue();
            
        } catch (\Exception $e) {
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();
        }
        return $result;
    } 
             
    //修改示例,如果是空就插入一条
    public function update($updateQuery,$insertIfNull=false)
    {
        
        $result=array(
            "state"=>"1",
            "count" => "0",
            "msg" => "SUCCESS",
            "errorMsg" => null,
        );    
       
        try {  
            $result["count"]=$this->tableGateway->update($updateQuery["set"],$updateQuery["where"]);  
            
            if($result["count"]==0)
            {
                $result["state"]="0";
                $result["msg"]="修改失败，没有找到对应字段";                
            }
            
            if($insertIfNull==true && $result["COUNT"]==0)
            {
                $insertQuery["set"]=array_merge($updateQuery["where"], $updateQuery["set"]);
                $result = $this->insert($insertQuery);
                if($result["state"]==1)
                {
                    $result["state"]="3";
                    $result["msg"]="修改失败，没有找到对应字段，已经插入新的字段，插入成功。";                
                }
            }            
        } catch (\Exception $e) {    
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();               
        }       
        return $result;
    }
    
    //查询单个,如果没有查到则创建
    public function selectOrInsert($selectQuery,$insertQuery)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "sqlStr"=>"",
            "count" => "0",
            "data"=>null,
        );
    
        $result = $this->select($selectQuery);
    
        if ($result["count"] != 0) {
            $result["data"] = $result["data"][0];
            return $result;
        }
               
        //不存在时创建        
        $result=$this->insert($insertQuery);        
        $result["created"] = TRUE;
        
        return $result;
    }
        
    //查询第一个
    public function selectFirst($selectQuery)
    {            
        $result = $this->select($selectQuery);
        
        if ($result["count"] != 0) {
            $result["data"] = $result["data"][0];
        }else{
            $result["data"] = null;
        }
        return $result;
    }
        
    //简单查询示例
    public function select($selectQuery)
    {
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "sqlStr"=>"",
            "count" => "0",
            "data"=>null,
        );
        
        $sqlStr="";
        
        try {
            $rowset = $this->tableGateway->select(function (Select $select) use($selectQuery, &$sqlStr)
            {                
                // Join
                if(!empty($selectQuery["join"]))
                {
                    foreach ($selectQuery["join"] as $j)
                    {
                        $col = (!empty($j['columns'])) ? $j['columns'] : null;
                        $type = (!empty($j['type'])) ? $j['type'] : 'left';
                        $select->join($j['name'],$j['on'],$col,$type);
                    }
                }
                
                //where
                if (!empty($selectQuery["where"])) {
                    $select->where($selectQuery["where"]);
                }
                                
                //Group
                if (!empty($selectQuery["group"])) {
                    $select->group($selectQuery["group"]);
                }
                
                $sqlStr = $this->tableGateway->getSql()->getSqlStringForSqlObject($select);
            });
            $data = array();
            foreach ($rowset as $row)
            {
                array_push($data, $row);
            }
            
            $result["count"] = count($data);;
            $result["data"] = $data;
            $result["sqlStr"] = $sqlStr;
                                                         
        }catch (\Exception $e) {
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();
            $result["sqlStr"] = $sqlStr;           
        }
        return $result;
    }
       
    //通用分页查询示例,简单where条件，like，join，paged，order    
    public function selectPaged($selectQuery)
    {    
        $result=array(
            "state"=>"1",
            "msg" => "SUCCESS",
            "errorMsg" => null,
            "count" => "0",
            "total" => "0",
            "data"=>null,
        );
        try {
            $rowset=$this->tableGateway->select(function (Select $select) use($selectQuery)
            {    
                // From
                if (!empty($selectQuery["from"])) {
                    $select->from($selectQuery["from"]);
                }
                
                // Join
                if(!empty($selectQuery["join"]))
                {
                    foreach ($selectQuery["join"] as $j)
                    {
                        $col = (!empty($j['columns'])) ? $j['columns'] : null;
                        $type = (!empty($j['type'])) ? $j['type'] : 'left';
                        $select->join($j['name'],$j['on'],$col,$type);
                    }
                }
                
                // Where
                if (!empty($selectQuery["where"])) {
                    $select->where($selectQuery["where"]);
                }                 
                               
                //Paged
                if(!empty($selectQuery["paged"])){
                    $paged = $selectQuery["paged"];                     
                    $select->offset( ($paged["page"]-1) * $paged["size"]);
                    $select->limit($paged["size"]);
                }
                
                //Order
                if(!empty($selectQuery["order"])){                    
                    foreach ($selectQuery["order"] as $o)
                    {
                        $select->order($o["sort"]." ".$o["order"]);
                    }
                }

                //Group
                if (!empty($selectQuery["group"])) {
                    $select->group($selectQuery["group"]);
                }

                //Having
                if (!empty($selectQuery["having"])) {
                    $select->group($selectQuery["having"]);
                }
                
                //debug sql string.
                //die($this->tableGateway->getSql()->getSqlStringForSqlObject($select));   // output sqlString
            });
           
            $data = array();
            foreach ($rowset as $row)
            {
                array_push($data, $row);
            }
            $result["count"] = count($data);;
            $result["data"] = $data;

            //total
            if(!empty($selectQuery["paged"])){
                $result["total"]=$this->tableGateway->select(function (Select $select) use($selectQuery)
                {
                    // Join
                    if(!empty($selectQuery["join"]))
                    {
                        foreach ($selectQuery["join"] as $j)
                        {
                            $col = (!empty($j['columns'])) ? $j['columns'] : null;
                            $type = (!empty($j['type'])) ? $j['type'] : 'left';
                            $select->join($j['name'],$j['on'],$col,$type);
                        }
                    }
                    // Where
                    if (!empty($selectQuery["where"])) {
                        $select->where($selectQuery["where"]);
                    }
                })->count();
            }else {
                $result["total"] = $result["count"];
            }
        } catch (\Exception $e) {
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();
        }
        return $result;
    }

    //删除示例
    public function delete($query)
    {
        
        $result=array(
            "state"=>"1",
            "count" => "0",
            "Msg" => "SUCCESS",
            "errorMsg" => null,
            "data" => null,
        );
        
        try { 
            $result["data"] =  $this->tableGateway->delete($query);                     
        } catch (\Exception $e) {
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();
        }
        
        return $result; 
    }
    
    //直接执行SQL语句
    public function sql($query)
    {
        
        $result=array(
            "state"=>"1",
            "count" => "0",
            "Msg" => "SUCCESS",
            "errorMsg" => null,
            "data" => null,
        );
        
        try {
            $adapter = $this->tableGateway->getAdapter();
            $result["data"] = $adapter->query($query,'execute');
                      
        } catch (\Exception $e) {
            $result["state"]="0";
            $result["msg"]="ERROR";
            $result["errorMsg"] = $e->getMessage();
        }
        
        return $result; 
    }
    
    //开启事物
    public function begin()
    {
        $adapter = $this->tableGateway->getAdapter();
        return $adapter->getDriver()->getConnection()->beginTransaction();
    }

    //事物回滚
    public function rollback()
    {                
        $adapter = $this->tableGateway->getAdapter();
        return $adapter->getDriver()->getConnection()->rollback();
    }
    
    //事物提交
    public function commit()
    {
        $adapter = $this->tableGateway->getAdapter();
        return $adapter->getDriver()->getConnection()->commit();
    }
}