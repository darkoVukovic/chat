<?php namespace App\Libraries;

use Predis\Client;
use stdClass;

class RedisService {
    
    public $redisClient;
    public $instance = null;

    public function instance() {
        if(is_null($this->instance)) {
            $this->instance = new RedisService();
        }
        return $this->instance;
    }

    public function __construct() {
        $this->redisClient = new Client();
        $this->redisClient->auth('2801996710092redacar');

    }

    public function installNavigation($id, $data) {
        $this->redisClient->hmset('navigation', $id, json_encode($data));
    }

    public function createHash ($name) {
    
    } 

    public function getHash($name) {
        return $this->redisClient->hgetall($name);
    }

    public function getDecodedHash($name) {
        $items =  $this->redisClient->hgetall($name);
        $newItems = [];
        foreach($items as $item) {
            $newItems[] = JSON_decode($item, 1);
        }
        return $newItems;
    }

    // add for single room 
    public function addUserCount ($count) {
        $this->redisClient->set('totalUserCount', $count);
    } 

    public function changeUserStatus($id, $active) {
                $redisField = 'userId:'.$id;
                $user = $this->redisClient->hgetall($redisField);
                $user['active']  = $active;
                
                $this->updateUser($user, $id);
    }

    public function checkStatus ($id) {
        $redisField = 'userId:'.$id;
        $user = $this->redisClient->hgetall($redisField);

        return $user['active'];
    } 
    
    public function insertUser($username ,$password,  $email, $active=1) {
        $id = $this->generateId();
        $data = [
            'id' => $id,
            'username' => $username,
            'password' => md5($password),
            'email' => $email,
            'active' => $active
        ];
        $userId = 'userId:'.$id;
        $this->redisClient->hmset($userId, $data);

        $this->redisClient->hset('users', $username, $id);

    }

    public function updateUser($data, $id) {
        $userId = 'userId:'.$id;
        $this->redisClient->hmset($userId, $data);

    }

    public function generateId() {
        $id = mt_rand(0, 1000);
        if($this->redisClient->hgetall($id)) return $this->generateId();
        return $id;
    }


   public function checkUser($username, $password) {
        $users = $this->redisClient->hgetall('users');
        $userId = '';
        foreach($users as $currentUsername => $id) {
            if($username === $currentUsername) {
                $userId = $id;
                break;
            }  
        }
        if($userId == '') {
            $msgConstruct = new stdClass();
            $msgConstruct->msg = 'invalid username or password';
            $msgConstruct->type  = 2;
            return MessagingProtocl::getInstance()->error($msgConstruct);
        }

        if($getUserData = $this->redisClient->hgetall("userId:$userId")) {
            if($username == $getUserData['username'] && md5($password) == $getUserData['password']) {
                return $getUserData['id'];
            }
            else {
                $msgConstruct = new stdClass();
                $msgConstruct->msg = 'invalid username or password';
                $msgConstruct->type  = 2;
                return MessagingProtocl::getInstance()->error($msgConstruct);
            }
        }
        else {
            $msgConstruct = new stdClass();
            $msgConstruct->msg = 'invalid username or password';
            $msgConstruct->type  = 2;
            return MessagingProtocl::getInstance()->error($msgConstruct);
        }
        
        return false;
    }
    public function getUsername($id) {
        
        return $this->redisClient->hget("userId:$id", 'username');
        
    }

    public function get ($key) {
        return $this->redisClient->get($key);
    } 

    public function removeUser($id) {
        $users = $this->redisClient->hgetall('users');
        foreach($users as $key => $user) {
            $userId = substr($key, 7);
            if($userId == $id) $this->redisClient->hdel('users', $userId);
            
        }
    }

}