<?php namespace App\Controllers;


require __DIR__ .'../../../vendor/autoload.php';


use App\Controllers\BaseController;
use App\Libraries\RedisService;
use Predis\Client;

class Dashboard extends BaseController
{
    public $template;
    public function index()
    {

        
        $redis = new RedisService();
        $navigationItems = $redis->getDecodedHash('navigation');
        $navigationItem = [];
        if(empty($navigationItem)) {
          // create navigation in redis 
           
        }
        foreach($navigationItems as $item) {
            if($item['name'] == 'logout') continue;
            $navigationItem[] = $item['name'];
        }
        $this->template['navigation'] = $navigationItem;
        //provera za login TODO
        $this->template['view'] = 'dashboard';
        return view('index', $this->template);
    }
}
