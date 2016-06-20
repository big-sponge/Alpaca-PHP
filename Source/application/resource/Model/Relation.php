<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Relation extends Model
{

	protected $table = 'tb_relation';

	public $timestamps = false;

    public static function test(){
        echo "ffff";
    }

    public static function insertRelation($array){

    	$reutrn_data = array();

    	$relation = new Relation;

    	foreach ($array as $key => $value) {
    		  $relation->$key = $value;
    	}

    	$result = $relation->save();
    	$reutrn_data["return_code"] = $result;
    	$reutrn_data["return_inserId"] = empty($result) ? 0 : $relation->id;

    	return $reutrn_data;

    }
}