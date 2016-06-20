<?php

namespace Model\Common;


class Constant
{
    const DATE_FORMAT = "Y-m-d H:i:s";//时间日期的格式
    const LOG_FILE_PATH = "logs/";//log文件存储目录

    //用户账户类型
    const ACCOUNT_TYPE_GROUP = 1;//监管账户用户
    const ACCOUNT_TYPE_VIRTUAL = 2;//子账户用户
    const ACCOUNT_TYPE_GROUP_VIRTUAL = 3;//监管账户子账户

    //用户类型
    const USER_TYPE_PERSONAL = 1;//个人
    const USER_TYPE_BUSINESS = 2;//企业  

    //用户角色
    const USER_ROLE_MANAGER = 1;//管理员
    const USER_ROLE_NORMAL = 2;//用户

    //用户注册来源
    const REGISTRATION_SOURCE_SYSTEM = 1;//系统注册
    const REGISTRATION_SOURCE_BATCH = 2;//批量开户

    //用户状态
    const USER_STATUS_OPEN = 1;//正常
    const USER_STATUS_FORBIDDEN = 2;//禁用
    const USER_STATUS_CLOSE = 3;//注销

    //用户证件类型
    const USER_ID_TYPE_ID = 1;//身份证
    const USER_ID_TYPE_PASSPORT = 2;//护照

    //实体证件类型
    const ENTITY_ID_TYPE_BUSINESS_LICENCE = 1;//营业执照
    const ENTITY_ID_TYPE_ORGANIZATION_CODE = 2;//组织机构代码证
    const ENTITY_ID_TYPE_CREDIT_CODE = 3;//统一社会信用代码

    //实体类型
    const ENTITY_TYPE_PERSONAL = 1;//个人
    const ENTITY_TYPE_BUSINESS = 2;//企业

    //监管账户状态
    const GROUP_ACCOUNT_STATUS_OPEN = 1;//正常
    const GROUP_ACCOUNT_STATUS_FREEZE = 2;//冻结
    const GROUP_ACCOUNT_STATUS_CLOSE = 3;//销户

    //关联账户状态
    const RELATION_ACCOUNT_STATUS_OPEN = 1;//正常
    const RELATION_ACCOUNT_STATUS_FREEZE = 2;//冻结
    const RELATION_ACCOUNT_STATUS_CLOSE = 3;//销户

    //子账户类型
    const VIRTUAL_ACCOUNT_TYPE_PERSONAL = 1;//个人账户
    const VIRTUAL_ACCOUNT_TYPE_PUBLIC = 2;//对公账户
    const VIRTUAL_ACCOUNT_TYPE_INCOME = 3;//收益账户
    const VIRTUAL_ACCOUNT_TYPE_FREEZE = 4;//冻结账户

    //子账户状态
    const VIRTUAL_ACCOUNT_STATUS_OPEN = 1;//正常
    const VIRTUAL_ACCOUNT_STATUS_FREEZE = 2;//冻结
    const VIRTUAL_ACCOUNT_STATUS_CLOSE = 3;//销户
    const VIRTUAL_ACCOUNT_STATUS_NOT_ACTIVE = 4;//未激活

    //银行账户类型
    const BANK_ACCOUNT_TYPE_PERSONAL = 1;//个人
    const BANK_ACCOUNT_TYPE_PUBLIC = 2;//对公

    //子账户交易种类
    const VIRTUAL_TRADE_TYPE_INNER = 1;//转内部
    const VIRTUAL_TRADE_TYPE_SAME_BANK = 2;//转同行
    const VIRTUAL_TRADE_TYPE_DIF_BANK = 3;//转外行
    const VIRTUAL_TRADE_TYPE_RECHARGE = 4;//充值
    const VIRTUAL_TRADE_TYPE_CASH = 5;//提现
    const VIRTUAL_TRADE_TYPE_SETTLEMENT = 6;//结息

    //子账户交易方式
    const VIRTUAL_TRADE_WAY_DIRECT = 1;//直接付款
    const VIRTUAL_TRADE_WAY_FREEZE = 2;//冻结付款

    //子账户交易状态
    const VIRTUAL_TRADE_STATUS_FINISH = 1;//交易完成
    const VIRTUAL_TRADE_STATUS_FAILED = 2;//交易失败
    const VIRTUAL_TRADE_STATUS_FREEZE = 3;//交易冻结

    //监管账户交易种类
    const GROUP_TRADE_TYPE_INNER = 1;//子账户内部
    const GROUP_TRADE_TYPE_SAME_BANK = 2;//子账户转同行
    const GROUP_TRADE_TYPE_DIF_BANK = 3;//子账户转外行
    const GROUP_TRADE_TYPE_RECHARGE = 4;//充值
    const GROUP_TRADE_TYPE_CASH = 5;//提现

    //监管账户交易方式
    const GROUP_TRADE_WAY_DIRECT = 1;//直接付款
    const GROUP_TRADE_WAY_FREEZE = 2;//冻结付款

    //监管账户交易状态
    const GROUP_TRADE_STATUS_FINISH = 1;//已完成
    const GROUP_TRADE_STATUS_FAILED = 2;//交易失败
    const GROUP_TRADE_STATUS_FREEZE = 3;//冻结中

    //子账户账单明细-交易类型
    const VIRTUAL_BILL_TRADE_TYPE_RECHARGE = 1;//充值
    const VIRTUAL_BILL_TRADE_TYPE_CASH = 2;//提现
    const VIRTUAL_BILL_TRADE_TYPE_COLLECTIONS = 3;//收款
    const VIRTUAL_BILL_TRADE_TYPE_PAY = 4;//付款
    const VIRTUAL_BILL_TRADE_TYPE_REBATE = 5;//退款

    //子账户账单明细-对方账户类型
    const VIRTUAL_BILL_OPPOSITE_ACCOUNT_ENTITY = 1;//实体账户
    const VIRTUAL_BILL_OPPOSITE_ACCOUNT_VIRTUAL = 2;//虚拟子账户

    //子账户账单明细-出入金标记
    const VIRTUAL_BILL_DIRECTION_IN = 1;//入金
    const VIRTUAL_BILL_DIRECTION_OUT = 2;//出金

    //监管账户账单明细-交易类型
    const GROUP_BILL_TRADE_TYPE_RECHARGE = 1;//充值
    const GROUP_BILL_TRADE_TYPE_CASH = 2;//提现
    const GROUP_BILL_TRADE_TYPE_COLLECTIONS = 3;//收款
    const GROUP_BILL_TRADE_TYPE_PAY = 4;//付款
    const GROUP_BILL_TRADE_TYPE_REBATE = 5;//退款

    //监管账户账单明细-出入金标记
    const GROUP_BILL_DIRECTION_IN = 1;//入金
    const GROUP_BILL_DIRECTION_OUT = 2;//出金

    //Cayman引擎状态
    const VIRTUAL_ENGINE_IN_USE = 1;//使用中
    const VIRTUAL_ENGINE_STOP = 2;//停用

    //商户状态
    const MERCHANT_STATUS_OPEN = 1;//正常
    const MERCHANT_STATUS_FORBIDDEN = 2;//禁用
    const MERCHANT_STATUS_CLOSE = 3;//注销

    //商户类型
    const MERCHANT_TYPE_PERSONAL = 1;//个人
    const MERCHANT_TYPE_COMPANY = 2;//企业

    //商户证件类型
    const MERCHANT_ID_TYPE_ID = 1;//身份证
    const MERCHANT_ID_TYPE_BUSINESS_LICENCE = 2;//营业执照

}