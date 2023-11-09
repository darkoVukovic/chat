<?php namespace App\Controllers;

use App\Libraries\MY_Controller;
use App\Libraries\RedisService;
use App\Libraries\Errors;
class Chat extends MY_Controller
{
    public function index($id = false)
    {
        if(!$id) return redirect()->to('login');
        $redis = new RedisService();
        $user = $redis->getUsername($id);
        if(is_null($user)) return redirect()->to('login');
        
        if($redis->checkStatus($id) == 0)  return redirect()->to('login');

        $navigationItems = $redis->getDecodedHash('navigation');
        $navigationItem = [];
        foreach($navigationItems as $item) {
            if($item['name'] == 'logout') continue;
            $navigationItem[] = $item['name'];
        }
        $this->template['navigation'] = $navigationItem;    
        $this->template['view'] = 'chat';
        return view('index', $this->template);
    }
    public function test () {
        echo "test";
    } 
}
