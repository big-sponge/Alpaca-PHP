<?php
namespace Model\Common;

class ResultMsg
{
    private static $MSG_ARRAY = array(
        "test1"=>"参数错误，[%s0]不能为空",
        "test2"=>"测试2",
        //code=1
        "success"=>"操作成功",
        "search_success"=>"查询成功",
        "update_success"=>"更新成功",
        "param_right"=>"参数正确",
        //code=2
        "fail"=>"操作失败",
        "update_fail"=>"更新失败",
        //code=51
        "timeout"=>"登录超时，请重新登录",
        //code=52
        "no_authority"=>"没有权限",
        //code=61
        "name_exist"=>"用户名已经存在",
        "not_null"=>"参数错误：[%s0]不能为空。",
        //code=71
        "call_manager"=>"系统错误,请尽快联系管理员",
        //code=99
        "sys_err"=>"系统错误",
        //other text
        "id"=>"身份证",
        "passport"=>"护照",
        "entity_id_type_business_licence"=>"营业执照",
        "business_licence"=>"营业执照",
        "entity_id_type_organization_code"=>"组织机构代码证",
        "entity_id_type_credit_code"=>"统一社会信用代码",
        "user_check_status_checked"=>"已认证",
        "user_check_status_unchecked"=>"未认证",
        "personal"=>"个人",
        "company"=>"企业",
        "user_normal"=>"正常",
        "user_forbid"=>"禁用",
        "user_close"=>"注销",
        'account_type_group'=>"监管账户用户",
        'account_type_virtual'=>"子账户用户",
        'account_type_group_virtual'=>"监管账户子账户",
        'payer_payee_account_same'=>"付款账户与收款账户相同",
        'payer_payee_account_same_group'=>"付款账户与收款账户监管账户不同",
        'virtual_account_not_exist'=>"子账户不存在",
        'merchant_exist'=>"商户已存在",
        'user_not_exist'=>"用户不存在",
        'user_virtual_account_not_suit'=>"用户与子账户不对应",
    );

    /**
     * 获取相应字符串
     * @param $key
     * @param $values array(value1, value2) 没有参数的时候设置为null
     * 参数会一次替换字符串中的%s0、%s1...
     * @return mixed
     */
    public static function getMsg($key, $values = null)
    {
        $replace_str_pre = "%s";
        $result = self::$MSG_ARRAY[$key];
        if($values == null){
            return $result;
        }
        $i = 0;
        foreach($values as $val){
            $replace_str = $replace_str_pre.$i;
            $result = str_replace($replace_str, $val, $result);
            $i++;
        }
        return $result;
    }
}
