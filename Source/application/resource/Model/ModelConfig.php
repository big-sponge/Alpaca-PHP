<?php
namespace Model;

use Model\Model\BankAccount;
use Model\Model\BindBankRecord;
use Model\Model\Entity;
use Model\Model\Example;
use Model\Model\GroupAccount;
use Model\Model\GroupBill;
use Model\Model\GroupTrading;
use Model\Model\LoginLog;
use Model\Model\Merchant;
use Model\Model\OperationLog;
use Model\Model\PersonalInfo;
use Model\Model\RelationAccount;
use Model\Model\UserAdmin;
use Model\Model\UserSysRecord;
use Model\Model\UserTradeRecord;
use Model\Model\VirtualAccount;
use Model\Model\VirtualAccountAuthorize;
use Model\Model\VirtualBill;
use Model\Model\VirtualEngine;
use Model\Model\VirtualTrading;
use Model\Table\BankAccountTable;
use Model\Table\BindBankRecordTable;
use Model\Table\ExampleTable;
use Model\Table\GroupAccountTable;
use Model\Table\GroupBillTable;
use Model\Table\GroupTradingTable;
use Model\Table\LoginLogTable;
use Model\Table\MerchantTable;
use Model\Table\OperationLogTable;
use Model\Table\PersonalInfoTable;
use Model\Table\RelationAccountTable;
use Model\Table\UserAdminTable;
use Model\Table\UserSysRecordTable;
use Model\Table\UserTradeRecordTable;
use Model\Table\VirtualAccountAuthorizeTable;
use Model\Table\VirtualAccountTable;
use Model\Table\VirtualBillTable;
use Model\Table\VirtualEngineTable;
use Model\Table\VirtualTradingTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Model\Table\UserTable;
use Model\Model\User;
use Model\Table\EntityTable;
use Model\Model\SystemParameter;
use Model\Table\SystemParameterTable;

use Model\Model\PayOrder;
use Model\Table\PayOrderTable;


