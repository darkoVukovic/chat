<?php namespace App\Controllers;

use App\Libraries\MY_Controller;
use App\Libraries\RedisService;

class Login extends MY_Controller {
   public $redisClient;

    
   public function index() {
      
    helper('form');

    $this->template['view'] = 'login';
    if($this->request->getPost('username') !== null && $this->request->getPost('password') !== null) {
      $redisClient = new RedisService();
      $getUser = $redisClient->checkUser($this->request->getPost('username'), $this->request->getPost('password'));
      if($getUser && $getUser > 0)  {
         $this->redisClient = new \App\Libraries\RedisService;

         $this->redisClient->changeUserStatus($getUser, 1);

         return redirect()->to('chat/'.$getUser);
      }
    }
    return view('index', $this->template);
   }


}
