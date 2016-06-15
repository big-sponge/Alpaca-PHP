<?php
namespace Service\JwtAuth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Alpaca\Factory\ServerManager;
class JwtManager
{
	
	protected $config = []; 
	
	protected static $instance;

	function __construct()
	{

		$config = ServerManager::factory()->get('config');
	 	
		$this->config = $config['jwt'];

	}
	 

	public function creatToken($data) 
	{  	

		if (empty($data)) {
			return false;
		}
		if (is_array($data)) {
			$this->config = array_merge($this->config,$data);
		}
 
		$signer = new Sha256();
        $token = (new Builder())
                        ->setIssuer($this->config['issuer']) // Configures the issuer (iss claim)
                        ->setAudience($this->config['audience']) // Configures the audience (aud claim)
                        ->setId($this->config['id'], true) // Configures the id (jti claim), replicating as a header item
                        ->setIssuedAt($this->config['iat']) // Configures the time that the token was issue (iat claim)
                        ->setNotBefore($this->config['nbf']) // Configures the time that the token can be used (nbf claim)
                        ->setExpiration($this->config['exp']) // Configures the expiration time of the token (nbf claim)
                        ->sign($signer, $this->config['secret']) // creates a signature using "testing" as key
                        ->getToken(); // Retrieves the generated token

 
        return $token; // The string representation of the object is a JWT string (pretty easy, right?)
	} 


	public function parserToekn($token)
	{
		 
        $tokenInfo = (new Parser())->parse(($token)); // Parses from a string

        if ($tokenInfo->getClaim('exp') < time()) {
   			
   			return false;
        }
        
       
    	return $tokenInfo;

	}



	public static function jwt()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new jwtManager();
        }
        return self::$instance;
    }
}

