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
}