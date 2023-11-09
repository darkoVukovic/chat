<?php namespace App\Controllers\api\v1;

use App\Libraries\RedisService;
use App\Libraries\MY_Controller;


class Users extends MY_Controller
{
    public $redis;

    public function index () {
        $redis = new RedisService();
        return $redis->get('totalUserCount');
        
    } 


}