class ModelConfig
{
    public function getFactories()
    {
        return array(
            'factories' => array(
                'Model\Table\LoadAllTables' => function ($sm)
                {
                    $tables = array();
                    $tables['userTable'] = $sm->get('Model\Table\UserTable');
                    $tables['bankAccountTable'] = $sm->get('Model\Table\BankAccountTable');
                    $tables['bindBankRecordTable'] = $sm->get('Model\Table\BindBankRecordTable');
                    $tables['entityTable'] = $sm->get('Model\Table\EntityTable');
                    $tables['exampleTable'] = $sm->get('Model\Table\ExampleTable');
                    $tables['groupAccountTable'] = $sm->get('Model\Table\GroupAccountTable');
                    $tables['groupBillTable'] = $sm->get('Model\Table\GroupBillTable');
                    $tables['groupTradingTable'] = $sm->get('Model\Table\GroupTradingTable');
                    $tables['loginLogTable'] = $sm->get('Model\Table\LoginLogTable');
                    $tables['operationLogTable'] = $sm->get('Model\Table\OperationLogTable');
                    $tables['personalInfoTable'] = $sm->get('Model\Table\PersonalInfoTable');
                    $tables['relationAccountTable'] = $sm->get('Model\Table\RelationAccountTable');
                    $tables['virtualAccountTable'] = $sm->get('Model\Table\VirtualAccountTable');
                    $tables['virtualBillTable'] = $sm->get('Model\Table\VirtualBillTable');
                    $tables['virtualEngineTable'] = $sm->get('Model\Table\VirtualEngineTable');
                    $tables['virtualTradingTable'] = $sm->get('Model\Table\VirtualTradingTable');
                    $tables['systemParameterTable'] = $sm->get('Model\Table\SystemParameterTable');
                    $tables['userAdminTable'] = $sm->get('Model\Table\UserAdminTable');
                    $tables['userSysRecordTable'] = $sm->get('Model\Table\UserSysRecordTable');
                    $tables['userTradeRecordTable'] = $sm->get('Model\Table\UserTradeRecordTable');
                    $tables['virtualAccountAuthorizeTable'] = $sm->get('Model\Table\VirtualAccountAuthorizeTable');
                    $tables['merchantTable'] = $sm->get('Model\Table\MerchantTable');
                    $tables['payOrderTable'] = $sm->get('Model\Table\PayOrderTable');
                    return $tables;
                },
                
                'Model\Table\adapter' => function ($sm)
                {
                    return $sm->get('Zend\Db\Adapter\Adapter');
                },
                'Model\Table\UserTable' => function ($sm)
                {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_user', $dbAdapter, null, $resultSetPrototype);
                    $table = new UserTable($tableGateway);
                    return $table;
                },

                'Model\Table\PayOrderTable' => function ($sm)
                {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new PayOrder());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_pay_order', $dbAdapter, null, $resultSetPrototype);
                    $table = new PayOrderTable($tableGateway);
                    return $table;
                },
                
                'Model\Table\SystemParameterTable' => function ($sm)
                {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new SystemParameter());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_system_parameter', $dbAdapter, null, $resultSetPrototype);
                    $table = new SystemParameterTable($tableGateway);
                    return $table;
                },
                 
                'Model\Table\BankAccountTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new BankAccount());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_bank_account', $dbAdapter, null, $resultSetPrototype);
                    $table = new BankAccountTable($tableGateway);
                    return $table;
                },
                'Model\Table\BindBankRecordTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new BindBankRecord());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_bind_bank_record', $dbAdapter, null, $resultSetPrototype);
                    $table = new BindBankRecordTable($tableGateway);
                    return $table;
                },

                'Model\Table\EntityTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entity());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_entity', $dbAdapter, null, $resultSetPrototype);
                    $table = new EntityTable($tableGateway);
                    return $table;
                },

                'Model\Table\ExampleTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Example());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_example', $dbAdapter, null, $resultSetPrototype);
                    $table = new ExampleTable($tableGateway);
                    return $table;
                },

                'Model\Table\GroupAccountTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new GroupAccount());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_group_account', $dbAdapter, null, $resultSetPrototype);
                    $table = new GroupAccountTable($tableGateway);
                    return $table;
                },

                'Model\Table\GroupBillTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new GroupBill());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_group_bill', $dbAdapter, null, $resultSetPrototype);
                    $table = new GroupBillTable($tableGateway);
                    return $table;
                },

                'Model\Table\GroupTradingTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new GroupTrading());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_group_trading', $dbAdapter, null, $resultSetPrototype);
                    $table = new GroupTradingTable($tableGateway);
                    return $table;
                },

                'Model\Table\LoginLogTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new LoginLog());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_login_log', $dbAdapter, null, $resultSetPrototype);
                    $table = new LoginLogTable($tableGateway);
                    return $table;
                },

                'Model\Table\OperationLogTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new OperationLog());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_operation_log', $dbAdapter, null, $resultSetPrototype);
                    $table = new OperationLogTable($tableGateway);
                    return $table;
                },

                'Model\Table\PersonalInfoTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new PersonalInfo());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_personal_info', $dbAdapter, null, $resultSetPrototype);
                    $table = new PersonalInfoTable($tableGateway);
                    return $table;
                },

                'Model\Table\RelationAccountTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new RelationAccount());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_relation_account', $dbAdapter, null, $resultSetPrototype);
                    $table = new RelationAccountTable($tableGateway);
                    return $table;
                },

                'Model\Table\VirtualAccountTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new VirtualAccount());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_virtual_account', $dbAdapter, null, $resultSetPrototype);
                    $table = new VirtualAccountTable($tableGateway);
                    return $table;
                },

                'Model\Table\VirtualBillTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new VirtualBill());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_virtual_bill', $dbAdapter, null, $resultSetPrototype);
                    $table = new VirtualBillTable($tableGateway);
                    return $table;
                },

                'Model\Table\VirtualEngineTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new VirtualEngine());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_virtual_engine', $dbAdapter, null, $resultSetPrototype);
                    $table = new VirtualEngineTable($tableGateway);
                    return $table;
                },

                'Model\Table\VirtualTradingTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new VirtualTrading());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_virtual_trading', $dbAdapter, null, $resultSetPrototype);
                    $table = new VirtualTradingTable($tableGateway);
                    return $table;
                },

                'Model\Table\UserAdminTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserAdmin());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_user_admin', $dbAdapter, null, $resultSetPrototype);
                    $table = new UserAdminTable($tableGateway);
                    return $table;
                },

                'Model\Table\UserSysRecordTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserSysRecord());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_user_sys_record', $dbAdapter, null, $resultSetPrototype);
                    $table = new UserSysRecordTable($tableGateway);
                    return $table;
                },

                'Model\Table\UserTradeRecordTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserTradeRecord());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_user_trade_record', $dbAdapter, null, $resultSetPrototype);
                    $table = new UserTradeRecordTable($tableGateway);
                    return $table;
                },

                'Model\Table\VirtualAccountAuthorizeTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new VirtualAccountAuthorize());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_virtual_account_authorize', $dbAdapter, null, $resultSetPrototype);
                    $table = new VirtualAccountAuthorizeTable($tableGateway);
                    return $table;
                },

                'Model\Table\MerchantTable' =>  function($sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Merchant());
                    $dbAdapter = $sm->get('Model\Table\adapter');
                    $tableGateway = new TableGateway('tb_merchant', $dbAdapter, null, $resultSetPrototype);
                    $table = new MerchantTable($tableGateway);
                    return $table;
                },
            )
        )
        ;
    }
}
