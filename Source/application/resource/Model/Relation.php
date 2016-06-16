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
}