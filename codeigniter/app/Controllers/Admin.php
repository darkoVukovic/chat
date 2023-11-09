<?php namespace App\Controllers;

use App\Libraries\RedisService;

class Admin extends BaseController
{
    public $redisClient;
    public $template;

    
    public function getClient() {
        helper('form');
        return $this->redisClient = new RedisService;
    }

    public function index()
    {
        
    }

   public function navigation() {

    $this->template['view'] = 'navigation';
    return view('index', $this->template);
   }

   public function create() {
    $this->getClient();

    if($this->request->getPost('navigationName') !== null) {
        
        $navigationItems = $this->getClient()->getHash('navigation');
        if(count($navigationItems) > 0) {
            $latestId = array_search(max($navigationItems), $navigationItems);
            foreach($navigationItems as $item) {
                $jsonToArr = JSON_decode($item, 1);
                if(in_array($this->request->getPost('navigationName'), $jsonToArr))  {
                    return 'already exists';
                }
            }
        }
        else $latestId = 0;
    
        $latestId++;
        $data = [
            'id' => $latestId,
            'name' => $this->request->getPost('navigationName')
        ];

        $this->getClient()->installNavigation($latestId, $data);
    }

    $this->template['view'] = 'create';
    return view('index', $this->template);
   }
   
}   
