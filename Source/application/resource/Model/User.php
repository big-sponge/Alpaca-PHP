<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{

	protected $table = 'tb_user';

	public $timestamps = false;

    public static function test(){
        echo "ffff";
    }


    public static function insertUser($array){

    	$reutrn_data = array();

    	$user = new User;

    	foreach ($array as $key => $value) {
    		  $user->$key = $value;
    	}

    	$result = $user->save();
    	$reutrn_data["return_code"] = $result;
    	$reutrn_data["return_inserId"] = empty($result) ? 0 : $user->id;

    	return $reutrn_data;

    }
}