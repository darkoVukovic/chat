<?php namespace App\Libraries;

use App\Controllers\BaseController;
use App\Libraries\RedisService;
class MY_Controller extends BaseController {

    public $template;
    public $loggedIn = false;
    public function __construct() {

        
        $redis = new RedisService();
        $navigationItems = $redis->getDecodedHash('navigation');
        $navigationItem = [];
        foreach($navigationItems as $item) {
            if($item['name'] == 'logout') continue;
            $navigationItem[] = $item['name'];
        }
        $this->template['navigation'] = $navigationItem;
    }
}