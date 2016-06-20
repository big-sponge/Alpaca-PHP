<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Domain extends Model
{

	protected $table = 'tb_domain';

	public $timestamps = false;

    public static function test(){
        echo "ffff";
    }



    public static function insertDomain($array){

    	$reutrn_data = array();

    	$domain = new Domain;

    	foreach ($array as $key => $value) {
    		  $domain->$key = $value;
    	}

    	$result = $domain->save();
    	$reutrn_data["return_code"] = $result;
    	$reutrn_data["return_inserId"] = empty($result) ? 0 : $domain->id;
     
    	return $reutrn_data;

    }

    	 
}