<?php namespace App\Controllers;

use App\Libraries\RedisService;
use App\Libraries\MY_Controller;

class Registration extends MY_Controller
{
    
   public function index() {
      helper('form');
    $this->template['view'] = 'registration';

      if($this->request->getPost('username') !== null && $this->request->getPost('password') != null && $this->request->getPost('email') != null) {
         $redisClient = new RedisService();
         $redisClient->insertUser($this->request->getPost('username'),$this->request->getPost('password') , $this->request->getPost('email'));
      } 
   
    return view('index', $this->template);
   }


}
