<?php
namespace Alpaca\Tools;
/**
 * 验证类
 * 
 * @package    
 */
Class Validate{
    
    const NOTNULL   = 1<<0;
    const EMAIL     = 1<<1;    
    const PHONE     = 1<<2;   
    const MOBILE    = 1<<3;   
    const URL       = 1<<4;    
    const CURRENCY  = 1<<5;    
    const NUMBER    = 1<<6;    
    const ZIP       = 1<<7;    
    const QQ        = 1<<8;   
    const INTEGER   = 1<<9;
    const DOUBLE    = 1<<10;    
    const CHINESE   = 1<<11;
    
    public static $instance;
       
	/**
	 * 验证规则
	 *
	 * @var array
	 */
	private $validator = array(
		"email"=>'/^([.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-])+/',
		"phone"=>'/^(([0-9]{2,3})|([0-9]{3}-))?((0[0-9]{2,3})|0[0-9]{2,3}-)?[1-9][0-9]{6,7}(-[0-9]{1,4})?$/',
		"mobile"=>'/^1[0-9]{10}$/',
		"url"=>'/^http:(\\/){2}[A-Za-z0-9]+.[A-Za-z0-9]+[\\/=?%-&_~`@\\[\\]\':+!]*([^<>\"\"])*$/',
		"currency"=>'/^[0-9]+(\\.[0-9]+)?$/',
		"number"=>'/^[0-9]+$/',
		"zip"=>'/^[0-9][0-9]{5}$/',
		"qq"=>'/^[1-9][0-9]{4,8}$/',
		"integer"=>'/^[-+]?[0-9]+$/',
		"integerpositive"=>'/^[+]?[0-9]+$/',
		"double"=>'/^[-+]?[0-9]+(\\.[0-9]+)?$/',
		"doublepositive"=>'/^[+]?[0-9]+(\\.[0-9]+)?$/',
		"english"=>'/^[A-Za-z]+$/',
		"chinese"=>'/^[\x80-\xff]+$/',
		"nochinese"=>'/^[A-Za-z0-9_-]+$/',
	);
	
	private $errorMessage = array(
	    "email"=>'email 格式不正确',
	    "phone"=>'phone 格式不正确',
	    "mobile"=>'mobile 格式不正确',
	    "url"=>'url 格式不正确',
	    "currency"=>'currency 格式不正确',
	    "number"=>'number 格式不正确',
	    "zip"=>'zip 格式不正确',
	    "qq"=>'qq 格式不正确',
	    "integer"=>'integer 格式不正确',
	    "integerpositive"=>'integerpositive 格式不正确',
	    "double"=>'double 格式不正确',
	    "doublepositive"=>'doublepositive 格式不正确',
	    "english"=>'english 格式不正确',
	    "chinese"=>'chinese 格式不正确',
	    "nochinese"=>'nochinese 格式不正确',
	);
	

	public function check($value,$reg)
	{
	    $result['code'] = 1;
	    $result['message'] = 'OK';
	    
	    if(($reg &self::NOTNULL) == null){
	        
	        if($value == null){	             
	            $result['code'] = 0;
	            $result['message'] = "参数不能为空。";
	            return $result;
	        }
	    }

	    if(($reg & self::EMAIL) == self::EMAIL){
	         
	        if(!preg_match($this->validator['email'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['email'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::PHONE) == self::PHONE){
	         
	        if(!preg_match($this->validator['phone'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['phone'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::MOBILE) == self::MOBILE){
	         
	        if(!preg_match($this->validator['mobile'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['mobile'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::URL) == self::URL){
	         
	        if(!preg_match($this->validator['url'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['url'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::CURRENCY) == self::CURRENCY){
	         
	        if(!preg_match($this->validator['currency'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['currency'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::NUMBER) == self::NUMBER){
	         
	        if(!preg_match($this->validator['number'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['number'];
	            return $result;
	        }
	    }
	    if(($reg &self::ZIP) == self::ZIP){
	         
	        if(!preg_match($this->validator['zip'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['zip'];
	            return $result;
	        }
	    }
	    if(($reg &self::QQ) == self::QQ){
	         
	        if(!preg_match($this->validator['qq'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['qq'];
	            return $result;
	        }
	    }
	    if(($reg &self::INTEGER) == self::INTEGER){
	         
	        if(!preg_match($this->validator['integer'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['integer'];
	            return $result;
	        }
	    }
	    if(($reg &self::DOUBLE) == null){
	         
	        if(!preg_match($this->validator['double'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['double'];
	            return $result;
	        }
	    }
	    
	    if(($reg &self::CHINESE) == self::CHINESE){
	    
	        if(!preg_match($this->validator['chinese'], $value) ){
	            $result['code'] = 0;
	            $result['message'] = $this->errorMessage['chinese'];
	            return $result;
	        }
	    }

	    return $result;	        
	}
	
	public static function verify($value,$reg)
	{
	    
	   return self::getInstance()->check($value, $reg);	     
	}
	
	private static function getInstance()
	{
	    if(!self::$instance){
	        self::$instance = new Validate();
	    }
	    return self::$instance;
	}
}

