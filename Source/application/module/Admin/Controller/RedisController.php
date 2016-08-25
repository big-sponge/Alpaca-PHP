<?php
namespace Admin\Controller;

use Redis\Redis;

class RedisController
{
    public function testAction()
    {
        //字符串        
        $arr_keys = Redis::redis()->keys('*');      
        var_dump($arr_keys);        
        foreach ($arr_keys as $key){            
            $key_name = $key;
            $key_type = '';
            $key_value = '';
            switch (Redis::redis()->type($key)){
                case 0:
                    $key_type = 'none';
                    $key_value = 'null';
                    break;
                case 1:
                    $key_type = 'string';
                    $key_value = Redis::redis()->get($key);
                    break;
                case 2:
                    $key_type = 'set';
                    $key_value = Redis::redis()->sMembers($key);
                    break;
                case 3:
                    $key_type = 'list';
                    $key_value = Redis::redis()->lrange($key,0,Redis::redis()->lLen($key)-1);
                    break;
                case 4:
                    $key_type = 'zset';
                    $key_value = Redis::redis()->zRange($key,0,Redis::redis()->zCount($key)-1);
                    break;
                case 5:
                    $key_type = 'hash';
                    $key_value = Redis::redis()->hGetAll($key);
                    break;
            }
            var_dump($key_name,$key_type,$key_value);
        }
    }
}